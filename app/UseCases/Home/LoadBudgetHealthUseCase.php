<?php 

namespace App\UseCases\Home;

use App\DataTransferObjects\Home\GetDataToDashboardDTO;
use App\Domain\Contracts\Home\GetDataToDashboardInterface;
use App\Domain\ValueObjects\AmountInCents;
use App\Enums\CreditModalityEnum;
use App\Models\CreditLimit;
use App\Repositories\CreditLimitRepository;
use Carbon\Carbon;

class LoadBudgetHealthUseCase implements GetDataToDashboardInterface
{
    private CreditLimitRepository $credit_limit_repository;

    public function __construct(
        CreditLimitRepository $credit_limit_repository
    ){
        $this->credit_limit_repository = $credit_limit_repository;
    }

    public function supports(string $data_type): bool
    {
        return $data_type === 'budget-health';
    }

    public function load(GetDataToDashboardDTO $dto): array
    {
        $credit_limit = $this->getCreditLimit($dto)
            ->where('credit_modality_id', CreditModalityEnum::ACQUISITION->value)
            ->first();

        $health = $this->getHealth($credit_limit, $dto->getMonth(), $dto->getYear());
        $budget_projection = $this->getBudgetProjections($credit_limit, $dto->getMonth(), $dto->getYear());

        return [
            'health' => $health,
            'projections' => $budget_projection,
        ];
    }

    private function getHealth(CreditLimit $credit_limit, int $month, int $year): array
    {
        $budget = $credit_limit->authorized_amount;
        $balance = $credit_limit->monthly_credit_limit_balance->balance;

        if ($budget <= 0) {
            return [
                'status' => 'gray',
                'consumed_percent' => 0,
                'expected_percent' => 0,
                'diff_percent' => 0,
                'headline' => 'Sem dados de orçamento',
                'message' => 'Não há orçamento configurado para este período.',
            ];
        }

        $consumed = (($budget - $balance) / $budget) * 100;

        $date = Carbon::create($year, $month, 1);
        $daysInMonth = $date->daysInMonth;

        $isCurrentMonth = ($month == now()->month && $year == now()->year);

        $dayOfMonth = $isCurrentMonth ? now()->day : $daysInMonth;

        $expected = ($dayOfMonth / $daysInMonth) * 100;
        $diff = $consumed - $expected;

        $status = $this->resolveStatus($consumed, $diff);

        return [
            'status' => $status,

            'consumed_percent' => round($consumed, 2),
            'expected_percent' => round($expected, 2),
            'diff_percent' => round($diff, 2),

            // 🔥 INSIGHT PRONTO
            'headline' => $this->healthHeadline($status, $diff),
            'message' => $this->healthMessage($status, $diff),
        ];
    }

    private function getBudgetProjections(CreditLimit $credit_limit, int $month, int $year): array
    {
        $budget = $credit_limit->authorized_amount;
        $balance = $credit_limit->monthly_credit_limit_balance->balance;

        $consumed = $budget - $balance;

        if ($consumed <= 0) {
            return [
                'burn_rate_daily' => 0,
                'projection' => 0,
                'projection_percent' => 0,
                'remaining' => AmountInCents::fromInteger($balance)->toBRLMoney()->toString(),
                'remaining_daily' => 0,
                'headline' => 'Baixo consumo',
                'message' => 'Você ainda não utilizou o orçamento neste período.',
            ];
        }

        $date = Carbon::create($year, $month, 1);
        $daysInMonth = $date->daysInMonth;

        $isCurrentMonth = ($month == now()->month && $year == now()->year);

        $dayOfMonth = $isCurrentMonth ? now()->day : $daysInMonth;
        $daysRemaining = max($daysInMonth - $dayOfMonth, 1);

        $burnRateDaily = $consumed / max($dayOfMonth, 1);

        $projection = $burnRateDaily * $daysInMonth;
        $projectionPercent = ($projection / $budget) * 100;

        $remaining = $balance;
        $remainingDaily = $remaining / $daysRemaining;

        return [
            'burn_rate_daily' => AmountInCents::fromInteger($burnRateDaily)->toBRLMoney()->toString(),
            'projection' => $projection,
            'projection_percent' => round($projectionPercent, 2),
            'remaining' => AmountInCents::fromInteger($remaining)->toBRLMoney()->toString(),
            'remaining_daily' => AmountInCents::fromInteger($remainingDaily)->toBRLMoney()->toString(),

            // 🔥 INSIGHT PRONTO
            'headline' => $this->projectionHeadline($projectionPercent),
            'message' => $this->projectionMessage($projectionPercent),
        ];
    }

    private function resolveStatus(float $consumed, float $diff): string
    {
        if ($consumed >= 90 || $diff >= 15) return 'red';
        if ($consumed >= 70 || $diff >= 5) return 'yellow';
        return 'green';
    }

    private function healthHeadline($status, $diff)
    {
        return match ($status) {
            'red' => 'Atenção no ritmo de gastos',
            'yellow' => 'Ritmo precisa de cuidado',
            default => 'Orçamento sob controle',
        };
    }

    private function healthMessage($status, $diff)
    {
        return match ($status) {
            'red' => 'Você está consumindo acima do esperado.',
            'yellow' => 'Você está levemente acima do ritmo ideal.',
            default => 'Você está dentro do planejado.',
        };
    }

    private function projectionHeadline($percent)
    {
        if ($percent > 110) return 'Risco de estouro de orçamento';
        if ($percent < 80) return 'Orçamento subutilizado';
        return 'Projeção saudável';
    }

    private function projectionMessage($percent)
    {
        if ($percent > 110) return 'No ritmo atual, você vai ultrapassar o orçamento.';
        if ($percent < 80) return 'Você vai usar menos do que o previsto.';
        return 'Você está no caminho certo.';
    }

    private function getCreditLimit(GetDataToDashboardDTO $dto)
    {
        return $this->credit_limit_repository->getByMonthYearContractIdAndUsageTypeId(
            $dto->getMonth(),
            $dto->getYear(),
            $dto->getContractId(),
            $dto->getCreditUsageTypeId()
        );
    }
}