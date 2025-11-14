<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ContractSeeder::class,
            UserGroupSeeder::class,
            UserSeeder::class,
            CreditModalitySeeder::class,
            CreditUsageTypeSeeder::class,
            CreditPeriodTypeSeeder::class,
            ActionSeeder::class,
            ProcessSeeder::class,
            InstallmentTypeSeeder::class,
            OriginEntitySeeder::class,
            PaymentMethodSeeder::class,
            PaymentNatureSeeder::class,
            StatusSeeder::class,
            InstallmentAmountTypeSeeder::class,
            TransactionTypeSeeder::class
        ]);
    }
}
