<?php 

namespace App\UseCases\Home;

use App\DataTransferObjects\Home\GetDataToDashboardDTO;
use App\Domain\Contracts\Home\GetDataToDashboardInterface;
use App\Domain\ValueObjects\AmountInCents;
use App\Enums\CreditModalityEnum;
use App\Repositories\CreditLimitRepository;
use App\Repositories\PurchaseOrderRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class LoadLimitVsPurchaseOrdersChartUseCase implements GetDataToDashboardInterface{

    private CreditLimitRepository $credit_limit_repository;
    private PurchaseOrderRepository $purchase_order_repository;

    public function __construct(
        CreditLimitRepository $credit_limit_repository,
        PurchaseOrderRepository $purchase_order_repository,
    ){
        $this->credit_limit_repository = $credit_limit_repository;
        $this->purchase_order_repository = $purchase_order_repository;
    }

    public function supports(string $data_type): bool{
        return $data_type === 'limit-vs-purchaseorders-chart';
    }

    public function load(GetDataToDashboardDTO $get_data_to_dashboard_dto): array{
        $credit_limits = $this->getCreditLimits($get_data_to_dashboard_dto);
        $purchase_orders = $this->getPurchaseOrders($get_data_to_dashboard_dto);
    
        $limits = $this->groupByMonth($credit_limits->where('credit_modality_id', CreditModalityEnum::ACQUISITION->value), 'authorized_amount');
        // $limits = $this->fillMissingMonths($limits, $get_data_to_dashboard_dto->getYear());

        $purchase_orders = $this->groupByMonth($purchase_orders, 'total');
        // $purchase_orders = $this->fillMissingMonths($purchase_orders, $get_data_to_dashboard_dto->getYear());

        return [
            'limits' => $limits,
            'purchase_orders' => $purchase_orders
        ];
    }

    private function groupByMonth(Collection $collection, string $valueField)
    {
        return $collection
            ->groupBy(function ($item) {
                $date = Carbon::parse($item->created_at);
                return $date->format('Y-m');
            })
            ->map(function ($items, $key) use ($valueField) {
                [$year, $month] = explode('-', $key);

                return [
                    'year' => (int) $year,
                    'month' => (int) $month,
                    'value' => $items->sum($valueField) / 100
                ];
            })
            ->values();
    }

    private function fillMissingMonths(SupportCollection $data, int $year)
    {
        return collect(range(1, 12))->map(function ($month) use ($data, $year) {

            $found = $data->first(function ($item) use ($month, $year) {
                return $item['month'] === $month && $item['year'] === $year;
            });

            return $found ?? [
                'year' => $year,
                'month' => $month,
                'value' => 0
            ];
        })->values();
    }

    private function getCreditLimits(GetDataToDashboardDTO $dto){
        return $this->credit_limit_repository->getCreditLimitByYearContractIdAndUsageTypeId(
            $dto->getYear(),
            $dto->getContractId(),
            $dto->getCreditUsageTypeId()
        );
    }

    private function getPurchaseOrders(GetDataToDashboardDTO $dto){
        return $this->purchase_order_repository->getPurchaseOrdersByContractId($dto->getContractId());
    }
    
}