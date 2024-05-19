<?php

namespace App;

use App\Models\Color;
use App\Models\ColorProduct;
use App\Models\Discount;
use App\Models\Product;
use Carbon\Carbon;

class HomeProduct
{
    protected $HomeColor;

    public function __construct()
    {
        $this->HomeColor = new HomeColor();
    }
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
    public function getColorDetailsById($colorId)
    {
        return Color::find($colorId);
    }

    public function getProductPrice($Product)
    {
        $ColorProduct = ColorProduct::where('color_id', $Product->pivot->color_id)
            ->where('product_id', $Product->id)
            ->first();
        if ($ColorProduct) {
            return $ColorProduct->price;
        }
        return null;
    }
    public function getMinDetailProduct($Product)
    {
        $ColorProduct = ColorProduct::where('product_id', $Product->id)
            ->orderBy('price', 'asc')
            ->first();

        if ($ColorProduct) {
            $PriceDetail = [
                'price' => $ColorProduct->price,
                'color name' =>  $this->HomeColor->getColorDetailsById($ColorProduct->color_id)->name,
                'color' =>  $this->HomeColor->getColorDetailsById($ColorProduct->color_id)->color,
            ];
            return $PriceDetail;
        }
        return null;
    }
    public function getProductDiscount($Product)
    {
        if ($Product->discount) {
            $nowtime = Carbon::now();
            $StartTime = Carbon::parse($Product->discount->startTime);
            $EndTime = Carbon::parse($Product->discount->endTime);
            if ($nowtime->gte($StartTime) == true && $nowtime->gte($EndTime) == false) {
                $discount = [
                    'discount amount' => $Product->discount->discount_amount
                ];
                return $discount;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function stockQuantityProduct($Product)
    {
        if ($Product->stock_quantity <= 9) {
            return $Product->stock_quantity;
        } elseif ($Product->stock_quantity == 0) {
            return null;
        } else {
            return true;
        }
    }
}
