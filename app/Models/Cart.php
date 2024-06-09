<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory,SoftDeletes;

    public function cartProduct()
    {
        return $this->hasMany(CartProduct::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'cart_products')
                    ->withPivot('count')
                    ->withPivot('color_id');
    }
    public function cartUser()
    {
        return $this->where('is_pay', 0);
    }
}
