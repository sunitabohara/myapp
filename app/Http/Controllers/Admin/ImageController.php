<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    public function dashboardImage()
    {
        $folder_path =public_path().'/img/';
        echo 'dashboard '.$folder_path;
        $num_files = glob($folder_path . "*.{JPG,jpg,gif,png,bmp}", GLOB_BRACE);

        return view('admin.images.index',compact('num_files','folder_path'));
    }
}
