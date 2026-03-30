<?php 

namespace App\Repositories;

use App\Models\Settings;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class SettingsRepository{
    public function getAll(){
        return Settings::get();
    }

    public function getByGroup(
        string $group_name
    ): Collection{
        return Settings::where('group_name', $group_name)->get();
    }

    public function getByKey(
        string $key
    ): ?Settings{
        $settigns = Settings::where('key', $key)->first();
        if(!$settigns){
            throw new \Exception('Configuração não encontrada', 404);
        }
        return $settigns;
    }

    public function update(
        string $key,
        mixed $value
    ): ?Settings{
        $settings = $this->getByKey($key);
        $settings->update([
            'value' => $value
        ]);
        return $this->getByKey($key);
    }
}