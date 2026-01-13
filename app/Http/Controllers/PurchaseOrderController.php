<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\CreditLimitBalance\GetCreditLimitBalanceDTO;
use App\DataTransferObjects\PurchaseOrder\CreatePurchaseOrderDTO;
use App\Domain\Mappers\ContractIdMapper;
use App\Domain\ValueObjects\Date;
use App\Enums\CreditModalityEnum;
use App\Enums\CreditUsageTypeEnum;
use App\Helpers\Post;
use App\Http\Requests\PurchaseOrders\CreatePurchaseOrderFormRequest;
use App\UseCases\BillableResource\ManageBillableResourceUseCase;
use App\UseCases\BillableResource\ManagePurchaseOrderCreationUseCase;
use App\UseCases\CreditLimitBalances\GetCreditLimitBalanceUseCase;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{

    private ManageBillableResourceUseCase $manage_billable_resource_use_case;
    private ManagePurchaseOrderCreationUseCase $manage_purchase_order_creation_use_case;
    private GetCreditLimitBalanceUseCase $get_credit_limit_balance_use_case;

    public function __construct(    
        ManageBillableResourceUseCase $manage_billable_resource_use_case,
        ManagePurchaseOrderCreationUseCase $manage_purchase_order_creation_use_case,
        GetCreditLimitBalanceUseCase $get_credit_limit_balance_use_case
    ){
        $this->manage_billable_resource_use_case = $manage_billable_resource_use_case;
        $this->manage_purchase_order_creation_use_case = $manage_purchase_order_creation_use_case;
        $this->get_credit_limit_balance_use_case = $get_credit_limit_balance_use_case;
    }

    public function store(CreatePurchaseOrderFormRequest $request){
        $params = (object)Post::anti_injection_array($request->all());
        
        DB::transaction(function() use ($params){

            $acquisition_credit_limit_balance = $this->get_credit_limit_balance_use_case->handle(
                new GetCreditLimitBalanceDTO(
                    Date::fromString($params->header['action_date'])->format('m'),
                    Date::fromString($params->header['action_date'])->format('Y'),
                    ContractIdMapper::fromContractMasterCod($params->payload['purchase_order']['contract_master_cod']),
                    CreditUsageTypeEnum::SUPPLY->value,
                    CreditModalityEnum::ACQUISITION->value
                )
            );
            
            $payment_credit_limit_balance = $this->get_credit_limit_balance_use_case->handle(
                new GetCreditLimitBalanceDTO(
                    Date::fromString($params->header['action_date'])->format('m'),
                    Date::fromString($params->header['action_date'])->format('Y'),
                    ContractIdMapper::fromContractMasterCod($params->payload['purchase_order']['contract_master_cod']),
                    CreditUsageTypeEnum::SUPPLY->value,
                    CreditModalityEnum::PAYMENT->value
                )
            );

            $billable_resource = $this->manage_purchase_order_creation_use_case->withData(
                new CreatePurchaseOrderDTO(
                    $params->header,
                    $params->payload['purchase_order'],
                    $params->payload['materials'],
                    $params->payload['installments'],
                    $acquisition_credit_limit_balance,
                    $payment_credit_limit_balance
                )
            );
            $this->manage_billable_resource_use_case->handle($billable_resource);
        });
        
        return response()->json([
            'success' => true,
            'message' => 'Ordem de compra cadastrada com sucesso!'
        ]);
    }
}
