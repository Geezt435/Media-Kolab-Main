<?php
function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

function hashPassword($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

function hashPhotoProfile($photoName)
{
    $photoNameHashed = openssl_encrypt($photoName, 'AES-128-CTR', 'mediaKolab123', 0, '1234567891011121');
    return $photoNameHashed;
}

function decryptPhotoProfile($hashedPhotoName)
{
    $decryptPhotoName = openssl_decrypt($hashedPhotoName, 'AES-128-CTR', 'mediaKolab123', 0, '1234567891011121');
    return $decryptPhotoName;
}

function generateIdRole()
{
    $newRoleId = random_int(1000, 9999) . date("dmy");
    return $newRoleId;
}

function generateIdEditor()
{
    $newEditorId = random_int(1000, 9999) . date("dmy");
    return $newEditorId;
}

function generateIdCategory()
{
    $newCategoryId = date("dym") . random_int(1000, 9999);
    return $newCategoryId;
}

function generateIdEvent()
{
    $newEventId = generateRandomString(4) . date("dmy");
    return $newEventId;
}

function generateIdJobVacancies()
{
    $newEventId = date("my") . generateRandomString(4) . date("d");
    return $newEventId;
}

function generateIdMedia()
{
    $newIdMedia = date("d") . generateRandomString(2) . date("m") . generateRandomString(2) . date("y");
    return $newIdMedia;
}

function generateIdBlog()
{
    $newIdBlog = date("y") . generateRandomString(3) . date("m") . generateRandomString(1) . date("d");
    return $newIdBlog;
}

function generateIdAd()
{
    $newIdAd = date("d") . generateRandomString(1) . date("m") . generateRandomString(3) . date("y");
    return $newIdAd;
}

function generateIdTag()
{
    $newIdTag = generateRandomString(6) . date("dm");
    return $newIdTag;
}
