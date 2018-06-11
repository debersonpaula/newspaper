<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //create the controller with authentication middleware
    public function __construct()
    {
        $this->middleware('auth');
    }

    //show my dashboard page
    public function index()
    {
        $articles = DB::select('select a.*,b.name,b.email from lib_articles a inner join users b on a.userID=b.ID where userID = ? order by a.id desc', [Auth::id()]);
        $activated = Auth::user()->activated;
        return view('home',['articles' => $articles, 'activated' => $activated]);
    }
}
