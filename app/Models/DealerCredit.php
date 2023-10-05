<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DealerCredit extends Model
{

    protected $table = 'dealer_credit';
    protected $fillable = [
        'dealer_name',
        'contact_person',
        'loan_amount',
        'loan_term',
        'interest_rate',
        'reason',
        'status',
        'bank_id'
    ];

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }
}
