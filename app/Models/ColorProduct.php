<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ColorProduct extends Model
{
    use HasFactory;

    public function scopeFindColorProduct(Builder $query,$product_id,$color_id): void
    {
        $query->where('product_id',$product_id)->where('color_id',$color_id) ?? null;
    }
}
