<?php 

namespace App\UseCases\Home;

use App\DataTransferObjects\Home\GetDataToDashboardDTO;
use App\Domain\Contracts\Home\GetDataToDashboardInterface;
use RuntimeException;

class GetDataToDashboardFactory{

    /** @var GetDataToDashboardInterface[]*/
    private array $uses_cases;

    public function __construct(array $uses_cases)
    {
        $this->uses_cases = $uses_cases;
    }

    public function make(string $data_type): GetDataToDashboardInterface
    {
        foreach ($this->uses_cases as $use_case) {
            if ($use_case->supports($data_type)) {
                return $use_case;
            }
        }
        throw new RuntimeException("Nenhuma estratégia encontrada para o tipo: {$data_type}");
    }
}