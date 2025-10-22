<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PurchaseItem extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'purchase_items';

    protected $fillable = [
        'purchase_id',
        'product_id',
        'quantity',
        'price',
    ];

    // Relation to purchase
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    // Relation to product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

