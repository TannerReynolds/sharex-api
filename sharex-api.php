<?php

/*
  ********************
  ShareX-API
  By Senator
  ********************
*/

// NOTE: REMEMBER TO SET upload_max_filesize in the php.ini!

// Set Our Return data type to text, (to prevent any sort of XSS or php shell execution exploitation)
header("Content-Type: text/text");

///
/// Application Paramaters
///
$config = array();

$config["key"] = "2371858247"; // This is the master key, to access the uploader
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
