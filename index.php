<?php


require_once "./functions.php";

if(function_exists("getPath")){
    $path = getPath($_REQUEST);
}

if(function_exists("getList")){
    $listDirFiles = getList($path);
}

if(function_exists("dirActions")){
    dirActions($_REQUEST, $path);
}

if(function_exists("fileActions")){
    fileActions($_REQUEST, $path);
}

if(function_exists("fillFile")){
    $fillFile = fillFile($_REQUEST, $path);
}

if(function_exists("uploadFile")){
    uploadFile($path);
}

require_once "./explorer.php";