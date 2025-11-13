<?php

if (!function_exists('cnpjFormatter')) {
    function cnpjFormatter(string $cnpj): string {
        // Remove qualquer caractere que não seja número
        $cnpj = preg_replace('/\D/', '', $cnpj);

        // Verifica se tem 14 dígitos
        if (strlen($cnpj) !== 14) {
            return $cnpj; // Retorna como está se não tiver 14 dígitos
        }

        // Aplica a máscara
        return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $cnpj);
    }
}

if (!function_exists('getMonths')) {
    function getMonths(): array {
        $months = [];

        for ($i = 1; $i <= 12; $i++) {
            $months[] = ucfirst(Carbon\Carbon::create(null, $i)->locale('pt_BR')->translatedFormat('F'));
        }

        return $months;
    }
}

if (!function_exists('getMonth')) {
    function getMonth(int $month_number): string {
        return ucfirst(
            Carbon\Carbon::create(null, $month_number)
                ->locale('pt_BR')
                ->translatedFormat('F')
        );
    }
}

if (!function_exists('getYears')) {
    function getYears(): array {
        $years = [];
        $currentYear = now()->year;

        for ($year = 2015; $year <= $currentYear; $year++) {
            $years[] = $year;
        }

        return $years;
    }
}

if (!function_exists('calculatePercentage')) {
    function calculatePercentage($total_amount, $part_amount){
        if($total_amount == 0){
            return 0;
        }
        return ($part_amount * 100) / $total_amount;
    }
}