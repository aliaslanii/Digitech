<?php

namespace App;

use Illuminate\Support\Facades\Auth;

class HomeCart
{

    protected $HomeProduct;
    protected $HomeColor;

    public function __construct()
    {
        $this->HomeProduct = new HomeProduct();
        $this->HomeColor = new HomeColor();
    }
    public function getCartUser()
    {
        return Auth::user()->Cart->where('is_pay', 0)->first();
    }

    public function getCartToalPrice()
    {
        $Cart = $this->getCartUser();
        $Price = 0;
        foreach ($Cart->products as $Product) {
            $Price +=  $this->HomeProduct->getProductPrice($Product, $Product->pivot->color_id);
        }
        return $Price;
    }
    // Price Product Color Cart
    public function getPPCC($Product)
    {
        return  $Result = [
            'Price' => $this->HomeProduct->getProductPrice($Product, $Product->pivot->color_id),
            'Color Code' => $this->HomeColor->getColorDetailsById($Product->pivot->color_id)->color,
            'Color name' => $this->HomeColor->getColorDetailsById($Product->pivot->color_id)->name,

        ];
    }
}
