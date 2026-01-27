<?php

namespace App\Http\Controllers;

use App\UseCases\Transaction\GetTransactionListViewUseCase;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private GetTransactionListViewUseCase $get_transaction_list_view_use_case;

    public function __construct(
        GetTransactionListViewUseCase $get_transaction_list_view_use_case
    ){
        $this->get_transaction_list_view_use_case = $get_transaction_list_view_use_case;
    }

    public function index(){
        $transactions = $this->get_transaction_list_view_use_case->handle();
        return view('transaction.index', [
            'transactions' => $transactions
        ]);
    }
}
