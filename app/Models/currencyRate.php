<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class currencyRate extends Model
{
    protected $table = 'currency_rates';

    protected $fillable = [
        'from_currency_id',
        'to_currency_id',
        'rate',
    ];
}
