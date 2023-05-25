<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BalanceHistory extends Model
{
    use HasFactory;

    protected $table = 'balance_history';
    protected $fillable= ['amount_added', 'amount_deducted', 'updated_balance', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
