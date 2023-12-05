<?php
require_once 'getConnection.php';
require_once 'hash.php';

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

function getCategoryEventNameFromId($idcategory)
{
    try {
        $conn = getConnection();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT category_name FROM tb_category_event WHERE category_id = :categoryId";
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
