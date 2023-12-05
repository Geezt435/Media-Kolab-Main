<?php
require_once 'getConnection.php';
require_once 'hash.php';
require __DIR__ . '/../vendor/autoload.php';

// Use the Configuration class 
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
// Use the UploadApi class for uploading assets
use Cloudinary\Api\Upload\UploadApi;
//Get Detailed Photo
use Cloudinary\Api\Admin\AdminApi;
// Use the AdminApi class for managing assets
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


function imageTagToURL($imgtag)
{
    // Use regular expression to extract the source URL
    $pattern = '/<img src="([^"]+)"/';
    preg_match($pattern, $imgtag, $matches);

    if (isset($matches[1])) {
        $sourceUrl = $matches[1];
        return $sourceUrl;
    } else {
        return "";
    }
}

function getAdminPhotoId($idAdmin)
{
    try {
        $conn = getConnection();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT profile_photo FROM tb_admin WHERE admin_id = :adminId";
        $request = $conn->prepare($sql);

        $request->bindParam('adminId', $idAdmin);
        $request->execute();

        if ($result = $request->fetchAll()) {
            $photoName = $result[0]['profile_photo'];
            if (is_null($photoName)) {
                $decryptPhotoName = null;
            } else {
                $decryptPhotoName = decryptPhotoProfile($photoName);
            }
        }
        return $decryptPhotoName;
    } catch (PDOException $errorMessage) {
        $error = $errorMessage->getMessage();
        echo $error;
    }
}

function getEditorPhotoId($editorId)
{
    try {
        $conn = getConnection();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT profile_photo FROM tb_editor WHERE editor_id = :editorId";
        $request = $conn->prepare($sql);

        $request->bindParam('editorId', $editorId);
        $request->execute();

        if ($result = $request->fetchAll()) {
            $photoName = $result[0]['profile_photo'];
            if (is_null($photoName)) {
                $decryptPhotoName = null;
            } else {
                $decryptPhotoName = decryptPhotoProfile($photoName);
            }
        }
        return $decryptPhotoName;
    } catch (PDOException $errorMessage) {
        $error = $errorMessage->getMessage();
        echo $error;
    }
}

function getImageProfile($urlPhoto, $width = 60)
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
                ->gravity(
                    Gravity::focusOn(
                        FocusOn::face()
                    )
                )
        )
        ->roundCorners(RoundCorners::max())
        ->resize(Resize::scale()->width($width))
        ->delivery(Delivery::format(
            Format::auto()
        ));

    return (string)$imgtag;
}

function getImageDefault($urlPhoto)
{
    //Get Photo
    $imgtag = (new ImageTag($urlPhoto))
        ->resize(Resize::limitFit()->width(1000)->height(670))
        ->delivery(Delivery::format(
            Format::auto()
        ))->delivery(Delivery::quality(60));

    return imageTagToURL($imgtag);
}

function getImageNews($urlPhoto)
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
        ->resize(Resize::scale()->width(1000)->height(670))
        ->delivery(Delivery::format(
            Format::auto()
        ))->delivery(Delivery::quality(60));

    return (string)$imgtag;
}

function uploadImageAdmin($idAdmin, $photoTemp, $locationRedirect)
{
    $newPhotoSize = filesize($photoTemp);
    $newPhotoType = mime_content_type($photoTemp);

    if ($newPhotoSize <= 6000000 && ($newPhotoType == 'image/jpg' || $newPhotoType == 'image/png' || $newPhotoType == 'image/jpeg')) {
        $photoName = random_int(0, PHP_INT_MAX) . date("dmYHis") . $idAdmin;
        $photoNameHashed = hashPhotoProfile($photoName);

        //Delete exPhoto
        deleteImageAdmin($idAdmin);

        //Upload into cloudinary process
        $upload = new UploadApi();
        $upload->upload($photoTemp, [
            'public_id' => $photoName,
            'use_filename' => TRUE,
            'overwrite' => TRUE
        ]);

        try {
            $conn = getConnection();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "UPDATE tb_admin SET profile_photo = :newPhoto WHERE admin_id = :idAdmin";
            $request = $conn->prepare($sql);

            $request->bindParam('idAdmin', $idAdmin);
            $request->bindParam('newPhoto', $photoNameHashed);
            $request->execute();

            //Saving profile photo into cookies
            $decrypt = decryptPhotoProfile($photoNameHashed);

            //Automatically getting the Photo
            $imgtag = getImageProfile($decrypt);
            if (isset($_COOKIE['loginStatus'])) {
                setcookie('profilePhoto', $imgtag, time() + (86400 * 7));
            } else {
                $_SESSION['profilePhoto'] = $imgtag;
            }

            $conn = null;
            header("Location:$locationRedirect");
        } catch (PDOException $errorMessage) {
            $error = $errorMessage->getMessage();
            echo $error;
        }
    } else {
        echo "Gabisa cuy";
    }
}

function uploadImageEditor($editorId, $photoTemp, $locationRedirect)
{
    $newPhotoSize = filesize($photoTemp);
    $newPhotoType = mime_content_type($photoTemp);

    if ($newPhotoSize <= 6000000 && ($newPhotoType == 'image/jpg' || $newPhotoType == 'image/png' || $newPhotoType == 'image/jpeg')) {
        $photoName = random_int(0, PHP_INT_MAX) . date("dmYHis") . $editorId;
        $photoNameHashed = hashPhotoProfile($photoName);

        //Delete exPhoto
        deleteImageEditor($editorId);

        //Upload into cloudinary process
        $upload = new UploadApi();
        $upload->upload($photoTemp, [
            'public_id' => $photoName,
            'use_filename' => TRUE,
            'overwrite' => TRUE
        ]);

        try {
            $conn = getConnection();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "UPDATE tb_editor SET profile_photo = :newPhoto WHERE editor_id = :editorId";
            $request = $conn->prepare($sql);

            $request->bindParam('editorId', $editorId);
            $request->bindParam('newPhoto', $photoNameHashed);
            $request->execute();

            //Saving profile photo into cookies
            $decrypt = decryptPhotoProfile($photoNameHashed);

            //Automatically getting the Photo
            $imgtag = getImageProfile($decrypt);
            if (isset($_COOKIE['loginStatus'])) {
                setcookie('editorProfilePhoto', $imgtag, time() + (86400 * 7));
            } else {
                $_SESSION['editorProfilePhoto'] = $imgtag;
            }

            $conn = null;
            header("Location:$locationRedirect");
            exit;
        } catch (PDOException $errorMessage) {
            $error = $errorMessage->getMessage();
            echo $error;
        }
    } else {
        echo "Gabisa cuy";
    }
}

function deleteImageAdmin($idAdmin)
{
    $api = new UploadApi();
    $photoId = getAdminPhotoId($idAdmin);

    if (!is_null($photoId)) {
        $api->destroy($photoId);

        //Update table
        try {
            $conn = getConnection();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "UPDATE tb_admin SET profile_photo = :setToNull WHERE admin_id = :idAdmin";
            $request = $conn->prepare($sql);
            $setToNull = null;

            //Set into null
            $request->bindParam('idAdmin', $idAdmin);
            $request->bindParam('setToNull', $setToNull);
            $request->execute();

            //Set cookie or session into default image
            $imgtag = "<img class='profile-image' src='../assets/images/profiles/profile-1.png' alt='Profile Photo'>";
            if (isset($_COOKIE['loginStatus'])) {
                setcookie('profilePhoto', $imgtag, time() + (86400 * 7));
            } else {
                $_SESSION['profilePhoto'] = $imgtag;
            }

            $conn = null;
        } catch (PDOException $errorMessage) {
            $error = $errorMessage->getMessage();
            echo $error;
        }
    }
}

function deleteImageEditor($editorId)
{
    $api = new UploadApi();
    $photoId = getEditorPhotoId($editorId);

    if (!is_null($photoId)) {
        $api->destroy($photoId);

        //Update table
        try {
            $conn = getConnection();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "UPDATE tb_editor SET profile_photo = :setToNull WHERE editor_id = :editorId";
            $request = $conn->prepare($sql);
            $setToNull = null;

            //Set into null
            $request->bindParam('editorId', $editorId);
            $request->bindParam('setToNull', $setToNull);
            $request->execute();

            //Set cookie or session into default image
            $imgtag = "<img class='profile-image' src='../assets/images/profiles/profile-1.png' alt='Profile Photo'>";
            if (isset($_COOKIE['editorLoginStatus'])) {
                setcookie('editorProfilePhoto', $imgtag, time() + (86400 * 7));
            } else {
                $_SESSION['editorProfilePhoto'] = $imgtag;
            }

            $conn = null;
        } catch (PDOException $errorMessage) {
            $error = $errorMessage->getMessage();
            echo $error;
        }
    }
}


//Function for uploading image for blog, event, job-vacancies, and media
function uploadImageNews($newImageTemp)
{
    $newPhotoSize = filesize($newImageTemp);
    $newPhotoType = mime_content_type($newImageTemp);

    if ($newPhotoSize <= 15000000 && ($newPhotoType == 'image/jpg' || $newPhotoType == 'image/png' || $newPhotoType == 'image/jpeg')) {
        $photoName = random_int(0, PHP_INT_MAX) . date("dmYHis");
        $photoNameHashed = hashPhotoProfile($photoName);

        //Upload into cloudinary process
        $upload = new UploadApi();
        $upload->upload($newImageTemp, [
            'public_id' => $photoName,
            'use_filename' => TRUE,
            'overwrite' => TRUE
        ]);

        return $photoNameHashed;
    } else {
        echo "Gabisa cuy";
    }
}
