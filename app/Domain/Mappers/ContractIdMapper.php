<?php

namespace App\Domain\Mappers;

use App\Enums\ContractEnum;
use InvalidArgumentException;

class ContractIdMapper {
    /**
     * Converte o contract_master_cod do sistema externo para o ID do contrato interno.
     *
     * @throws InvalidArgumentException
     */
    public static function fromContractMasterCod(int $contract_master_cod): int
    {
        $contracts = ContractEnum::getDataToInsert();

        $map = array_column($contracts, 'id', 'contract_master_cod');

        if (!isset($map[$contract_master_cod])) {
            throw new InvalidArgumentException(
                "Contrato não encontrado para contract_master_cod: {$contract_master_cod}"
            );
        }

        return (int)$map[$contract_master_cod];
    }
}