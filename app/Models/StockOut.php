<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockOut extends Model
{
    protected $table = 'stock_out'; // Explicitly specify the table name
    
    protected $fillable = [
        'product_id',
        'quantity',
        'price_per_unit',
        'total_price',
        'date',
        'type',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'price_per_unit' => 'decimal:2',
        'total_price' => 'decimal:2',
        'date' => 'date',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
