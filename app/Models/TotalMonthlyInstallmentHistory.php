<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TotalMonthlyInstallmentHistory extends Model
{
    protected $table = 'total_monthly_installment_histories';

	protected $fillable = [
        'history_id',
        'total_monthly_installment_id',
        'installment_id',
        'gross_amount',
        'old_gross_amount',
        'new_gross_amount',
        'amount_paid',
        'old_amount_paid',
        'new_amount_paid',
		'month',
        'year',
        'contract_id'
	];

    protected $casts = [
		'gross_amount' => 'integer',
		'old_gross_amount' => 'integer',
		'new_gross_amount' => 'integer',
        'amount_paid' => 'integer',        
        'old_amount_paid' => 'integer',        
        'new_amount_paid' => 'integer',        
		'month' => 'integer',
        'year' => 'integer',
        'total_monthly_installment_id' => 'integer',
        'history_id' => 'integer',
        'contract_id' => 'integer'
	];
}
