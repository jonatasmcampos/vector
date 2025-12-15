<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\PurchaseOrders\CreatePurchaseOrderDTO;
use App\Helpers\Post;
use App\Http\Requests\PurchaseOrders\CreatePurchaseOrderFormRequest;
use App\UseCases\PurchaseOrders\CreatePurchaseOrderUseCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    private CreatePurchaseOrderUseCase $create_purchase_order_use_case;

    public function __construct(
        CreatePurchaseOrderUseCase $create_purchase_order_use_case
    ){
        return $this->create_purchase_order_use_case = $create_purchase_order_use_case;
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
            $this->create_purchase_order_use_case->handle($create_purchase_order_dto);
        });
        return response()->json([
            'success' => true,
            'message' => 'Ordem de compra cadastrada com sucesso!'
        ]);
    }
}
