<?php 

namespace App\DataTransferObjects\Settings;

use Illuminate\Database\Eloquent\Collection;

class PreparedDataToSettingsViewDTO{
    public function __construct(
        public string $user_name,
        public string $user_login,
        public string $user_email,
        public ?string $cpf,
        public ?string $phone,
        public array $balance_validation_group,
        public array $credit_usage_types
    ) {}
}