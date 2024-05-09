<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;

    public function ColorProduct()
    {
        return $this->hasMany(ColorProduct::class,'product_id');
    }

    public function featureProducts()
    {
        return $this->hasMany(FeatureProduct::class,'product_id');
    }
    
    public function discount()
    {
        return $this->hasOne(Discount::class,'product_id');
    }
}
