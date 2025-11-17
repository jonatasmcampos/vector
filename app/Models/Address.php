<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';

	protected $fillable = [
		'street',
		'number',
		'address_complement',
		'neighborhood',
		'city',
		'state',
		'postal_code',
	];

	public function suppliers()
	{
		return $this->hasMany(Supplier::class);
	}

}
