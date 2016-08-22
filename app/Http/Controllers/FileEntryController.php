<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use File , Response;

class FileEntryController extends Controller
{
    public function get(Request $request, $path, $filename){

        $path = storage_path($path . '/' . $filename);

        if (File::exists($path)) {
            $bytes 		= File::size($path);
            $contents 	= File::get($path);
            $mime 		= File::mimeType($path);

            $headers = [
                'Content-Type'	 => $mime,
                'Content-Length' => $bytes
            ];

            $response 	= Response::make( $contents, 200, $headers );

            $filetime 	= filemtime($path);
            $etag 		= md5($filetime);
            $time 		= date('r', $filetime);
            $expires 	= date('r', $filetime + 3600);

            $response->setEtag($etag);
            $response->setLastModified( new \DateTime($time) );
            $response->setExpires( new \DateTime($expires) );
            $response->setPublic();

            if($response->isNotModified($request)) {
                // Return empty response if not modified
                return $response;
            }
            else {
                // Return file if first request / modified
                $response->prepare($request);
                return $response;
            }
        }
        else{
            return 0;
        }
    }

    public function image(Request $request, $entiry_name, $entiry_id, $filename){

        $full_path 	= getFullFolderDirPathFromId($entiry_name, $entiry_id) . '/profile/';



        if ($request->exists('thumb'))
            $full_path .= 'thumb/';

        $img_path	= $full_path . $filename;

        if (File::exists($img_path)) {
            $bytes 		= File::size($img_path);
            $contents 	= File::get($img_path);
            $mime 		= File::mimeType($img_path);

            $headers = [
                'Content-Type'	 => $mime,
                'Content-Length' => $bytes
            ];

            $response 	= Response::make( $contents, 200, $headers );

            $filetime 	= filemtime($img_path);
            $etag 		= md5($filetime);
            $time 		= date('r', $filetime);
            $expires 	= date('r', $filetime + 3600);

            $response->setEtag($etag);
            $response->setLastModified( new \DateTime($time) );
            $response->setExpires( new \DateTime($expires) );
            $response->setPublic();

            if($response->isNotModified($request)) {
                // Return empty response if not modified
                return $response;
            }
            else {
                // Return file if first request / modified
                $response->prepare($request);
                return $response;
            }
        }

        return 0;
    }
}
