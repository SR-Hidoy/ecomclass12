<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
class FrontendController extends Controller
{
    //
    function index(){

        return view('index', [
          'categories' => Category::all()
        ]);
    }
    function contact(){
        return view('contact');
    }
    function about(){

      return view('about');
    }



}
