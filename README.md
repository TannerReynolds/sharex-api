# sharex-api
A ShareX API That can be used to upload text files, images, video's and much more.

# Setting Up ShareX-API On ShareX
Copy The Settings from the picture shown below
![im1](http://i.imgur.com/S5m3rpA.png)

# Setting Up The ShareX-API Server
1. Download The sharex-api.php file located within this github project.
2. Open the PHP File, Configure the settings to your needs.
3. Upload the PHP File to your webserver.

# ShareX-API Usage
ShareX-API Uses the POST Method for submitting data, so make sure all requests are sent as POST requests.

# Response Codes

## UPLOADED URL
If you are returned with just your url that you uploaded, this means that the upload was a success.

## INVALID_KEY
Invalid Key Means the master key for the sharex-api Is Invalid, you should recheck the key set in the php file.

## INVALID_DATA_PACKET
This Means the data was not successfully transfered, Most likely corrupted or just in general packet-loss

## DATA_TOO_LARGE
This Means the data being uploaded to the server Is Too large, try settings $config["max_upload_size"] abit higher.

## INVALID_DATA_EXTENSION
This Means the extension you are trying to upload Is not on the whitelist. you can add to the extension whitelist at the top of your api php file. ($config["allowed"])

## FILE_CANT_UPLOAD
This Means the file cannot be moved to the destination, try setting the folder you wish to move the images to, to 777 (All Access Rights)

## FILE_ERROR_UNKNOWN
This Means the uploader encountered an odd error to where no errors were found, but the data could not be submitted.
