<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'status'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): BelongsToMany
    {
<<<<<<< HEAD
        return $this->belongsToMany(Product::class, 'order_details')->withPivot('quantity', 'price')->withTimestamps();
=======
        return $this->belongsToMany(Product::class, 'order_details')->withPivot('quantity', 'price');
>>>>>>> f9f20dfb781efd60621d7ac94aca99cbebf020b1
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }
}
