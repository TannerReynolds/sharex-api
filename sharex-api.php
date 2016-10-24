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

// NOTE: REMEMBER TO SET upload_max_filesize in the php.ini!

// Set Our Return data type to text, (to prevent any sort of XSS or php shell execution exploitation)
header("Content-Type: text/text");

///
/// Application Paramaters
///
$config = array();

$config["key"] = ""; // This is the master key, to access the uploader
$config["save"] = "i/"; // Enter the directory to save to (keep empty for none)
$config["host"] = "http://" . $_SERVER['HTTP_HOST'] . "/";
$config["allowed"] = array("png", "jpg", "gif", "rar", "zip", "mp4", "mp3", "txt", "h", "cpp", "lua", "dll");
$config["max_upload_size"] = 25; // IN MB

///
/// Upload File
///
function UploadFile($config)
{

  // Validate Key
  if(!isset($_POST["key"]) || $_POST["key"] != $config["key"])
    die("INVALID_KEY");

  // Validate ShareX
  if(!isset($_FILES["fdata"]))
    die("INVALID_DATA_PACKET");

  if($_FILES["fdata"]["size"] > $config["max_upload_size"] * 1024 * 1024)
    die("DATA_TOO_LARGE");

  // Create Data for file
  $data = array();
  $data["filename"] = $_FILES["fdata"]['name'];
  $data["buffer"] = $_FILES["fdata"]["tmp_name"];
  $data["extension"] = pathinfo($_FILES["fdata"]['name'], PATHINFO_EXTENSION);
  $data["final-save-name"] = $config["save"] . $data["filename"] . "." . $data["extension"];
  //$data["uploaded"] = move_uploaded_file($data["buffer"], $data["final-save-name"]);

  // Validate Extension
  if(!in_array($data["extension"], $config["allowed"]))
    die("INVALID_DATA_EXTENSION");

  if(move_uploaded_file($data["buffer"], $data["final-save-name"]))
  {
    $file_signed = crc32(md5_file($data["final-save-name"])) % 100000; // Sign file with a crc32 and md5'd file hash (Also good because they cant upload the same file twice)
    rename($data["final-save-name"], $config["save"] . $file_signed . "." . $data["extension"]); // Rename file

    die($config["host"] . $config["save"] . $file_signed . "." . $data["extension"]); // Return file location
  }
  else
  {
    die("FILE_CANT_UPLOAD");
  }

  die("FILE_ERROR_UNKNOWN");

}

UploadFile($config);

?>
