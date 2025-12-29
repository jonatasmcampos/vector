<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\PurchaseOrder\CreatePurchaseOrderDTO;
use App\Helpers\Post;
use App\Http\Requests\PurchaseOrders\CreatePurchaseOrderFormRequest;
use App\UseCases\BillableResource\ManageBillableResourceUseCase;
use App\UseCases\BillableResource\ManagePurchaseOrderCreationUseCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{

    private ManageBillableResourceUseCase $manage_billable_resource_use_case;
    private ManagePurchaseOrderCreationUseCase $manage_purchase_order_creation_use_case;

    public function __construct(    
        ManageBillableResourceUseCase $manage_billable_resource_use_case,
        ManagePurchaseOrderCreationUseCase $manage_purchase_order_creation_use_case
    ){
        $this->manage_billable_resource_use_case = $manage_billable_resource_use_case;
        $this->manage_purchase_order_creation_use_case = $manage_purchase_order_creation_use_case;
    }

    public function store(CreatePurchaseOrderFormRequest $request){
        $params = (object)Post::anti_injection_array($request->all());
        $create_purchase_order_dto = new CreatePurchaseOrderDTO(
            $params->header,
            $params->payload['purchase_order'],
            $params->payload['materials'],
            $params->payload['installments']
        );
        
        DB::transaction(function() use ($create_purchase_order_dto){
            $billable_resource = $this->manage_purchase_order_creation_use_case->withData($create_purchase_order_dto);
            $this->manage_billable_resource_use_case->handle($billable_resource);
        });
        return response()->json([
            'success' => true,
            'message' => 'Ordem de compra cadastrada com sucesso!'
        ]);
    }
}
