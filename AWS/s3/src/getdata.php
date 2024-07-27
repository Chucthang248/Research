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

$results = $s3Client->getPaginator('ListObjects', [
    'Bucket' => 'mt-aws-s3'
]);
foreach ($results as $result) {
    foreach ($result['Contents'] as $object) {
        echo $object['Key'] . PHP_EOL;
    }
}

die;