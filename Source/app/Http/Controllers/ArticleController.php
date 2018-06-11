<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    //works only if the users is logged
    public function __construct(){
        $this->middleware('auth');
    }

    //method to add article
    public function postArticle(Request $request){

        //Retrieve data
        $artTitle = $request->input('artTitle');
        $artText = $request->input('artText');
        $artPhotoFile = $request->file('artPhoto');
        $userid = Auth::id();

        //insert data to DB and retrieve inserted ID
        $lastid = DB::table('lib_articles')->insertGetId(['artTitle'=>$artTitle,'artText'=>$artText,'userID'=>$userid]);

        //save the image in the images directory => "\newspaper\storage\app\images"
        if($artPhotoFile)
            if($artPhotoFile->isValid()){
                $ext = $artPhotoFile->extension();
                $artPhotoFile->storeAs('images','img'.$lastid.'.'.$ext);
            }

        //go to home page (mydashboard)
        return redirect('home');
    }

    //method to remove article
    public function removeArticle(Request $request){

        //Retrieve data
        $id = $request->input('id');
        $userid = Auth::id();
        
        //delete data from DB
        $deleted = DB::insert('delete from lib_articles where id=? and userID=?', [$id,$userid]);

        //go to home page (mydashboard)
        return redirect('home');
    }
}
