<?php
/** Autoload the file with composer autoloader */
require '../vendor/autoload.php';

/** AWS S3 Bucket Name */
$bucket_name = 'mt-aws-s3/image1';

/** AWS S3 Bucket Access Key ID */
$access_key_id    = '';

/** AWS S3 Bucket Secret Access Key */
$secret = '';

/** You can generate random file name here */
$file_name          = 'test.png';

/** Full path of the file where it exists */
$file_location      = '../assets/images/'. $file_name;

/** With the following code I am fetching the MIME type of the file */
$finfo              = new finfo(FILEINFO_MIME_TYPE);
$file_mime          = $finfo->file($file_location);

/** Let's initialize our AWS Client for the file uploads */
$s3 = new Aws\S3\S3Client([
    /** Region you had selected, if don't know check in S3 listing */
    'region'  => 'ap-southeast-1',
    'version' => 'latest',
    /** Your AWS S3 Credential will be added here */
    'credentials' => [
        'key'    => $access_key_id,
        'secret' => $secret,
    ]
]);

/** Since the SDK throw exception if any error
 * I am adding in try, catch
 */
$images_upload = "";
try {
    $aws_object = $s3->putObject([
        /** You bucket name */
        'Bucket'        => $bucket_name,
        /** This is the upload file name, you can change above */
        'Key'           => $file_name,
        /** Give the complete path from where it needs to upload the file */
        'SourceFile'    => $file_location,
        /** Keep It Public Unless You dont want someone to access it
         * You can skip the following if you want to keep it private
         */
        'ACL'           => 'public-read',
        /** Make sure to add the following line,
         * else it will download once you use the end URL to render
         */
        // 'ContentType'   => 'image/jpeg'
        'ContentType'   => $file_mime
    ]);

    /**
     * Uncomment the following for debugging the whole object
     */

    /** Type 2 - Uploaded AWS S3 Bucket URL */
    $images_upload = $aws_object['ObjectURL'];

} catch (Aws\Exception\AwsException $e) {
    /** Handle the error if any */
    echo '<pre>';
    var_dump($e->getAwsErrorMessage());
    echo '<pre>';
    die;
}
?>

<img src="<?php echo $images_upload; ?>" alt="">