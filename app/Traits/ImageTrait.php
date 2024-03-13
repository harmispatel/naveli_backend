<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Carbon\Carbon;
// use Intervention\Image\Facades\Image;

trait ImageTrait
{
    public function randomMediaName($limit)
    {
        $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $max = strlen($string) - 1;
        $token = '';
        for ($i = 0; $i < $limit; $i++)
        {
            $token .= $string[mt_rand(0, $max)];
        }
        return $token;
    }

    public function optionViewType(){
     
        $viewType = ['1'=>'calender','2'=>'text','3'=>'number'];        
        return $viewType;
    }

    // Upload Single Image
    public function addSingleImage($path,$file,$old_image = null)
    {     
        // Delete old Image if Exists
        if ($old_image != null && file_exists('public/images/uploads/'.$path.'/'.$old_image))
        {
            unlink('public/images/uploads/'.$path.'/'.$old_image);
        }

        // Upload New Image
        if ($file != null)
        {
            $filename = $this->randomMediaName(5).".".$file->getClientOriginalExtension();

            // Image Upload Path
            $image_path = public_path().'/images/uploads/'.$path;

            //     // $image->save($image_path.'/'.$filename);
                $file->move($image_path, $filename);

            return $filename;
        }
    }




}
