<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
   public function index()
   {

   		return view('front.index');
   }

   public function about()
   {
   		return view('front.about');
   }

   public function services()
   {
   		return view('front.services');
   }
   public function contact()
   {
   	return view('front.contact');
   }

   public function portfolio()
   {
   	return view('front.portfolio');
   }

    public function blog()
   {
   	return view('front.blog');
   }

    public function pricing()
   {
   	return view('front.pricing');
   }

    public function sidebar()
   {
   	return view('front.sidebar');
   }
}
