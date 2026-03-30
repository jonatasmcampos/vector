<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\Home\GetDataToDashboardDTO;
use App\Enums\ContractEnum;
use App\Enums\CreditUsageTypeEnum;
use App\Helpers\Post;
use App\Models\CreditUsageType;
use App\UseCases\Home\GetDataToDashboardFactory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    private GetDataToDashboardFactory $get_data_to_dashboard_factory;

    public function __construct(GetDataToDashboardFactory $get_data_to_dashboard_factory)
    {
        $this->get_data_to_dashboard_factory = $get_data_to_dashboard_factory;
    }

    public function login(){
        return view('login.index');
    }

    public function home(){
        return view('home.home', [
            'months' => getMonths(),
            'years' => getYears(),
            'contracts' => ContractEnum::getAll(false),
            'current_month' => Carbon::now()->format('m'),
            'current_year' => Carbon::now()->format('Y'),
            'credit_usage_types' => CreditUsageTypeEnum::getAll()
        ]);
    }

    public function loadCards(Request $request){
        $params = (object)Post::anti_injection_array($request->all());
        $get_data_to_dashboard_dto = new GetDataToDashboardDTO(
            $params->month,
            $params->year,
            $params->contract_id,
            $params->credit_usage_type_id
        );
        $use_case = $this->get_data_to_dashboard_factory->make('data-cards');
        return response()->json($use_case->load($get_data_to_dashboard_dto));
    }

    public function loadLimitVsPurchaseOrdersChart(Request $request){
        $params = (object)Post::anti_injection_array($request->all());
        $get_data_to_dashboard_dto = new GetDataToDashboardDTO(
            $params->month,
            $params->year,
            $params->contract_id,
            $params->credit_usage_type_id
        );
        $use_case = $this->get_data_to_dashboard_factory->make('limit-vs-purchaseorders-chart');
        return response()->json($use_case->load($get_data_to_dashboard_dto));
    }

    public function loadBudgetHealth(Request $request){
        $params = (object)Post::anti_injection_array($request->all());
        $get_data_to_dashboard_dto = new GetDataToDashboardDTO(
            $params->month,
            $params->year,
            $params->contract_id,
            $params->credit_usage_type_id
        );
        $use_case = $this->get_data_to_dashboard_factory->make('budget-health');
        return response()->json($use_case->load($get_data_to_dashboard_dto));
    }
}