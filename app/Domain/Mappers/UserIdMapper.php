<?php

namespace App\Domain\Mappers;

use App\Enums\UserEnum;
use InvalidArgumentException;

class UserIdMapper {
    /**
     * Converte o user_master_cod do sistema externo para o ID do usuario interno.
     *
     * @throws InvalidArgumentException
     */
    public static function fromUserMasterCod(int $user_master_cod): int
    {
        $users = UserEnum::getDataToInsert();

        $map = array_column($users, 'id', 'user_master_cod');

        if (!isset($map[$user_master_cod])) {
            throw new InvalidArgumentException(
                "Usuário não encontrado para user_master_cod: {$user_master_cod}"
            );
        }

        return (int)$map[$user_master_cod];
    }
}