<?php

namespace App\UseCases\PurchaseOrders;

use App\Helpers\Post;
use App\Models\PurchaseOrder;
use App\QueryBuilder\YajraQueryBuilder;
use Illuminate\Http\Request;

class GetPurchaseOrderListUseCase{
    public function handle(Request $request){
        $params = Post::anti_injection_yajra($request->all());        
        $query = new YajraQueryBuilder(PurchaseOrder::query());

        return $query->rejectColumns(['created_at'])
            ->setDateColumns(['created_at'])
            ->apply($params->getAttributes())
            ->toDataTable(
                rawColumns: ['action'],
                callback: function ($purchase_order) {
                    return $purchase_order->addColumn('external_display_id', fn ($purchase_order) => $purchase_order->external_display_id)
                        ->addColumn('status.name', fn ($purchase_order) => $purchase_order->status->name)
                        ->addColumn('total_items', fn ($purchase_order) => $purchase_order->total_items)
                        ->addColumn('supplier.name', fn ($purchase_order) => $purchase_order->supplier->name)
                        ->addColumn('created_at', fn ($purchase_order) => $purchase_order->created_at->format('d/m/Y'))
                        ->addColumn('user.name', fn ($purchase_order) => $purchase_order->user->name)
                        ->addColumn('action', fn ($purchase_order) => $this->getButtons($purchase_order));
                }
            );
    }

    private function getButtons(PurchaseOrder $purchase_order){
        return '
            <a href="'. route('purchase-order.show', $purchase_order->id) .'" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i></a>
        ';
    }
}