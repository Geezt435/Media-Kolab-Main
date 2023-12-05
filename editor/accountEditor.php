<?php
require_once "../helper/getConnection.php";
require_once "../helper/getConnectionMsqli.php";
require_once '../helper/validateLoginEditor.php';
require_once "../helper/hash.php";
require_once "../helper/cloudinary.php";
require '../vendor/autoload.php';

// //require __DIR__ . '../vendor/autoload.php';


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['changePhotoButton'])) {
        $newPhoto = $_FILES['new-photo']['tmp_name'];
        uploadImageEditor($editorId, $newPhoto, "accountEditor.php");
    }

    if (isset($_POST['changeName'])) {
        $newusername = $_POST['newusername'];

        $connMyqli = getConnectionMysqli();
        $sqlUpdateName = "UPDATE tb_editor SET username = '$newusername' WHERE editor_id = $editorId ";
        mysqli_query($connMyqli, $sqlUpdateName);
        mysqli_close($connMyqli);
    }
    if (isset($_POST['changePhone'])) {
        $newnophone = $_POST['newPhonenumber'];

        $connMyqli = getConnectionMysqli();
        $sqlUpdateNoPhone = "UPDATE tb_editor SET phone_number = '$newnophone' WHERE editor_id = $editorId ";
        mysqli_query($connMyqli,  $sqlUpdateNoPhone);
        mysqli_close($connMyqli);
    }
    if (isset($_POST['changeRole'])) {
        $newRole = $_POST['Newrole'];

        $connMyqli = getConnectionMysqli();
        $sqlUpdateNoPhone = "UPDATE tb_editor SET role_id = '$newRole' WHERE editor_id = $editorId ";
        mysqli_query($connMyqli,  $sqlUpdateNoPhone);
        mysqli_close($connMyqli);
    }
    if (isset($_POST['changeEmail'])) {
        $newEmail = $_POST['NewEmail'];

        $connMyqli = getConnectionMysqli();
        $sqlUpdateEmail = "UPDATE tb_editor SET email = '$newEmail' WHERE editor_id = $editorId ";
        mysqli_query($connMyqli,   $sqlUpdateEmail);
        mysqli_close($connMyqli);
    }
    if (isset($_POST['changePasswoard'])) {
        $password = $_POST['NewPasswoard'];

        $connMyqli = getConnectionMysqli();
        $newPassworUser = hashPassword($password);
        $sqlUpdatePassword = "UPDATE tb_editor SET password = $newPassworUser WHERE editor_id = $editorId ";
        mysqli_query($connMyqli,   $sqlUpdatePassword);
        mysqli_close($connMyqli);
    }
}



try {
    $conn = getConnection();
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT tb_editor.username, tb_editor.email, tb_editor.phone_number, tb_role.role_name FROM tb_editor INNER JOIN tb_role ON tb_editor.role_id = tb_role.role_id WHERE editor_id = :idEditor";
    $request = $conn->prepare($sql);
    $request->bindParam(':idEditor', $editorId);
    $request->execute();
    if ($result = $request->fetch()) {
        $name = $result['username'];
        $email = $result['email'];
        $NumberPhone = $result['phone_number'];
        $Role = $result['role_name'];
    }

    $conn = null;
} catch (PDOException $errorMessage) {
    $error = $errorMessage->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Nguliah.id - For Editor</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Nguliah.id - For Editor">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">
    <link rel="shortcut icon" href="favicon.ico">

    <!-- FontAwesome JS-->
    <script defer src="../assets/plugins/fontawesome/js/all.min.js"></script>

    <!-- App CSS -->
    <link id="theme-style" rel="stylesheet" href="../assets/scss/portal.css">

</head>

<body class="app">
    <header class="app-header fixed-top">
        <div class="app-header-inner">
            <div class="container-fluid py-2">
                <div class="app-header-content">
                    <div class="row justify-content-between align-items-center">

                        <div class="col-auto">
                            <a id="sidepanel-toggler" class="sidepanel-toggler d-inline-block d-xl-none" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" role="img">
                                    <title>Menu</title>
                                    <path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" d="M4 7h22M4 15h22M4 23h22"></path>
                                </svg>
                            </a>
                        </div>
                        <!--//col-->
                        <div class="search-mobile-trigger d-sm-none col">
                            <i class="search-mobile-trigger-icon fa-solid fa-magnifying-glass"></i>
                        </div>

                        <div class="app-utilities col-auto">
                            <div class="app-utility-item app-notifications-dropdown dropdown">
                                <div class="dropdown-menu p-0" aria-labelledby="notifications-dropdown-toggle">
                                    <!--//dropdown-menu-title-->

                                    <!--//dropdown-menu-content-->

                                </div>
                                <!--//dropdown-menu-->
                            </div>

                            <div class="app-utility-item app-user-dropdown dropdown">
                                <a class="dropdown-toggle" id="user-dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><?php echo $editorProfilePhoto ?></a>
                                <ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle">
                                    <li><a class="dropdown-item" href="accountEditor.php">Account</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="logoutEditor.php" id="logout">Log Out</a></li>
                                </ul>
                            </div>
                            <!--//app-user-dropdown-->
                        </div>
                        <!--//app-utilities-->
                    </div>
                    <!--//row-->
                </div>
                <!--//app-header-content-->
            </div>
            <!--//container-fluid-->
        </div>
        <!--//app-header-inner-->
        <div id="app-sidepanel" class="app-sidepanel">
            <div id="sidepanel-drop" class="sidepanel-drop"></div>
            <div class="sidepanel-inner d-flex flex-column">
                <a href="#" id="sidepanel-close" class="sidepanel-close d-xl-none">&times;</a>
                <div class="app-branding">
                    <a class="app-logo" href="indexEditor.php"><img class="logo-icon me-2" src="../assets/images//app-logo.png" alt="logo"><span class="logo-text">Nguliah.id</span></a>

                </div>
                <!--//app-branding-->

                <nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
                    <ul class="app-menu list-unstyled accordion" id="menu-accordion">
                        <li class="nav-item">
                            <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                            <a class="nav-link" href="indexEditor.php">
                                <span class="nav-icon">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-house-door" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M7.646 1.146a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 .146.354v7a.5.5 0 0 1-.5.5H9.5a.5.5 0 0 1-.5-.5v-4H7v4a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .146-.354l6-6zM2.5 7.707V14H6v-4a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v4h3.5V7.707L8 2.207l-5.5 5.5z" />
                                        <path fill-rule="evenodd" d="M13 2.5V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                                    </svg>
                                </span>
                                <span class="nav-link-text">Home</span>
                            </a>
                            <!--//nav-link-->
                        </li>
                        <!--//nav-item-->
                        <li class="nav-item">
                            <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                            <a class="nav-link" href="manageBlog.php">
                                <span class="nav-icon">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-card-list" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M14.5 3h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                                        <path fill-rule="evenodd" d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5z" />
                                        <circle cx="3.5" cy="5.5" r=".5" />
                                        <circle cx="3.5" cy="8" r=".5" />
                                        <circle cx="3.5" cy="10.5" r=".5" />
                                    </svg>
                                </span>
                                <span class="nav-link-text">News</span>
                            </a>
                            <!--//nav-link-->
                        </li>
                        <li class="nav-item">
                            <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                            <a class="nav-link" href="manageEvent.php">
                                <span class="nav-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar4-event" viewBox="0 0 16 16">
                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1H2zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V5z" />
                                        <path d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z" />
                                        <circle cx="3.5" cy="5.5" r=".5" />
                                        <circle cx="3.5" cy="8" r=".5" />
                                        <circle cx="3.5" cy="10.5" r=".5" />
                                    </svg>
                                </span>
                                <span class="nav-link-text">Event</span>
                            </a>
                            <!--//nav-link-->
                        </li>
                        <!--//nav-item-->
                        <li class="nav-item has-submenu">
                            <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                            <a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#submenu-2" aria-expanded="false" aria-controls="submenu-2">
                                <span class="nav-icon">
                                    <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-files" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4 2h7a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H4z" />
                                        <path d="M6 0h7a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2v-1a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H6a1 1 0 0 0-1 1H4a2 2 0 0 1 2-2z" />
                                    </svg>
                                </span>
                                <span class="nav-link-text">User</span>
                                <span class="submenu-arrow">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                    </svg>
                                </span>
                                <!--//submenu-arrow-->
                            </a>
                            <!--//nav-link-->
                            <div id="submenu-2" class="collapse submenu submenu-2" data-bs-parent="#menu-accordion">
                                <ul class="submenu-list list-unstyled">
                                    <li class="submenu-item"><a class="submenu-link active" href="accountEditor.php">Account</a></li>
                                </ul>
                            </div>
                        </li>
                        <!--//nav-item-->

                        <li class="nav-item">
                            <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                            <a class="nav-link" href="help.php">
                                <span class="nav-icon">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-question-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                        <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z" />
                                    </svg>
                                </span>
                                <span class="nav-link-text">Help</span>
                            </a>
                            <!--//nav-link-->
                        </li>
                        <!--//nav-item-->
                    </ul>
                    <!--//app-menu-->
                </nav>

            </div>
            <!--//sidepanel-inner-->
        </div>
        <!--//app-sidepanel-->
    </header>
    <!--//app-header-->

    <div class="app-wrapper">

        <div class="app-content pt-3 p-md-3 p-lg-4">
            <div class="container-xl">
                <h1 class="app-page-title">My Account</h1>
                <div class="row gy-4">
                    <div class="col-12 col-lg-6">
                        <div class="app-card app-card-account shadow-sm d-flex flex-column align-items-start">
                            <div class="app-card-header p-3 border-bottom-0">
                                <div class="row align-items-center gx-3">
                                    <div class="col-auto">
                                        <!--//icon-holder-->

                                    </div>
                                    <!--//col-->
                                    <!--//col-->
                                </div>
                                <!--//row-->
                            </div>
                            <!--//app-card-header-->
                            <div class="app-card-body px-4 w-100">
                                <div class="item border-bottom py-3">
                                    <div class="row justify-content-between align-items-center ">
                                        <div class="col-auto">
                                            <div class="item-label mb-2"><strong>Photo</strong></div>
                                            <div class="item-data mb-2">
                                                <?php
                                                echo $editorProfilePhoto;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="item-data">
                                            <a class="btn app-btn-secondary" data-toggle="modal" href="#change-photo">Change Profile Photo</a>
                                        </div>
                                        <!--//col-->
                                    </div>
                                    <!--//row-->
                                </div>
                                <div class="my-3"></div>

                                <!--//item-->
                                <div class="item border-bottom py-3">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-auto">
                                            <div class="item-label"><strong>Name</strong></div>
                                            <div class="item-data"><?= $name ?></div>
                                        </div>
                                        <!--//col-->
                                    </div>
                                    <!--//row-->
                                </div>
                                <div class="my-3"></div>
                                <div class="item-data">
                                    <a class="btn app-btn-secondary" data-toggle="modal" href="#change-name">Change name</a>
                                </div>

                                <!--//item-->
                                <div class="item border-bottom py-3">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-auto">
                                            <div class="item-label"><strong>Email</strong></div>
                                            <div class="item-data"><?= $email ?></div>
                                        </div>
                                        <!--//col-->
                                    </div>
                                    <!--//row-->
                                </div>
                                <div class="my-3"></div>
                                <div class="item-data">
                                    <a class="btn app-btn-secondary" data-toggle="modal" href="#change-email">Change email</a>
                                </div>
                                <!--//item-->
                                <!--//item-->
                                <div class="item border-bottom py-3">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-auto">
                                            <div class="item-label"><strong>Phone number</strong></div>
                                            <div class="item-data"><?= $NumberPhone ?></div>
                                        </div>
                                        <!--//col-->
                                    </div>
                                    <!--//row-->
                                </div>
                                <div class="my-3"></div>
                                <div class="item-data">
                                    <a class="btn app-btn-secondary" data-toggle="modal" href="#change-noPhone">Change Phone Number</a>
                                </div>
                                <!--//item-->
                                <div class="item border-bottom py-3">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-auto">
                                            <div class="item-label"><strong>Role</strong></div>
                                            <div class="item-data"><?= $Role ?></div>
                                        </div>

                                        <!--//col-->
                                    </div>
                                    <!--//row-->
                                </div>
                                <!--//item-->
                                <div class="my-3"></div>
                                <div class="item-data">
                                    <a class="btn app-btn-secondary" data-toggle="modal" href="#change-role">Change Role</a>
                                </div>
                                <!--//item-->
                                <div class="item py-3">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-auto">
                                            <div class="item-label"><strong>Password</strong></div>

                                        </div>

                                        <!--//col-->
                                    </div>
                                    <!--//row-->
                                </div>
                                <!--//item-->
                                <div class="item-data">
                                    <a class="btn app-btn-secondary mb-3" data-toggle="modal" href="#change-password">Change password</a>
                                </div>
                            </div>
                            <!--//app-card-body-->
                        </div>
                        <!--//app-card-->
                    </div>
                    <!--//col-->
                </div>
                <!--//container-fluid-->
                <!-- Modal -->
                <div class="modal fade" id="change-photo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Change My Profile Photo</h5>
                                <button type="button" class="close btn btn-outline-secondary btn-lg " data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" style="font-size: 1.5em;">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Choose your photo</p>
                                <form action="accountEditor.php" method="POST" id="" class="d-flex flex-row align-items-center justify-content-between" enctype="multipart/form-data">
                                    <input type="file" name="new-photo" id="new-photo" required>
                                    <input type="submit" id="submit" name="changePhotoButton" class="btn app-btn-primary" value="Change">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="change-name" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Change Name</h5>
                                <button type="button" class="close btn btn-outline-secondary btn-lg" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" style="font-size: 1.5em;">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Choose your Name</p>
                                <form action="accountEditor.php" method="POST" id="" class="d-flex flex-row align-items-center justify-content-between" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="insert new username" name='newusername' required>
                                    </div>
                                    <div class="form-group">

                                        <input type="submit" id="submit" name="changeName" class="btn app-btn-primary" value="Change">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="change-noPhone" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Change My no phone</h5>
                                <button type="button" class="close btn btn-outline-secondary btn-lg" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" style="font-size: 1.5em;">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Choose your phone</p>
                                <form action="accountEditor.php" method="POST" id="" class="d-flex flex-row align-items-center justify-content-between" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="New Phone number" name='newPhonenumber' required>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" id="submit" name="changePhone" class="btn app-btn-primary" value="Change">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="change-email" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Change My Email</h5>
                                <button type="button" class="close btn btn-outline-secondary btn-lg" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" style="font-size: 1.5em;">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Choose your email</p>
                                <form action="accountEditor.php" method="POST" id="" class="d-flex flex-row align-items-center justify-content-between" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="NewEmail" placeholder="insert new email" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" id="submit" name="changeEmail" class="btn app-btn-primary" value="Change">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="change-password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Change password</h5>
                                <button type="button" class="close btn btn-outline-secondary btn-lg" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" style="font-size: 1.5em;">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Choose your password </p>
                                <form action="accountEditor.php" method="POST" id="" class="d-flex flex-row align-items-center justify-content-between" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="NewPasswoard" placeholder="change your password" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" id="submit" name="changePasswoard" class="btn app-btn-primary" value="Change">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="change-role" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Change My role</h5>
                                <button type="button" class="close btn btn-outline-secondary btn-lg" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" style="font-size: 1.5em;">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Choose your role</p>
                                <form action="accountEditor.php" method="POST" id="" class="d-flex flex-row align-items-center justify-content-between" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <select class="form-select mb-3" name="Newrole">
                                            <option value="" disabled selected hidden>Pilih Role Anda</option>
                                            <?php
                                            $conn = getConnection();

                                            $sqlRole = "SELECT * from tb_role";

                                            $request = $conn->prepare($sqlRole);
                                            $request->execute();

                                            if ($result = $request->fetchAll()) {
                                                foreach ($result as $index) {
                                                    $roleId = $index['role_id'];
                                                    $roleName = $index['role_name'];
                                                    echo "<option value='$roleId'>$roleName</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                        <div class="form-group">
                                            <input type="submit" id="submit" name="changeRole" class="btn app-btn-primary" value="Change">
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--//app-content-->
        </div>
        <!--//app-wrapper-->


        <!-- Javascript -->
        <script src="../assets/plugins/popper.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>


        <!-- Page Specific JS -->
        <script src="../assets/js/app.js"></script>
</body>

</html>