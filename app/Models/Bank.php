<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bank extends Model
{

    protected $table = 'banks';
    protected $fillable = [
        'bank_name'
    ];

    public function dealerCredit(): HasMany
    {
        return $this->hasMany(DealerCredit::class);
    }
}
