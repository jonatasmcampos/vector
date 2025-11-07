<?php

namespace App\Http\Controllers;

use App\Enums\ContractEnum;
use App\Enums\CreditModalityEnum;
use App\Enums\CreditPeriodTypeEnum;
use App\Enums\CreditUsageTypeEnum;
use App\Repositories\ContractRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CreditLimitController extends Controller
{

    public function index(){
        return view('creditLimit.index');
    }

    public function create(){
        return view('creditLimit.create', [
            'contracts' => ContractEnum::getAll(),
            'months' => getMonths(),
            'purposes' => CreditUsageTypeEnum::getAll(),
            'modalities' => CreditModalityEnum::getAll(),
            'period_types' => CreditPeriodTypeEnum::getAll()
        ]);
    }

    public function store(Request $request){
        dd('teste', $request->all());
    }

}
