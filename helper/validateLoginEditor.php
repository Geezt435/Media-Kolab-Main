<?php
/*
Validasi login untuk editor
*/
session_start();

if (!isset($_COOKIE['editorLoginStatus']) && !isset($_SESSION['editorLoginStatus'])) {
    header('Location:loginEditor.php');
    exit;
}

//Get Photo Profile
$editorProfilePhoto = $_COOKIE['editorProfilePhoto'] ?? $_SESSION['editorProfilePhoto'];

//Get Admin ID
$editorId = $_SESSION['editorId'] ?? $_COOKIE['editorId'];
