<?php

namespace App\UseCases\CreditLimits;

use App\Domain\ValueObjects\AmountInCents;
use App\Helpers\Post;
use App\Models\CreditLimit;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GetCreditLimitsList{

    public function handle(Request $request){
        
        $params = Post::anti_injection_yajra($request->all());

        /**
         * ✅ Query base com JOIN para permitir ordenação + filtros + busca
         */
        $query = CreditLimit::query()
            ->leftJoin('contracts', 'contracts.id', '=', 'credit_limits.contract_id')
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

        /**
         * ✅ FILTRO MANUAL FIXO (opcional)
         */
        if ($params->credit_period_type_id) {
            $query->where('credit_limits.credit_period_type_id', $params->credit_period_type_id);
        }

        /**
         * ✅ Agora iniciamos o DataTables com suporte a filtros por coluna
         */
        return DataTables::of($query)

            /**
             * ✅ Pesquisa GLOBAL do DataTables
             */
            ->filter(function ($q) use ($request) {
                $search = $request->input('search.value');

                if ($search) {
                    $q->where(function ($sub) use ($search) {
                        $sub->where('authorized_amount', 'like', "%{$search}%")
                            ->orWhere('month', 'like', "%{$search}%")
                            ->orWhere('contracts.name', 'like', "%{$search}%")
                            ->orWhere('credit_modalities.name', 'like', "%{$search}%")
                            ->orWhere('credit_usage_types.name', 'like', "%{$search}%")
                            ->orWhere('credit_period_types.name', 'like', "%{$search}%");
                    });
                }

                /**
                 * ✅ ✅ Pesquisa por COLUNA INDIVIDUAL (inputs no thead)
                 */
                $columns = $request->input('columns', []);

                foreach ($columns as $index => $col) {
                    $value = $col['search']['value'] ?? null;
                    $columnName = $col['data'];

                    if (!$value) {
                        continue;
                    }

                    switch ($columnName) {
                        case 'contract.name':
                            $q->where('contracts.name', 'LIKE', "%{$value}%");
                            break;

                        case 'authorized_amount':
                            $q->where('credit_limits.authorized_amount', 'LIKE', "%{$value}%");
                            break;

                        case 'month':
                            $q->where('credit_limits.month', 'LIKE', "%{$value}%");
                            break;

                        case 'credit_modality.name':
                            $q->where('credit_modalities.name', 'LIKE', "%{$value}%");
                            break;

                        case 'credit_usage_type.name':
                            $q->where('credit_usage_types.name', 'LIKE', "%{$value}%");
                            break;

                        case 'credit_period_type.name':
                            $q->where('credit_period_types.name', 'LIKE', "%{$value}%");
                            break;

                        default:
                            // não faz nada para colunas não pesquisáveis
                            break;
                    }
                }
            })

            /**
             * ✅ Mapeamento das colunas relacionadas
             */
            ->addColumn('contract.name', fn($row) => $row->contract_name)
            ->addColumn('authorized_amount', fn($row) => 'R$ '.AmountInCents::fromInteger($row->authorized_amount)->toBRLMoney()->toString())
            ->addColumn('month', fn($row) => getMonth($row->month).'/'.$row->year)
            ->addColumn('credit_modality.name', fn($row) => $row->modality_name)
            ->addColumn('credit_usage_type.name', fn($row) => $row->usage_name)
            ->addColumn('credit_period_type.name', fn($row) => $row->period_name)

            /**
             * ✅ Ação (sempre manual)
             */
            ->addColumn('action', function ($row) {
                return '<a href="#" class="btn btn-sm btn-dark"><i class="bi bi-pencil"></i></a>';
            })

            ->rawColumns(['action'])
            ->make(true);
    }
}