<?php

namespace App\UseCases\PurchaseOrders;

use App\DataTransferObjects\PurchaseOrders\CreatePurchaseOrderDTO;
use App\Domain\Mappers\ContractIdMapper;
use App\Domain\Mappers\UserIdMapper;
use App\Domain\ValueObjects\AmountInCents;
use App\Domain\ValueObjects\Date;
use App\Enums\ActionEnum;
use App\Enums\CreditModalityEnum;
use App\Enums\CreditUsageTypeEnum;
use App\Enums\ProcessEnum;
use App\Enums\StatusEnum;
use App\Models\CreditLimitBalance;
use App\Models\Installment;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\TotalMonthlyInstallment;
use App\Repositories\CreditLimitBalanceRepository;
use App\Repositories\HistoryRepository;
use App\Repositories\InstallmentHistoryRepository;
use App\Repositories\PurchaseOrderHistoryRepository;
use App\Repositories\PurchaseOrderItemHistoryRepository;
use App\Repositories\PurchaseOrderItemRepository;
use App\Repositories\PurchaseOrderRepository;
use App\Repositories\TotalMonthlyInstallmentHistoryRepository;
use App\Repositories\TotalMonthlyInstallmentRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class CreatePurchaseOrderUseCase {

    private CreditLimitBalanceRepository $credit_limit_balance_repository;
    private PurchaseOrderRepository $purchase_order_repository;
    private PurchaseOrderItemRepository $purchase_order_item_repository;
    private PurchaseOrderHistoryRepository $purchase_order_history_repository;
    private PurchaseOrderItemHistoryRepository $purchase_order_item_history_repository;
    private HistoryRepository $history_repository;
    private InstallmentHistoryRepository $installment_history_repository;
    private TotalMonthlyInstallmentRepository $total_monthly_installment_repository;
    private TotalMonthlyInstallmentHistoryRepository $total_monthly_installment_history_repository;

    public function __construct(
        CreditLimitBalanceRepository $credit_limit_balance_repository,
        PurchaseOrderRepository $purchase_order_repository,
        PurchaseOrderItemRepository $purchase_order_item_repository,
        PurchaseOrderHistoryRepository $purchase_order_history_repository,
        PurchaseOrderItemHistoryRepository $purchase_order_item_history_repository,
        HistoryRepository $history_repository,
        InstallmentHistoryRepository $installment_history_repository,
        TotalMonthlyInstallmentRepository $total_monthly_installment_repository,
        TotalMonthlyInstallmentHistoryRepository $total_monthly_installment_history_repository
    ){
        $this->credit_limit_balance_repository = $credit_limit_balance_repository;
        $this->purchase_order_repository = $purchase_order_repository;
        $this->purchase_order_item_repository = $purchase_order_item_repository;
        $this->purchase_order_history_repository = $purchase_order_history_repository;
        $this->purchase_order_item_history_repository = $purchase_order_item_history_repository;
        $this->history_repository = $history_repository;
        $this->installment_history_repository = $installment_history_repository;
        $this->total_monthly_installment_repository = $total_monthly_installment_repository;
        $this->total_monthly_installment_history_repository = $total_monthly_installment_history_repository;
    }
    
    public function handle(CreatePurchaseOrderDTO $create_purchase_order_dto){
        $action_date = Date::fromString($create_purchase_order_dto->getHeader()['action_date']);
        $contract_id = ContractIdMapper::fromContractMasterCod($create_purchase_order_dto->getPurchaseOrderData()['contract_master_cod']);
        $total = AmountInCents::fromFloat($create_purchase_order_dto->getPurchaseOrderData()['total'])->value();
        $this->checkLimits(
            $action_date,
            $contract_id,
            $total,
            $create_purchase_order_dto->getInstallments()
        );
        return $this->create($create_purchase_order_dto, $action_date, $contract_id);
    }

    private function create(CreatePurchaseOrderDTO $create_purchase_order_dto, Date $action_date, int $contract_id){
        $user_id = UserIdMapper::fromUserMasterCod($create_purchase_order_dto->getPurchaseOrderData()['user_master_cod']);
        
        $credit_limit_balance = $this->getCreditLimitBalance(
            $action_date->format('m'),
            $action_date->format('Y'),
            $contract_id,
            CreditModalityEnum::ACQUISITION->value
        );

        $history_id = $this->createHistory(
            Date::fromCarbon(Carbon::now()),
            'gerou compra',
            $user_id,
            ActionEnum::PURCHASE_GENERATED->value,
            ProcessEnum::EXTERNAL_PURCHASE_ORDER_CREATION->value,
            $contract_id
        );

        $purchase_order = $this->createPurchaseOrder(
            AmountInCents::fromFloat($create_purchase_order_dto->getPurchaseOrderData()['total'])->value(),
            $create_purchase_order_dto->getPurchaseOrderData()['external_identifier'],
            $create_purchase_order_dto->getPurchaseOrderData()['purchase_order_type_id'],
            ContractIdMapper::fromContractMasterCod($create_purchase_order_dto->getPurchaseOrderData()['contract_master_cod']),
            $create_purchase_order_dto->getPurchaseOrderData()['external_display_id'],
            StatusEnum::PENDING->value,
            $create_purchase_order_dto->getPurchaseOrderData()['total_items'],
            AmountInCents::fromFloat($create_purchase_order_dto->getPurchaseOrderData()['cif'])->value(),
            AmountInCents::fromFloat($create_purchase_order_dto->getPurchaseOrderData()['fob'])->value(),
            $user_id,
            $create_purchase_order_dto->getPurchaseOrderData()['supplier_id'],
            AmountInCents::fromFloat($create_purchase_order_dto->getPurchaseOrderData()['discount'])->value(),
            $create_purchase_order_dto->getPurchaseOrderData()['payment_nature_id'],
            $create_purchase_order_dto->getPurchaseOrderData()['payment_method_id'],
            $create_purchase_order_dto->getPurchaseOrderData()['installment_quantity']
        );
        
        $this->createPurchaseOrderHistory($purchase_order, $history_id, $credit_limit_balance);

        foreach ($create_purchase_order_dto->getMaterials() as $key => $material) {
            $purchase_order_item = $this->createPurchaseOrderItem(
                $material['external_material_id'],
                $material['material'],
                $material['unit_amount'],
                $material['total_amount'],
                $material['quantity'],
                $purchase_order->id,
                $purchase_order->contract_id
            );
            $this->createPurchaseOrderItemHistory($purchase_order_item, $history_id);
        }
        
        $installments = $this->createInstallments($purchase_order, $create_purchase_order_dto->getInstallments());
        
        $this->createInstallmentHistories($installments, $history_id);
        
        $total_monthly_installment = $this->createTotalMonthlyInstallments($installments, $history_id);

        return true;
    }

    private function createPurchaseOrder(
        int $total,
        int $external_identifier,
        int $purchase_order_type_id,
        int $contract_id,
        int $external_display_id,
        int $status_id,
        int $total_items,
        int $cif,
        int $fob,
        int $user_id,
        int $supplier_id,
        int $discount,
        int $payment_nature_id,
        int $payment_method_id,
        int $installments_number
    ){
        return $this->purchase_order_repository->create(
            $total,
            $external_identifier,
            $purchase_order_type_id,
            $contract_id,
            $external_display_id,
            $status_id,
            $total_items,
            $cif,
            $fob,
            $user_id,
            $supplier_id,
            $discount,
            $payment_nature_id,
            $payment_method_id,
            $installments_number
        );
    }

    private function createPurchaseOrderHistory(
        PurchaseOrder $purchase_order,
        int $history_id,
        CreditLimitBalance $credit_limit_balance
    ){
        return $this->purchase_order_history_repository->create(
            $history_id,
            $purchase_order->id,
            $purchase_order->total,
            $purchase_order->external_identifier,
            $purchase_order->purchase_order_type_id,
            $credit_limit_balance->credit_limit_id,
            $purchase_order->contract_id,
            $purchase_order->external_display_id,
            $purchase_order->status_id,
            $purchase_order->total_items,
            $purchase_order->cif,
            $purchase_order->fob,
            $purchase_order->user_id,
            $purchase_order->supplier_id,
            $purchase_order->discount,
            $purchase_order->payment_nature_id,
            $purchase_order->payment_method_id,
            $purchase_order->installments_number
        );
    }

    private function createPurchaseOrderItem(
        int $external_material_id,
        string $material,
        int $unit_amount,
        int $total_amount,
        int $quantity,
        int $purchase_order_id,
        int $contract_id
    ){
        return $this->purchase_order_item_repository->create(
            $external_material_id,
            $material,
            $unit_amount,
            $total_amount,
            $quantity,
            $purchase_order_id,
            $contract_id
        );
    }

    private function createPurchaseOrderItemHistory(
        PurchaseOrderItem $purchase_order_item,
        int $history_id
    ){
        return $this->purchase_order_item_history_repository->create(
            $history_id,
            $purchase_order_item->id,
            $purchase_order_item->external_material_id,
            $purchase_order_item->material,
            $purchase_order_item->unit_amount,
            $purchase_order_item->total_amount,
            $purchase_order_item->quantity,
            $purchase_order_item->purchase_order_id,
            $purchase_order_item->contract_id
        );
    }

    private function checkLimits(
        Date $purchase_order_action_date,
        int $contract_id,
        int $purchase_order_total_in_cents,
        array $installments
    ){
        $credit_limit_balance_aquisition = $this->getCreditLimitBalance(
            $purchase_order_action_date->format('m'),
            $purchase_order_action_date->format('Y'),
            $contract_id,
            CreditModalityEnum::ACQUISITION->value
        );
        $credit_limit_balance_payment = $this->getCreditLimitBalance(
            $purchase_order_action_date->format('m'),
            $purchase_order_action_date->format('Y'),
            $contract_id,
            CreditModalityEnum::PAYMENT->value
        );

        $this->checkAquisitionBalance($credit_limit_balance_aquisition, $purchase_order_total_in_cents);
        $this->checkPaymentBalance($credit_limit_balance_payment, $installments);
        return true;
    }

    private function getCreditLimitBalance(
        $month,
        $year,
        $contract_id,
        $credit_modality_id
    ){
        return $this->credit_limit_balance_repository->getCreditLimitBalanceToCheck(
            $month,
            $year,
            $contract_id,
            CreditUsageTypeEnum::SUPPLY->value,
            $credit_modality_id
        );
    }

    private function checkAquisitionBalance(
        CreditLimitBalance $credit_limit_balance,
        int $purchase_order_total
    ){
        $balance = $credit_limit_balance->balance;
        return $this->validateBalance($purchase_order_total, $balance);
    }

    private function checkPaymentBalance(
        CreditLimitBalance $credit_limit_balance,
        array $installments
    ){
        $balance = $credit_limit_balance->balance;
        $payment_amount = $this->getInstallmentAmountForThisMonth($installments);
        return $this->validateBalance($payment_amount, $balance);
    }

    private function getInstallmentAmountForThisMonth(
        array $installments
    ){
        $installments_for_this_month = array_filter($installments, function($installment){
            return Date::fromString($installment['due_day'])->format('Y-m') == Carbon::now()->format('Y-m');
        });
        $total_amount = collect($installments_for_this_month)->sum('installment_amount');
        return AmountInCents::fromFloat($total_amount)->value();
    }
    
    private function validateBalance(
        int $total_amount,
        int $balance
    ){
        if($total_amount > $balance){
            throw new \Exception("Não há saldo suficiente para prosseguir!", 500);
        }
        return true;
    }

    private function createHistory(
        Date $date,
        ?string $observation = null,
        int $user_id,
        int $action_id,
        int $process_id,
        int $contract_id
    ){
        return $this->history_repository->create(
            $date->value(),
            $observation,
            $user_id,
            $action_id,
            $process_id,
            $contract_id
        )->id;
    }

    private function createInstallments(
        PurchaseOrder $purchase_order,
        array $installments
    ){        
        $sanitize_installments = $this->sanitizeInstallments($installments, $purchase_order->contract_id);
        return $purchase_order->installments()->createMany($sanitize_installments);
    }

    private function createInstallmentHistories(
        Collection $installments,
        int $history_id
    ){
        foreach ($installments as $key => $installment) {
            $this->installment_history_repository->create(
                $history_id,
                $installment->installment_amount,
                $installment->due_day,
                $installment->order,
                $installment->paid_at,
                $installment->amount_paid,
                $installment->external_identifier,
                $installment->installment_amount_type_id,
                $installment->installment_type_id,
                $installment->id,
                $installment->contract_id
            );
        }
    }

    private function createTotalMonthlyInstallments(
        Collection $installments,
        int $history_id
    ){
        
        $old_gross_amount = [];
        $new_gross_amount = [];
        $old_amount_paid = [];
        $new_amount_paid = [];

        foreach ($installments as $key => $installment) {

            $contract_id = $installment->contract_id;
            $year =  Date::fromCarbon($installment->due_day)->format('Y');
            $month =  Date::fromCarbon($installment->due_day)->format('m');
            $year_month = $year.'-'.$month.'-'.$key;

            $current_total_monthly_installment = $this->total_monthly_installment_repository->getByMonthAndYearAndContractId(
                $month,
                $year,
                $contract_id
            );

            if(!$current_total_monthly_installment){
                $old_gross_amount[$year_month] = 0;
                $old_amount_paid[$year_month] = 0;
                $this->total_monthly_installment_repository->create(
                    $installment->installment_amount,
                    0,
                    $month,
                    $year,
                    $contract_id
                );
                $new_gross_amount[$year_month] = $installment->installment_amount;
                $new_amount_paid[$year_month] = 0;
                continue;
            }

            $old_gross_amount[$year_month] = $current_total_monthly_installment->gross_amount;
            $old_amount_paid[$year_month] = $current_total_monthly_installment->amount_paid ?? 0;
            $this->total_monthly_installment_repository->updateById(
                $current_total_monthly_installment->id,
                [
                    "gross_amount" => $current_total_monthly_installment->gross_amount + $installment->installment_amount
                ]
            );
            $new_gross_amount[$year_month] = $current_total_monthly_installment->gross_amount + $installment->installment_amount;
            $new_amount_paid[$year_month] = $current_total_monthly_installment->amount_paid ?? 0;
        }
        
        $this->createTotalMonthlyInstallmentHistory($installments, $history_id, $old_gross_amount, $old_amount_paid, $new_gross_amount, $new_amount_paid);
    }

    private function createTotalMonthlyInstallmentHistory(
        Collection $installments,
        int $history_id,
        array $old_gross_amount,
        array $old_amount_paid,
        array $new_gross_amount,
        array $new_amount_paid
    ){

        foreach ($installments as $key => $installment) {
            $month = Date::fromCarbon($installment->due_day)->format('m');
            $year = Date::fromCarbon($installment->due_day)->format('Y');
            $contract_id = $installment->contract_id;
            $year_month = $year.'-'.$month.'-'.$key;

            $current_total_monthly_installment = $this->total_monthly_installment_repository->getByMonthAndYearAndContractId(
                $month,
                $year,
                $contract_id
            );
            
            $this->total_monthly_installment_history_repository->create(
                $history_id,
                $installment->id,
                $current_total_monthly_installment->id,
                $installment->installment_amount,
                $old_gross_amount[$year_month],
                $new_gross_amount[$year_month],
                0,
                $old_amount_paid[$year_month],
                $new_amount_paid[$year_month],
                $month,
                $year,
                $contract_id
            );
        }
    }

    private function sanitizeInstallments(
        array $installments,
        int $contract_id
    ){
        return array_map(function($installment) use ($contract_id){
            return [
                "installment_amount_type_id" => (int)$installment['installment_amount_type_id'],
                "order" => (int)$installment['order'],
                "installment_amount" => AmountInCents::fromFloat($installment['installment_amount'])->value(),
                "amount_paid" => 0,
                "installment_type_id" => (int)$installment['installment_type_id'],
                "due_day" => $installment['due_day'],
                "external_identifier" => (int)$installment['external_identifier'],
                "contract_id" => $contract_id
            ];
        }, $installments);
    }
}