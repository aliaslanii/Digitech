<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;
    
    public function incrementViews()
    {
        $this->increment('views');
    }

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

    public function Category()
    {
        return $this->belongsTo(Category::class,'categorie_id');
    }

    public function Berand()
    {
        return $this->belongsTo(Berand::class,'berand_id');
    }

    public function Image()
    {
        return $this->hasMany(ImageProduct::class,'product_id');
    }

    public function Comment()
    {
        return $this->hasMany(Comment::class,'product_id');
    }
   
}
