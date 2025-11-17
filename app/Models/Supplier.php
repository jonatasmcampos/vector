<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';

	protected $fillable = [
		'name',
		'trade_name',
		'document',
		'mobile_phone',
		'phone',
		'email',
		'website',
		'address_id',
		'active',
	];

    protected $casts = [
		'address_id' => 'integer'
	];

	public function address()
	{
		return $this->belongsTo(Address::class, 'address_id', 'id');
	}
}
