<?php
/*
Memvalidasi login
*/
session_start();

if (!isset($_COOKIE['loginStatus']) && !isset($_SESSION['loginStatus'])) {
    header('Location:login.php');
    exit;
}

//Get Photo Profile
$profilePhoto = $_COOKIE['profilePhoto'] ?? $_SESSION['profilePhoto'];

//Get Admin ID
$idAdmin = $_SESSION['idAdmin'] ?? $_COOKIE['idAdmin'];
