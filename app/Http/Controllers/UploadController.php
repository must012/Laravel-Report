<?php
/**
 * Created by PhpStorm.
 * User: LeeSJ
 * Date: 2018-11-17
 * Time: 오후 5:28
 */

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use DOMDocument;


class UploadController extends Controller
{

    public function imageUpload(Request $request)
    {
        if ($request->file('upload')->isValid()) {
            $dateFileDir = date("YmdHis");
            $originFile = $request->file("upload")->getClientOriginalName();

            $ext = substr(strrchr($originFile, '.'), 1);
            $ext = strtolower($ext);
            $saveFileName = $dateFileDir . "_" . str_replace(" ", "_", $originFile);

            if ($ext == 'jpg' or $ext == 'gif' or $ext == 'png' or $ext == 'jpeg') {
                $request->file("upload")->storeAs('public', $saveFileName);
            } else {
                exit;
            }
            $url = asset('storage/' . $saveFileName);

            echo '{"filename" : "' . $saveFileName . '", "uploaded" : 1, "url":"' . $url . '"}';
        } else {
            echo 'Ooops!  Your file triggered the following error';
        }
    }
}