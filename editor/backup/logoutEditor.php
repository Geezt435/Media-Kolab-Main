<?php
setcookie('editorLoginStatus', "", time() - 3600);
setcookie('editorId', '', time() - 3600);
setcookie('editorProfilePhoto', '', time() - 3600);



session_start();
session_unset();
session_destroy();

header('Location:loginEditor.php');
exit;
