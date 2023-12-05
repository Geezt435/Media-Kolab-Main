<?php
require_once "getConnection.php";


function increaseBlog($blogId)
{
    try {
        $conn = getConnection();
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE tb_blog SET views = views + 1 WHERE blog_id = :blogId";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam("blogId", $blogId);
        $stmt->execute();

        $conn = null;
    } catch (\Throwable $error) {
        echo "Connection failed: " . $error->getMessage();
    }
}


function increaseMedia($mediaId)
{
    try {
        $conn = getConnection();
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE tb_media SET views = views + 1 WHERE media_id = :mediaId";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam("mediaId", $mediaId);
        $stmt->execute();

        $conn = null;
    } catch (\Throwable $error) {
        echo "Connection failed: " . $error->getMessage();
    }
}

function increaseEvent($eventId)
{
    try {
        $conn = getConnection();
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE tb_event SET views = views + 1 WHERE event_id = :eventId";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam("eventId", $eventId);
        $stmt->execute();

        $conn = null;
    } catch (\Throwable $error) {
        echo "Connection failed: " . $error->getMessage();
    }
}

function increaseJobVacancies($jobId)
{
    try {
        $conn = getConnection();
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE tb_job_vacancies SET views = views + 1 WHERE vacancy_id = :jobId";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam("jobId", $jobId);
        $stmt->execute();

        $conn = null;
    } catch (\Throwable $error) {
        echo "Connection failed: " . $error->getMessage();
    }
}

function increaseTag($tagId)
{
    try {
        $conn = getConnection();
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE tb_tag SET popularity = popularity + 1 WHERE tag_id = :tagId";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam("tagId", $tagId);
        $stmt->execute();

        $conn = null;
    } catch (\Throwable $error) {
        echo "Connection failed: " . $error->getMessage();
    }
}

function increaseBlogCategory($blogCatId)
{
    try {
        $conn = getConnection();
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE tb_category_blog SET popularity = popularity + 1 WHERE blogCat_id = :blogCatId";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam("blogCatId", $blogCatId);
        $stmt->execute();

        $conn = null;
    } catch (\Throwable $error) {
        echo "Connection failed: " . $error->getMessage();
    }
}

function increaseEventCategory($eventCatId)
{
    try {
        $conn = getConnection();
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE tb_category_event SET popularity = popularity + 1 WHERE eventCat_id = :eventCatId";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam("eventCatId", $eventCatId);
        $stmt->execute();

        $conn = null;
    } catch (\Throwable $error) {
        echo "Connection failed: " . $error->getMessage();
    }
}

function increaseJobCategory($jobCatId)
{
    try {
        $conn = getConnection();
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE tb_category_job_vacancy SET popularity = popularity + 1 WHERE jobCat_id = :jobCatId";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam("jobCatId", $jobCatId);
        $stmt->execute();

        $conn = null;
    } catch (\Throwable $error) {
        echo "Connection failed: " . $error->getMessage();
    }
}

function increaseMediaCategory($mediaCatId)
{
    try {
        $conn = getConnection();
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE tb_category_media SET popularity = popularity + 1 WHERE mediaCat_id = :mediaCatId";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam("mediaCatId", $mediaCatId);
        $stmt->execute();

        $conn = null;
    } catch (\Throwable $error) {
        echo "Connection failed: " . $error->getMessage();
    }
}
