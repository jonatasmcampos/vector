<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\Histories\CreateHistoryDTO;
use App\DataTransferObjects\Settings\GetDataToSettingsViewDTO;
use App\DataTransferObjects\Settings\ManageSettingsUpdateDTO;
use App\Enums\ActionEnum;
use App\Enums\ContractEnum;
use App\Enums\ProcessEnum;
use App\Http\Requests\Settings\UpdateBalanceValidationFormRequest;
use App\Http\Requests\Settings\UpdatePeriodTypeForUsageTypeFormRequest;
use App\UseCases\Settings\ManageSettingsUpdateUseCase;
use App\UseCases\Settings\GetDataToSettingsViewUseCase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    private GetDataToSettingsViewUseCase $get_data_to_settings_view_use_case;
    private ManageSettingsUpdateUseCase $manage_settings_update_use_case;

    public function __construct(
        GetDataToSettingsViewUseCase $get_data_to_settings_view_use_case,
        ManageSettingsUpdateUseCase $manage_settings_update_use_case
    ){
        $this->get_data_to_settings_view_use_case = $get_data_to_settings_view_use_case;
        $this->manage_settings_update_use_case = $manage_settings_update_use_case;
    }

    public function index(Request $request){
        $data = $this->get_data_to_settings_view_use_case->handle(
            new GetDataToSettingsViewDTO(
                session('user.id')
            )
        );   

        return view('settings.index', [
            'section' => $request->get('section', 'profile'),
            'data'  => $data
        ]);
    }

    public function balanceValidationStore (UpdateBalanceValidationFormRequest $request){
        $create_history_dto = $this->createHistoryDTO(
            'Atualização das configurações de validação de saldo',
            ActionEnum::BALANCE_VALIDATION_SETTINGS_UPDATED->value
        );
        
        $dto = new ManageSettingsUpdateDTO(
            $request->validatedSettings(),
            $create_history_dto
        );

        DB::transaction(function() use ($dto){
            $this->manage_settings_update_use_case->handle($dto);
        });
        
        return response()->json([
            'success' => true,
            'message' => 'Validação de saldo atualizada com sucesso!'
        ]);
    }

    public function definePeriodTypeForUsageTypeStore(UpdatePeriodTypeForUsageTypeFormRequest $request){
        $create_history_dto = $this->createHistoryDTO(
            'Atualização das configurações de limites de crédito',
            ActionEnum::CREDIT_LIMITS_SETTINGS_UPDATED->value
        );

        $dto = new ManageSettingsUpdateDTO(
            $request->validatedSettings(),
            $create_history_dto
        );

         DB::transaction(function() use ($dto){
            $this->manage_settings_update_use_case->handle($dto);
        });

        return response()->json([
            'success' => true,
            'message' => 'Tipo de período atualizado com sucesso!'
        ]);
    }

    private function createHistoryDTO(
        ?string $observation,
        int $action_id
    ){
        return new CreateHistoryDTO(
            Carbon::now(),
            $observation,
            session('user.id'),
            $action_id,
            ProcessEnum::SETTINGS->value,
            ContractEnum::ALL->value,
        );
    }
}
