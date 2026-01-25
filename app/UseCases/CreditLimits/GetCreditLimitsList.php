<?php

namespace App\UseCases\CreditLimits;

use App\Domain\ValueObjects\AmountInCents;
use App\Helpers\Post;
use App\Models\CreditLimit;
use App\QueryBuilder\YajraQueryBuilder;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GetCreditLimitsList{

    public function handle(Request $request){
        
        $params = Post::anti_injection_yajra($request->all());
        $query = new YajraQueryBuilder(CreditLimit::query());

        $query->leftJoin('contracts', 'contracts.id', '=', 'credit_limits.contract_id')
            ->leftJoin('credit_modalities', 'credit_modalities.id', '=', 'credit_limits.credit_modality_id')
            ->leftJoin('credit_usage_types', 'credit_usage_types.id', '=', 'credit_limits.credit_usage_type_id')
            ->leftJoin('credit_period_types', 'credit_period_types.id', '=', 'credit_limits.credit_period_type_id')
            ->select([
                'credit_limits.*',
                'contracts.name as contract_name',
                'credit_modalities.name as modality_name',
                'credit_usage_types.name as usage_name',
                'credit_period_types.name as period_name',
            ]);

        return $query->rejectColumns(['month', 'authorized_amount'])
            ->specifySearches([
                'month' => fn ($query, $search) => $this->specifyReferenceMonthSearch($query, $search),
                'authorized_amount' => fn ($query, $search) => $this->specifyAuthorizedAmountSearch($query, $search),
            ])
            ->apply($params->getAttributes())
            ->toDataTable(
                rawColumns: ['action'],
                callback: function($credit_limit) {
                    return $credit_limit->addColumn('contract.name', fn($credit_limit) => $credit_limit->contract_name)
                        ->addColumn('authorized_amount', fn($credit_limit) => 'R$ '.AmountInCents::fromInteger($credit_limit->authorized_amount)->toBRLMoney()->toString())
                        ->addColumn('month', fn($credit_limit) => getMonth($credit_limit->month).'/'.$credit_limit->year)
                        ->addColumn('credit_modality.name', fn($credit_limit) => $credit_limit->modality_name)
                        ->addColumn('credit_usage_type.name', fn($credit_limit) => $credit_limit->usage_name)
                        ->addColumn('credit_period_type.name', fn($credit_limit) => $credit_limit->period_name)
                        ->addColumn('action', function ($credit_limit) {
                            return '<a href="#" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>';
                        });
                }
            );
    }

    private function specifyReferenceMonthSearch($query, $search)
    {
        $month = '';
        $year  = '';

        for ($i = 0; $i < mb_strlen($search); $i++) {
            $char = mb_substr($search, $i, 1);

            if (preg_match('/\p{L}/u', $char)) {
                $month .= $char;
            }

            if (preg_match('/\p{N}/u', $char)) {
                $year .= $char;
            }
        }

        $month = mb_strtolower($month, 'UTF-8');

        if ($month !== '') {
            $monthNumber = getMonthNumber($month);

            if ($monthNumber !== null) {
                $query->where('credit_limits.month', $monthNumber);
            }
        }

        if ($year !== '') {
            $query->where('credit_limits.year', (int) $year);
        }
    }

    private function specifyAuthorizedAmountSearch($query, $search){
        $cents = AmountInCents::fromString($search)->value();
        $query->where('credit_limits.authorized_amount', $cents);
    }
}