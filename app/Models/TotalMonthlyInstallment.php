<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TotalMonthlyInstallment extends Model
{
    protected $table = 'total_monthly_installments';

	protected $fillable = [
        'gross_amount',
        'paid_amount',
		'month',
        'year',
        'contract_id'
	];

    protected $casts = [
		'gross_amount' => 'integer',
        'paid_amount' => 'integer',
		'month' => 'integer',
        'year' => 'integer',
        'contract_id' => 'integer'
	];
}
