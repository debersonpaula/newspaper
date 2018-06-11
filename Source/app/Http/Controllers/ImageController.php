<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    //method to show article details
    public function getImage(Request $request, $id){
        //get path of image storage + img mask filename
        //and search for the file
        $filename = glob( __DIR__ . '/../../../storage/app/images/' . 'img' . $id . '.*');
        //if file was sucessfully searched, send it to the requester
        if (count($filename) > 0){
            //Get the size of an image and some info about it
            $imginfo = getimagesize($filename[0]);
            //clear output before image
            ob_get_clean();

            ob_start();
            //Send header
            header("Content-type: ".$imginfo['mime']);
            //Send to output directly (avoiding get_file_content to save memory)
            readfile($filename[0]);
            ob_end_flush();
        }
        else
            echo '';
    }
}
