<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    //

    protected $fillable = [
        'name',
        'price',
        'stock',
        'category',
        'image',
    ];

    protected static function booted()
    {
        // Cache removed for real-time stock
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
