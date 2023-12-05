<?php
setcookie('loginStatus', "", time() - 3600);
setcookie('idAdmin', '', time() - 3600);
setcookie('profilePhoto', '', time() - 3600);

session_start();
session_unset();
session_destroy();

header('Location:login.php');
exit;
