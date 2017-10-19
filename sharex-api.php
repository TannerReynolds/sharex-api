<?php

/*
  ********************
  ShareX-API
  By Senator
  ********************
  
  MIT License

  Copyright (c) 2016 senator
  
  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files (the "Software"), to deal
  in the Software without restriction, including without limitation the rights
  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  copies of the Software, and to permit persons to whom the Software is
  furnished to do so, subject to the following conditions:
  
  The above copyright notice and this permission notice shall be included in all
  copies or substantial portions of the Software.
  
  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
  SOFTWARE.
*/




header("Content-Type: text/text");


$config = array();

$config["key"] = "%B,D^VLol/!YF{Ax";
$config["save"] = ""; 
$config["host"] = "http://" . $_SERVER['HTTP_HOST'] . "/";
$config["allowed"] = array("png", "jpg", "gif", "mp4", "mp3", "txt", "jpeg", "tiff", "bmp", "ico", "psd", "eps", "raw", "cr2", "nef", "sr2", "orf", "svg", "wav", "webm", "aac", "flac", "ogg", "wma", "m4a", "gifv");
$config["max_upload_size"] = 50; 

$configAdmin = array();

$configAdmin["save"] = ""; 
$configAdmin["host"] = "http://" . $_SERVER['HTTP_HOST'] . "/";
$configAdmin["allowed"] = array("png", "jpg", "gif", "mp4", "mp3", "txt", "jpeg", "tiff", "bmp", "ico", "psd", "eps", "raw", "cr2", "nef", "sr2", "orf", "svg", "wav", "webm", "aac", "flac", "ogg", "wma", "m4a", "gifv", "json", "zip", "exe", "php", "html", "css", "lua", "js", "java", "ini", "rar", "md", "xml", "bat", "less", "jar", "sass", "cs", "dll", "iso", "cfg", "torrent", "7zip", "bin", "ovpn", "pkg");
$configAdmin["max_upload_size"] = 1024; 


if(!isset($_POST["key"]) || $_POST["key"] != $config["key"]) {
function UploadFile($config)
{
  
  if(!isset($_FILES["fdata"]))
    die("INVALID_DATA_PACKET");

  if($_FILES["fdata"]["size"] > $config["max_upload_size"] * 1024 * 1024)
    die("DATA_TOO_LARGE");

  
  $data = array();
  $data["filename"] = $_FILES["fdata"]['name'];
  $data["buffer"] = $_FILES["fdata"]["tmp_name"];
  $data["extension"] = pathinfo($_FILES["fdata"]['name'], PATHINFO_EXTENSION);
  $data["final-save-name"] = $config["save"] . $data["filename"] . "." . $data["extension"];
  

  
  if(!in_array($data["extension"], $config["allowed"]))
    die("INVALID_DATA_EXTENSION");

  if(move_uploaded_file($data["buffer"], $data["final-save-name"]))
  {
    $file_signed = crc32(md5_file($data["final-save-name"])) % 100000; 
    rename($data["final-save-name"], $config["save"] . $file_signed . "." . $data["extension"]); 

    die($config["host"] . $config["save"] . $file_signed . "." . $data["extension"]); 
  }
  else
  {
    die("FILE_CANT_UPLOAD");
  }

  die("FILE_ERROR_UNKNOWN");

}

UploadFile($config);
} else {


  function UploadFile($configAdmin)
{
  // Validate ShareX
  if(!isset($_FILES["fdata"]))
    die("INVALID_DATA_PACKET");

  if($_FILES["fdata"]["size"] > $configAdmin["max_upload_size"] * 1024 * 1024)
    die("DATA_TOO_LARGE");

  
  $data = array();
  $data["filename"] = $_FILES["fdata"]['name'];
  $data["buffer"] = $_FILES["fdata"]["tmp_name"];
  $data["extension"] = pathinfo($_FILES["fdata"]['name'], PATHINFO_EXTENSION);
  $data["final-save-name"] = $configAdmin["save"] . $data["filename"] . "." . $data["extension"];
  

  
  if(!in_array($data["extension"], $configAdmin["allowed"]))
    die("INVALID_DATA_EXTENSION");

  if(move_uploaded_file($data["buffer"], $data["final-save-name"]))
  {
    $file_signed = crc32(md5_file($data["final-save-name"])) % 100000; 
    rename($data["final-save-name"], $configAdmin["save"] . $file_signed . "." . $data["extension"]); 

    die($configAdmin["host"] . $configAdmin["save"] . $file_signed . "." . $data["extension"]); 
  }
  else
  {
    die("FILE_CANT_UPLOAD");
  }

  die("FILE_ERROR_UNKNOWN");

}

UploadFile($configAdmin);



}



?>
