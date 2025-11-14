<?php 

namespace App\UseCases\Home;

use App\DataTransferObjects\Home\GetDataToDashboardDTO;
use App\Domain\Contracts\Home\GetDataToDashboardInterface;
use App\Domain\ValueObjects\AmountInCents;
use App\Repositories\CreditLimitRepository;
use Illuminate\Database\Eloquent\Collection;

class LoadDatatoStatisticsCardsUseCase implements GetDataToDashboardInterface{

    private CreditLimitRepository $credit_limit_repository;

    public function __construct(
        CreditLimitRepository $credit_limit_repository
    ){
        $this->credit_limit_repository = $credit_limit_repository;
    }

    public function supports(string $data_type): bool{
        return $data_type === 'data-cards';
    }

    public function load(GetDataToDashboardDTO $get_data_to_dashboard_dto): array{

        $credit_limits = $this->getCreditLimit(
            $get_data_to_dashboard_dto->getMonth(),
            $get_data_to_dashboard_dto->getYear(),
            $get_data_to_dashboard_dto->getContractId(),
            $get_data_to_dashboard_dto->getCreditUsageTypeId()
        );
        
        return $this->getData($credit_limits);
    }

    /**
    * @param \Illuminate\Database\Eloquent\Collection<int, \App\Models\CreditLimit> $credit_limits
    */
    private function getData(Collection $credit_limits): array{
        $data = [];
        foreach ($credit_limits as $key => $credit_limit) {
            if($credit_limit->isAcquisitionModality()){
                $data[] = [
                    'title' => 'Autorizado para compras',
                    'subtitle' => 'Valor autorizado para compras',
                    'value' => AmountInCents::fromInteger($credit_limit->authorized_amount)->toBRLMoney()->toString(),
                    'progress' => 100,
                ];
                $data[] = [
                    'title' => 'Saldo de compras',
                    'subtitle' => 'Valor disponível para novas compras',
                    'value' => AmountInCents::fromInteger($credit_limit->credit_limit_balance->balance)->toBRLMoney()->toString(),
                    'progress' => calculatePercentage($credit_limit->authorized_amount, $credit_limit->credit_limit_balance->balance),
                ];
            }
            if($credit_limit->isPaymentModality()){
                $data[] = [
                    'title' => 'Autorizado para pagamentos',
                    'subtitle' => 'Valor autorizado para pagamentos',
                    'value' => AmountInCents::fromInteger($credit_limit->authorized_amount)->toBRLMoney()->toString(),
                    'progress' => 100,
                ];
                $data[] =  [
                    'title' => 'Saldo de pagamentos',
                    'subtitle' => 'Valor disponível para novos pagamentos',
                    'value' => AmountInCents::fromInteger($credit_limit->credit_limit_balance->balance)->toBRLMoney()->toString(),
                    'progress' => calculatePercentage($credit_limit->authorized_amount, $credit_limit->credit_limit_balance->balance),
                ];
            }
        }        
        return $data;
    }

    private function getCreditLimit(
        int $month,
        int $year,
        int $contract_id,
        int $credit_usage_type_id
    ): Collection{
        return $this->credit_limit_repository->getByMonthYearAndContractId($month, $year, $contract_id, $credit_usage_type_id);
    }
    
}