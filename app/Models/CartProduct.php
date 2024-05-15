<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartProduct extends Model
{
    use HasFactory,SoftDeletes;

    public function scopeFindCartProduct(Builder $query,$product_id,$color_id,$cart_id): void
    {
        $query->where('product_id',$product_id)->where('color_id',$color_id)->where('cart_id',$cart_id);
    }
}
