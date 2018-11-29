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