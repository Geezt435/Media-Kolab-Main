<?php
require_once 'getConnection.php';
require_once 'hash.php';
require __DIR__ . '\../vendor/autoload.php';

// Use the Configuration class 
use Cloudinary\Configuration\Configuration;
// Use the UploadApi class for uploading assets
use Cloudinary\Api\Upload\UploadApi;
//Get Detailed Photo
use Cloudinary\Api\Admin\AdminApi;
// Use the AdminAPI class for managing assets
use Cloudinary\Transformation\Resize;
use Cloudinary\Transformation\Gravity;
use Cloudinary\Transformation\FocusOn;
use Cloudinary\Transformation\RoundCorners;
use Cloudinary\Transformation\Delivery;
use Cloudinary\Transformation\Format;
use Cloudinary\Tag\ImageTag;

// Configure an instance of your Cloudinary cloud
Configuration::instance([
    'cloud' => [
        'cloud_name' => 'dx57frg2b',
        'api_key' => '777535978957269',
        'api_secret' => 'y0t83iNgf32i4tHEVI21t5kLiFM'
    ],
    'url' => [
        'secure' => true
    ]
]);

function dateFormatter($dateString)
{
    $formattedDate = date('d F Y', strtotime($dateString));
    return $formattedDate;
}

function getTagNameFromId($idTag)
{
    try {
        $conn = getConnection();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT tag_name FROM tb_tag WHERE tag_id = :tagId";
        $request = $conn->prepare($sql);

        $request->bindParam('tagId', $idTag);
        $request->execute();

        if ($result = $request->fetchAll()) {
            return $result[0]['tag_name'];
        }
    } catch (PDOException $errorMessage) {
        $error = $errorMessage->getMessage();
        echo $error;
    }
}

function getCategoryMediaNameFromId($idcategory)
{
    try {
        $conn = getConnection();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT category_name FROM tb_category_media WHERE category_id = :categoryId";
        $request = $conn->prepare($sql);

        $request->bindParam('categoryId', $idcategory);
        $request->execute();

        if ($result = $request->fetchAll()) {
            return $result[0]['category_name'];
        }
    } catch (PDOException $errorMessage) {
        $error = $errorMessage->getMessage();
        echo $error;
    }
}

function getImageMedia($urlPhoto, $size)
{
    $admin = new AdminApi();
    $assetData = $admin->asset($urlPhoto, [
        'colors' => TRUE
    ]);
    $assetWidth = $assetData['width'];
    $assetHeight = $assetData['height'];
    $cropSize = $assetHeight <= $assetWidth ? $assetHeight : $assetWidth;

    //Get Photo
    $imgtag = (new ImageTag($urlPhoto))
        ->resize(
            Resize::crop()->width($cropSize)
                ->height($cropSize)
        )
        ->roundCorners(RoundCorners::byRadius(120))
        ->resize(Resize::scale()->width($size))
        ->delivery(Delivery::format(
            Format::auto()
        ));

    return (string)$imgtag;
}

function uploadImageMedia($thumbnailName, $imageFile)
{
    $newThumbnail = $imageFile["tmp_name"];
    $newPhotoSize = filesize($newThumbnail);
    $newPhotoType = mime_content_type($newThumbnail);

    if ($newPhotoSize <= 6000000 && ($newPhotoType == 'image/jpg' || $newPhotoType == 'image/png' || $newPhotoType == 'image/jpeg')) {
        //Upload into cloudinary process
        $upload = new UploadApi();
        $upload->upload($newThumbnail, [
            'public_id' => $thumbnailName,
            'use_filename' => TRUE,
            'overwrite' => TRUE
        ]);

        return true;
    } else {
        return false;
    }
}
function deleteImageMedia($thumbnailName)
{
    $api = new UploadApi();
    if (!is_null($thumbnailName)) {
        try {
            $api->destroy($thumbnailName);
            $api->destroy($thumbnailName);
        } catch (PDOException $errorMessage) {
            $error = $errorMessage->getMessage();
            echo $error;
        }
    }
}
