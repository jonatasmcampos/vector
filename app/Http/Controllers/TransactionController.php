<?php

namespace App\Http\Controllers;

use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private TransactionRepository $transaction_repository;

    public function __construct(
        TransactionRepository $transaction_repository
    ){
        $this->transaction_repository = $transaction_repository;
    }

    public function index(){
        $transactions = $this->transaction_repository->getAll();
        return view('transaction.index', [
            'transactions' => $transactions
        ]);
    }
}
