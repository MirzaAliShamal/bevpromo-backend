<?php

class Functions
{
    public static function imageUpload($file, $coupon_id)
    {
        $basePath = realpath(base_path() . '/..');
        $path = $basePath . '/static-assets/entries/' . $coupon_id;
        if (is_dir($path)) {
            $fileName = rand(100, 1000) . '-' . $file->getClientOriginalName();
            $file->move($path, $fileName);
        } else {
            mkdir($basePath . '/static-assets/entries/' . $coupon_id, 0777, true);
            $path = $basePath . '/static-assets/entries/' . $coupon_id;
            $fileName = rand(100, 1000) . '-' . $file->getClientOriginalName();
            $file->move($path, $fileName);
        }
        return $fileName;
    }

    public static function upload_upc_image($file, $customer_id)
    {
        $fileName = Functions::imageUpload($file, $customer_id);
        $imageDataObj = new CustomerUpcImage();
        $imageDataObj->customer_id = $customer_id;
        $imageDataObj->image = $fileName;
        $imageDataObj->save();
        return $imageDataObj;
    }
    public static function upload_rec_image($file, $customer_id)
    {
        $fileName = Functions::imageUpload($file, $customer_id);
        $imageDataObj = new CustomerReceiptImage();
        $imageDataObj->customer_id = $customer_id;
        $imageDataObj->image = $fileName;
        $imageDataObj->save();
        return $imageDataObj;
    }

    public static function upload_sweep_image($file, $position, $coupon_id)
    {
        $fileName = Functions::imageUpload($file, $coupon_id);
        $imageDataObj = new ImageData();
        $imageDataObj->position = $position;
        $imageDataObj->coupon_id = $coupon_id;
        $imageDataObj->src = $fileName;
        $imageDataObj->save();
        return $imageDataObj;
    }
    public static function move_image($file_name, $old_coupon_id, $coupon_id)
    {
        if($old_coupon_id==0)
        {
            $basePath = realpath(base_path() . '/..');
            $path = $basePath . '/static-assets/entries/' . $coupon_id . '/';
            if (!is_dir($path)) {
                mkdir($basePath . '/static-assets/entries/' . $coupon_id, 0777, true);
            }
            $old_path = $basePath . '/static-assets/entries/' . $old_coupon_id . '/' . $file_name;
            if($old_path){
                rename($old_path, $path . $file_name);
            }
            return $file_name;
        }
        
    }

    public static function move_sweep_images($old_coupon_id, $coupon_id) {
        $images = ImageData::where('coupon_id', '=', $old_coupon_id)->get();
        foreach ($images as $key => $value) {
            $image = ImageData::where('id', '=', $value['id'])->first();
            $image->coupon_id = $coupon_id;
            $image->save();
            Functions::move_image($value['src'], $old_coupon_id, $coupon_id);
        }
        return true;
    }

    public static function get_uploaded_upc_images_html($coupon_id)
    {
        $getImageArr = array();
        $getImages = CustomerUpcImage::where('customer_id', $coupon_id)->get();
        if (!empty($getImages)) {
            foreach ($getImages as $getImage) {
                $imageId = $getImage->id;
                $arr = array(
                    'src'=>Constant::$assetLink . '/entries/'. $coupon_id . '/' . $getImage['src'],
                    'id' => $imageId
                );
                array_push($getImageArr,$arr);
            }
        }
        $getImage = '';
        $getImage .= '<div class="col-sm-12">';
        foreach ($getImageArr as $imageA) {
            $id = $imageA['id'];
            $imagepath = $imageA['src'];

                $getImage .= '<div class="col-sm-3">';
                $getImage .= '<div  class="img-wraps">';

                $getImage .= '<span  class="closes deleteUpcImage" data-id="' . $id . '" data-customer-id="'.$coupon_id.'" title="Delete">&times;</span>';
                $getImage .= '<img  class="img-responsive delete_' . $id . '" src="' . $imagepath . '"></div>';
                $getImage .= '</div>';
        }
        $getImage .= '</div>';
        return $getImage;
    }

    public static function get_uploaded_rec_images_html($coupon_id)
    {
        $getImageArr = array();
        $getImages = CustomerReceiptImage::where('customer_id', $coupon_id)->get();
        if (!empty($getImages)) {
            foreach ($getImages as $getImage) {
                $imageId = $getImage->id;
                $arr = array(
                    'src'=>Constant::$assetLink . '/entries/'. $coupon_id . '/' . $getImage['src'],
                    'id' => $imageId
                );
                array_push($getImageArr,$arr);
            }
        }
        $getImage = '';
        $getImage .= '<div class="col-sm-12">';
        foreach ($getImageArr as $imageA) {
            $id = $imageA['id'];
            $imagepath = $imageA['src'];

                $getImage .= '<div class="col-sm-3">';
                $getImage .= '<div  class="img-wraps">';

                $getImage .= '<span  class="closes deleteRecImage" data-id="' . $id . '" data-customer-id="'.$coupon_id.'" title="Delete">&times;</span>';
                $getImage .= '<img  class="img-responsive delete_' . $id . '" src="' . $imagepath . '"></div>';
                $getImage .= '</div>';
        }
        $getImage .= '</div>';
        return $getImage;
    }

    

    public static function get_uploaded_images_html_sweep($coupon_id)
    {
        $uploadType = array("1" => "Age Gate", "2" => "Promotional Page", "3" => "Promotional Ad", "4" => "Slider Images", "5" => "Web Entry Page");
        $getImageArr = array();
        $getImages = ImageData::where('coupon_id', $coupon_id)->get();
        if (!empty($getImages)) {
            foreach ($getImages as $getImage) {
                $imageId = $getImage->id;
                $getImageArr[$getImage->position][$imageId] = Constant::$assetLink . '/entries/'. $coupon_id . '/' . $getImage['src'];
            }
        }
        $getImage = '';
        foreach ($getImageArr as $position => $imageA) {
            $getImage .= '<div class="col-sm-12">';
            $getImage .= '<p>' . $uploadType[$position] . '</p>';

            foreach ($imageA as $id => $imagepath) {
                $getImage .= '<div class="col-sm-3">';
                $getImage .= '<div  class="img-wraps">';

                $getImage .= '<span  class="closes deleteSweepImage" data-id="' . $id . '" data-coupon-id="'.$coupon_id.'" title="Delete">&times;</span>';
                $getImage .= '<img  class="img-responsive delete_' . $id . '" src="' . $imagepath . '"></div>';
                $getImage .= '</div>';
            }
            $getImage .= '</div>';
        }
        return $getImage;
    }

    public static function delete_dmir_logo($file_name, $coupon_id)
    {
        $basePath = realpath(base_path() . '/..');
        $path = $basePath . '/static-assets/entries/' . $coupon_id . '/';
        $file = $path . $file_name;
        unlink($file);
        return true;
    }

    public static function delete_upc_images($file_name, $coupon_id)
    {
        $basePath = realpath(base_path() . '/..');
        $path = $basePath . '/static-assets/entries/' . $coupon_id . '/';
        $file = $path . $file_name;
        return true;
    }

    public static function delete_favicon($fav_icon, $coupon_id)
    {
        $basePath = realpath(base_path() . '/..');
        $path = $basePath . '/static-assets/entries/' . $coupon_id . '/';
        $file = $path . $fav_icon;
        unlink($file);
        return true;
    }

    public static function delete_sweep_image($id, $coupon_id) {
        $image = ImageData::where('id', $id)->first();
        Functions::delete_dmir_logo($image->src, $coupon_id);
        $res = ImageData::where('id', $id)->delete();
        if ($res) {
            return true;
        } else {
            return false;
        }
    }
    public static function delete_upc_image($id, $customer_id) {
        $image = CustomerUpcImage::where('id', $id)->first();
        Functions::delete_upc_images($image->src, $customer_id);
        $res = CustomerUpcImage::where('id', $id)->delete();
        if ($res) {
            return true;
        } else {
            return false;
        }
    }
    public static function delete_rec_image($id, $customer_id) {
        $image = CustomerReceiptImage::where('id', $id)->first();
        Functions::delete_upc_images($image->src, $customer_id);
        $res = CustomerReceiptImage::where('id', $id)->delete();
        if ($res) {
            return true;
        } else {
            return false;
        }
    }
}