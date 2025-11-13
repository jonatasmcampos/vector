<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vector:atualizar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the database without losing any data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $this->info('Tirando sistema do ar...');
            system('php artisan down');

            $this->info('Limpando o cache...');
            system('php artisan config:clear && php artisan cache:clear && php artisan config:cache');

            $this->info('Rodando migrations...');
            // Apenas 1 banco agora
            system('php artisan migrate');

            $this->info('Rodando seeders...');
            // Rode somente os seeders que realmente existem no seu projeto normal
            system('php artisan db:seed');

            $this->info('Limpando o cache novamente...');
            system('php artisan config:clear && php artisan cache:clear && php artisan config:cache');

            $this->info('Colocando o sistema no ar novamente...');
            system('php artisan up');

            $this->info('Processo finalizado! Base de dados atualizada com sucesso!');

            return 0;

        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return 0;
        }
    }
}
