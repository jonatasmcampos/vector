<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\CreditLimits\CreateCreditLimitDTO;
use App\Enums\ContractEnum;
use App\Enums\CreditModalityEnum;
use App\Enums\CreditPeriodTypeEnum;
use App\Enums\CreditUsageTypeEnum;
use App\Helpers\Post;
use App\Http\Requests\CreditLimits\CreateCreditLimitFormRequest;
use App\UseCases\CreditLimits\CreateCreditLimitFactory;
use App\UseCases\CreditLimits\GetCreditLimitsList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreditLimitController extends Controller
{
    private CreateCreditLimitFactory $create_credit_limit_factory;
    private GetCreditLimitsList $get_credit_limits_list;

    public function __construct(
        CreateCreditLimitFactory $create_credit_limit_factory,
        GetCreditLimitsList $get_credit_limits_list
    ){
        $this->create_credit_limit_factory = $create_credit_limit_factory;
        $this->get_credit_limits_list = $get_credit_limits_list;
    }

    public function index(){
        return view('creditLimit.index');
    }

    public function create(){
        return view('creditLimit.create', [
            'contracts' => ContractEnum::getAll(),
            'months' => getMonths(),
            'credit_usage_types' => CreditUsageTypeEnum::getAll(),
            'credit_modalities' => CreditModalityEnum::getAll(),
            'credit_period_types' => CreditPeriodTypeEnum::getAll()
        ]);
    }

    public function store(CreateCreditLimitFormRequest $request){
        $params = Post::anti_injection_array($request->all());
        $create_credit_limit_request = new CreateCreditLimitDTO($params, session('user.id'));
        DB::transaction(function() use ($create_credit_limit_request){
            $strategy = $this->create_credit_limit_factory->make($create_credit_limit_request->getCreditPeriodTypeId());
            $strategy->execute($create_credit_limit_request);
        });
        return response()->json([
            'success' => true,
            'message' => 'Limite cadastrado com sucesso!'
        ]);
    }

    public function list(Request $request){
        return $this->get_credit_limits_list->handle($request);
    }

}
