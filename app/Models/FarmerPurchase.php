<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FarmerPurchase extends Model
{
    protected $fillable = [
        'product_id',
        'farmer_id',
        'user_id',
        'quantity',
        'unit',
        'price_per_unit',
        'purchased_at',
        'notes',
    ];

    protected $casts = [
        'purchased_at' => 'datetime',
        'price_per_unit' => 'decimal:2',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function farmer(): BelongsTo
    {
        return $this->belongsTo(Farmer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
