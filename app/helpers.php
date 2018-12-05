<?php
/**
 * Created by PhpStorm.
 * User: LeeSJ
 * Date: 2018-11-25
 * Time: 오후 2:56
 */

function attachments_path($path = '')
{
    return public_path('files' . ($path ? DIRECTORY_SEPARATOR . $path : $path));
}

function format_filesize($bytes)
{
    if(! is_numeric($bytes)) return 'NaN';

    $decr = 1024;
    $step = 0;
    $suffix = ['bytes','KB','MB'];

    while(($bytes / $decr) > 0.9){
        $bytes = $bytes / $decr;
        $step ++;
    }

    return round($bytes, 2) . $suffix[$step];
}