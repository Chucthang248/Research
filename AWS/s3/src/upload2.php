<?php

require '../vendor/autoload.php';
require '../../../config.php';

use Aws\S3\S3Client;

// Instantiate an Amazon S3 client.
$s3Client = new S3Client([
    'version' => 'latest',
    'region'  => 'ap-southeast-1',
    'credentials' => [
        'key'    => $AWS_ACCESS_KEY,
        'secret' => $AWS_SECRECT_KEY
    ]
]);
$dir_upload = "../upload/";
$rs_image = "";
// Check if the form was submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if file was uploaded without errors
    if(isset($_FILES["anyfile"]) && $_FILES["anyfile"]["error"] == 0){
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES["anyfile"]["name"];
        $filetype = $_FILES["anyfile"]["type"];
        $filesize = $_FILES["anyfile"]["size"];
    
        // Validate file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");
    
        // Validate file size - 10MB maximum
        $maxsize = 10 * 1024 * 1024;
        if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");
          
    
        // Validate type of the file
        if(in_array($filetype, $allowed)){
            // Check whether file exists before uploading it
            if(file_exists($dir_upload . $filename)){
                echo $filename . " is already exists.";
            } else{
                if(move_uploaded_file($_FILES["anyfile"]["tmp_name"], $dir_upload . $filename)){

                    $bucket = 'mt-aws-s3';
                    $file_Path = $dir_upload. $filename;
                    $key = basename($file_Path);
                    
                    try {
                        $result = $s3Client->putObject([
                            'Bucket' => $bucket,
                            'Key'    => 'image1/'.$key,
                            'SourceFile'   => $file_Path,
                            'ACL'    => 'public-read', // make file 'public'
                        ]);
                        $rs_image = $result->get('ObjectURL');
                    } catch (Aws\S3\Exception\S3Exception $e) {
                        echo "There was an error uploading the file.\n";
                        echo $e->getMessage();
                    }
                    echo "Your file was uploaded successfully.";
                }else{

                   echo "File is not uploaded";
                }
                
            } 
        } else{
            echo "Error: There was a problem uploading your file. Please try again."; 
        }
    } else{
        echo "Error: " . $_FILES["anyfile"]["error"];
    }
}
?>
<img src="<?php echo $rs_image; ?>" alt="">