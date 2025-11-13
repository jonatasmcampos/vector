<?php 

namespace App\Domain\Contracts\Home;

use App\DataTransferObjects\Home\GetDataToDashboardDTO;

interface GetDataToDashboardInterface{
    public function supports(string $data_type): bool;
    public function load(GetDataToDashboardDTO $get_data_to_dashboard_dto): array;
}