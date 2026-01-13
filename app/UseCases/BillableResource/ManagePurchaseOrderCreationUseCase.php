<?php

namespace App\UseCases\BillableResource;

use App\DataTransferObjects\BillableResource\TransactionsDataDTO;
use App\DataTransferObjects\Histories\CreateHistoryDTO;
use App\DataTransferObjects\Installment\CreateInstallmentDTO;
use App\DataTransferObjects\InstallmentHistory\CreateInstallmentHistoryDTO;
use App\DataTransferObjects\PurchaseOrder\CreatePurchaseOrderDTO;
use App\DataTransferObjects\PurchaseOrderHistory\CreatePurchaseOrderHistoryDTO;
use App\DataTransferObjects\PurchaseOrderItem\CreatePurchaseOrderItemDTO;
use App\DataTransferObjects\PurchaseOrderItemHistory\CreatePurchaseOrderItemHistoryDTO;
use App\DataTransferObjects\TotalMonthlyInstallment\ManageTotalMonthlyInstallmentAcquisitionDTO;
use App\DataTransferObjects\TotalMonthlyInstallmentHistory\CreateTotalMonthlyInstallmentHistoryDTO;
use App\Domain\Contracts\BillableResource\BillableResourceInterface;
use App\Domain\Mappers\ContractIdMapper;
use App\Domain\Mappers\UserIdMapper;
use App\Domain\ValueObjects\AmountInCents;
use App\Domain\ValueObjects\CreditLimitBalanceSnapshot;
use App\Domain\ValueObjects\Date;
use App\Enums\ActionEnum;
use App\Enums\CreditModalityEnum;
use App\Enums\CreditPeriodTypeEnum;
use App\Enums\CreditUsageTypeEnum;
use App\Enums\ProcessEnum;
use App\Enums\TransactionTypeEnum;
use App\UseCases\Histories\CreateHistoryUseCase;
use App\UseCases\Installment\CreateInstallmentUseCase;
use App\UseCases\InstallmentHistory\CreateInstallmentHistoryUseCase;
use App\UseCases\PurchaseOrderHistory\CreatePurchaseOrderHistoryUseCase;
use App\UseCases\PurchaseOrderItem\CreatePurchaseOrderItemUseCase;
use App\UseCases\PurchaseOrderItemHistory\CreatePurchaseOrderItemHistoryUseCase;
use App\UseCases\PurchaseOrders\CreatePurchaseOrderUseCase;
use App\UseCases\TotalMonthlyInstallment\ManageTotalMonthlyInstallmentAcquisitionUseCase;
use App\UseCases\TotalMonthlyInstallmentHistory\CreateTotalMonthlyInstallmentHistoryUseCase;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class ManagePurchaseOrderCreationUseCase implements BillableResourceInterface{
    
    private CreatePurchaseOrderDTO $dto;
    private CreatePurchaseOrderUseCase $create_purchase_order_use_case;
    private CreatePurchaseOrderItemUseCase $create_purchase_order_item_use_case;
    private CreateInstallmentUseCase $create_installment_use_case;
    private ManageTotalMonthlyInstallmentAcquisitionUseCase $manage_total_monthly_installment_acquisition_use_case;
    private CreateHistoryUseCase $create_history_use_case;
    private CreatePurchaseOrderHistoryUseCase $create_purchase_order_history_use_case;
    private CreatePurchaseOrderItemHistoryUseCase $create_purchase_order_item_history_use_case;
    private CreateInstallmentHistoryUseCase $create_installment_history_use_case;
    private CreateTotalMonthlyInstallmentHistoryUseCase $create_total_monthly_installment_history_use_case;

    public function __construct(
        CreatePurchaseOrderUseCase $create_purchase_order_use_case,
        CreatePurchaseOrderItemUseCase $create_purchase_order_item_use_case,
        CreateInstallmentUseCase $create_installment_use_case,
        ManageTotalMonthlyInstallmentAcquisitionUseCase $manage_total_monthly_installment_acquisition_use_case,
        CreateHistoryUseCase $create_history_use_case,
        CreatePurchaseOrderHistoryUseCase $create_purchase_order_history_use_case,
        CreatePurchaseOrderItemHistoryUseCase $create_purchase_order_item_history_use_case,
        CreateInstallmentHistoryUseCase $create_installment_history_use_case,
        CreateTotalMonthlyInstallmentHistoryUseCase $create_total_monthly_installment_history_use_case
    ){
        $this->create_purchase_order_use_case = $create_purchase_order_use_case;
        $this->create_purchase_order_item_use_case = $create_purchase_order_item_use_case;
        $this->create_installment_use_case = $create_installment_use_case;
        $this->manage_total_monthly_installment_acquisition_use_case = $manage_total_monthly_installment_acquisition_use_case;
        $this->create_history_use_case = $create_history_use_case;
        $this->create_purchase_order_history_use_case = $create_purchase_order_history_use_case;
        $this->create_purchase_order_item_history_use_case = $create_purchase_order_item_history_use_case;
        $this->create_installment_history_use_case = $create_installment_history_use_case;
        $this->create_total_monthly_installment_history_use_case = $create_total_monthly_installment_history_use_case;
    }

    public function getCreditUsageTypeId(): int{
        return CreditUsageTypeEnum::SUPPLY->value;
    }

    public function getCreditModalityId(): int{
        return CreditModalityEnum::ACQUISITION->value;
    }

    public function getCreditPeriodTypeId(): int
    {
        return CreditPeriodTypeEnum::MONTHLY->value;
    }

    public function getAcquisitionCreditLimitBalanceSnapshot(): CreditLimitBalanceSnapshot
    {
        return $this->dto->getAcquisitionCreditLimitBalanceSnapshot();
    }

    public function getPaymentCreditLimitBalanceSnapshot(): CreditLimitBalanceSnapshot
    {
        return $this->dto->getPaymentCreditLimitBalanceSnapshot();
    }

    public function getActionDate(): Date{
        return Date::fromString($this->dto->getHeader()['action_date']);
    }

    public function getContractId(): int{
        return ContractIdMapper::fromContractMasterCod($this->dto->getPurchaseOrderData()['contract_master_cod']);
    }

    public function getTotalAmount(): int{
        return AmountInCents::fromFloat($this->dto->getPurchaseOrderData()['total'])->value();
    }

    public function getInstallments(): array{
        return $this->dto->getInstallments();
    }

    public function withData(CreatePurchaseOrderDTO $dto): self{
        $this->dto = $dto;
        return $this;
    }

    private function getUserId(){
        return UserIdMapper::fromUserMasterCod($this->dto->getPurchaseOrderData()['user_master_cod']);
    }

    public function execute(): TransactionsDataDTO
    {
        $context = $this->resolveContext();

        $history_id = $this->createHistory($context);

        $purchase_order = $this->createPurchaseOrder();
        
        $this->createPurchaseOrderHistory(
            $purchase_order,
            $history_id,
            $this->dto->getAcquisitionCreditLimitBalanceSnapshot()->credit_limit_id
        );

        $purchase_order_items = $this->createPurchaseOrderItems(
            $purchase_order,
            $context
        );

        $this->createPurchaseOrderItemsHistory(
            $purchase_order_items,
            $history_id
        );

        $installments = $this->createInstallments($purchase_order);

        $this->createInstallmentsHistory(
            $installments,
            $history_id
        );

        $total_monthly_installment = $this->createTotalMonthlyInstallment(
            $installments
        );

        $this->createTotalMonthlyInstallmentHistory(
            $total_monthly_installment,
            $history_id
        );

        return new TransactionsDataDTO(
            $purchase_order->total,
            TransactionTypeEnum::ACQUISITION->value,
            Date::fromCarbon(Carbon::now()),
            $this->getUserId(),
            $this->getContractId(),
            $this->dto->getAcquisitionCreditLimitBalanceSnapshot()->credit_limit_id,
            $this->dto->getAcquisitionCreditLimitBalanceSnapshot()->credit_limit_balance_id,
            null,
            $purchase_order->getMorphClass(),
            $purchase_order->id
        );
    }

    private function resolveContext(): array
    {
        $action_date = $this->getActionDate();

        return [
            'contract_id' => $this->getContractId(),
            'month'       => $action_date->format('m'),
            'year'        => $action_date->format('Y'),
            'user_id'     => $this->getUserId(),
            'action_date' => $action_date,
        ];
    }

    private function createHistory(array $context): int
    {
        return $this->create_history_use_case->handle(
            new CreateHistoryDTO(
                Carbon::now(),
                'gerou compra',
                $context['user_id'],
                ActionEnum::PURCHASE_GENERATED->value,
                ProcessEnum::EXTERNAL_PURCHASE_ORDER_CREATION->value,
                $context['contract_id']
            )
        )->id;
    }

    private function createPurchaseOrder()
    {
        return $this->create_purchase_order_use_case->handle($this->dto);
    }

    private function createPurchaseOrderHistory(
        $purchase_order,
        int $history_id,
        int $credit_limit_id
    ): void {
        $this->create_purchase_order_history_use_case->handle(
            new CreatePurchaseOrderHistoryDTO(
                $purchase_order,
                $history_id,
                $credit_limit_id
            )
        );
    }

    private function createPurchaseOrderItems(
        $purchase_order,
        array $context
    ) {
        return $this->create_purchase_order_item_use_case->handle(
            new CreatePurchaseOrderItemDTO(
                $this->dto->getMaterials(),
                $purchase_order->id,
                $context['contract_id']
            )
        );
    }

    private function createPurchaseOrderItemsHistory(
        $purchase_order_items,
        int $history_id
    ): void {
        $this->create_purchase_order_item_history_use_case->handle(
            new CreatePurchaseOrderItemHistoryDTO(
                $purchase_order_items,
                $history_id
            )
        );
    }

    private function createInstallments($purchase_order)
    {
        return $this->create_installment_use_case->handle(
            new CreateInstallmentDTO(
                $purchase_order,
                $this->dto->getInstallments()
            )
        );
    }

    private function createInstallmentsHistory(
        $installments,
        int $history_id
    ): void {
        $this->create_installment_history_use_case->handle(
            new CreateInstallmentHistoryDTO(
                $installments,
                $history_id
            )
        );
    }

    private function createTotalMonthlyInstallment(
        Collection $installments
    ): array{
        return $this->manage_total_monthly_installment_acquisition_use_case->handle(
            new ManageTotalMonthlyInstallmentAcquisitionDTO(
                $installments
            )
        );
    }

    private function createTotalMonthlyInstallmentHistory(
        array $total_monthly_installment,
        int $history_id
    ): void {
        $this->create_total_monthly_installment_history_use_case->handle(
            new CreateTotalMonthlyInstallmentHistoryDTO(
                $history_id,
                $total_monthly_installment
            )
        );
    }

}