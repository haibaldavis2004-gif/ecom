<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Purchase extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'purchases';

    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
    ];

    // Relation to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation to purchase items
    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }
}

