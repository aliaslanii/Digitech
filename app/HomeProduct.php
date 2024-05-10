<?php

namespace App;

use App\Models\Discount;
use App\Models\Product;

class HomeProduct
{

    public function MostViewedProduct()
    {
        $Products = Product::orderBy('views', 'desc')->take(12)->get();
        $MostViewedProduct = [];
        foreach ($Products as $Product) {
            $ProductData = [
                "name" => $Product->name,
                "description" => $Product->description,
                "stock quantity" => $Product->stock_quantity,
                "specific" => $Product->specific,
                "main photo" => $Product->photo_path,
                "Category" => $Product->Category->name,
                "Berand" => $Product->Berand->name,
                'dtp' => $Product->dtp,
                'discount amount' => $Product->discount ? $Product->discount->discount_amount : null,
                'startTime discount' => $Product->discount ? $Product->discount->startTime : null,
                'endTime discount' => $Product->discount ? $Product->discount->endTime : null,
            ];
            $MostViewedProduct[] = $ProductData;
        }
        return $MostViewedProduct;
    }
    public function HotProducts()
    {
        $Products = Product::orderBy('views', 'desc')->get();
        $HotProducts = [];
        foreach ($Products as $Product) {
            $ProductData = [
                "name" => $Product->name,
                "description" => $Product->description,
                "stock quantity" => $Product->stock_quantity,
                "specific" => $Product->specific,
                "main photo" => $Product->photo_path,
                "Category" => $Product->Category->name,
                "Berand" => $Product->Berand->name,
                'dtp' => $Product->dtp,
                'discount amount' => $Product->discount ? $Product->discount->discount_amount : null,
                'startTime discount' => $Product->discount ? $Product->discount->startTime : null,
                'endTime discount' => $Product->discount ? $Product->discount->endTime : null,
            ];
            $HotProducts[] = $ProductData;
        }
        return $HotProducts;
    }
    public function productsMaxDiscount()
    {
        $Discounts = Discount::orderBy('discount_amount', 'desc')->take(12)->get();
        $productsMaxDiscount = [];
        foreach ($Discounts as $Discount) {
            $Product = $Discount->Product;
            $ProductData = [
                "name" => $Product->name,
                "description" => $Product->description,
                "stock quantity" => $Product->stock_quantity,
                "specific" => $Product->specific,
                "main photo" => $Product->photo_path,
                "Category" => $Product->Category->name,
                "Berand" => $Product->Berand->name,
                'dtp' => $Product->dtp,
                'discount amount' => $Product->discount ? $Product->discount->discount_amount : null,
                'startTime discount' => $Product->discount ? $Product->discount->startTime : null,
                'endTime discount' => $Product->discount ? $Product->discount->endTime : null,
            ];
            $productsMaxDiscount[] = $ProductData;
        }
        return $productsMaxDiscount;
    }


    public function getImages($Product)
    {
        $Response = [];
        foreach ($Product->Image as $img) {
            $Response[] = $img->photo_path;
        }
        return $Response;
    }
}
