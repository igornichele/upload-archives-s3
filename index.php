<?php
  use Aws\S3\S3Client;
  use Aws\Exception\AwsException;

  require_once "vendor/autoload.php";

  define('AWS_S3_KEY', 'key');
  define('AWS_S3_SECRET', 'secret');
  define('AWS_S3_REGION', 'region');
  define('AWS_S3_BUCKET', 'bucket-name');
  define('AWS_S3_VERSION', 'v4');

  if(isset($_POST['saveFile'])){
    $filepath   = $_FILES['file']['tmp_name'];
    $key        = $_FILES['file']['name'];

    try{
      //Create a S3Client
      $s3 = S3Client::factory(array(
        'key'       => AWS_S3_KEY,
        'secret'    => AWS_S3_SECRET,
        'signature' => AWS_S3_VERSION, 
        'region'    => AWS_S3_REGION
      ));

      $result = $s3->putObject([
          'Bucket'     => AWS_S3_BUCKET,
          'Key'        => $key,
          'SourceFile' => $filepath,
          'Body'       => '',
          'ACL'        => 'public-read'
      ]);
    } catch (S3Exception $e) {
        echo $e->getMessage() . "\n";
    }
  }
?>

<form role="form" action="" method="post" enctype= "multipart/form-data" >
     <input type="file" id="file" name="file" required />
     <input type="submit" name="saveFile" value="Send File"/>
</form>