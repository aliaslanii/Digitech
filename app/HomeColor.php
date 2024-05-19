<?php

namespace App;

use App\Models\Color;

class HomeColor
{
    public function getColorDetailsById($colorId)
    {
        return Color::find($colorId);
    }   
}
