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
        static::saved(function ($product) {
            \Illuminate\Support\Facades\Cache::flush();
        });
        static::deleted(function ($product) {
            \Illuminate\Support\Facades\Cache::flush();
        });
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
