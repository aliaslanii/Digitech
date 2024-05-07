<?php

namespace App;

use App\Models\ImageProduct;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class FileTransfer
{
    // move file in directory and save path in databasse
    public function moveFile($request,$path)
    {
        $image = $request->image;
        $imageName = Carbon::now()->format('Y-m-d-H-i-s').'-'.random_int(1000,99999).'.'.$image->getClientOriginalExtension();
        $image->move(public_path($path), $imageName);
        return $path.'/'.$imageName;
    }

    // move file in directory and update path in databasse
    public function updateFile($model,$request,$path,)
    {
        if($request->image == null)
        {
            return $model->photo_path;
        }else{
            File::delete($model->photo_path);
            $image = $request->image;
            $imageName = Carbon::now()->format('Y-m-d-H-i-s').'-'.random_int(1000,99999).'.'.$image->getClientOriginalExtension();
            $image->move(public_path($path), $imageName);
            return $path.'/'.$imageName;
        }
    }

    // move image Product in directory and save path in databasse
    public function moveProductMainImage($request,$path)
    {
        $image = $request->main_image; 
        $imageName = Carbon::now()->format('Y-m-d-H-i-s').'-'.random_int(1000,99999).'.'.$image->getClientOriginalExtension();
        $image->move(public_path($path), $imageName);
        return $path.'/'.$imageName;
    }

    // move image Product in directory and update path in databasse
    public function updateProductMainImage($model,$request,$path,)
    {
        if($request->main_image == null)
        {
            return $model->photo_path;
        }else{
            File::delete($model->photo_path);
            $image = $request->main_image;
            $imageName = Carbon::now()->format('Y-m-d-H-i-s').'-'.random_int(1000,99999).'.'.$image->getClientOriginalExtension();
            $image->move(public_path($path), $imageName);
            return $path.'/'.$imageName;
        }
    }
    public function moveProductAdditionalImages($product,$request,$path)
    {
        foreach($request->additional_images as $image)
        {
            $ImageProduct = new ImageProduct();
            $ImageProduct->product_id = $product->id;
            $imageName = Carbon::now()->format('Y-m-d-H-i-s').'-'.random_int(1000,99999).'.'.$image->getClientOriginalExtension();
            $image->move(public_path($path.'/Product-'.$product->id), $imageName);
            $ImageProduct->photo_path = $path.'/Product-'.$product->id.'/'.$imageName;
            $ImageProduct->save();
        }
    }
}
?>