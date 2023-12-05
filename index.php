<?php
require_once __DIR__ . "/helper/validateLogin.php";
require_once __DIR__ . "/helper/getConnectionMsqli.php";

$connection = getConnectionMysqli();
$idAdmin = $_SESSION['idAdmin'] ?? $_COOKIE['idAdmin'];
$sqlDetailProfile = "SELECT * FROM tb_admin where admin_id = $idAdmin";
$request = mysqli_query($connection, $sqlDetailProfile);

if ($result = mysqli_fetch_all($request)) {
	$username = $result[0][1];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Ngampus.id - For Admin</title>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<meta name="description" content="Ngampus.id - For Admin">
	<meta name="author" content="Xiaoying Riley at 3rd Wave Media">
	<link rel="shortcut icon" href="favicon-image.ico">

	<!-- FontAwesome JS-->
	<script defer src="assets/plugins/fontawesome/js/all.min.js"></script>

	<!-- App CSS -->
	<link id="theme-style" rel="stylesheet" href="assets/css/portal.css">
	<!-- <link id="theme-style" rel="stylesheet" href="assets/scss/portal.css"> -->

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
						<!--//col-->
						<div class="app-search-box col">
							<form class="app-search-form">
								<input type="text" placeholder="Search..." name="search" class="form-control search-input">
								<button type="submit" class="btn search-btn btn-primary" value="Search"><i class="fa-solid fa-magnifying-glass"></i></button>
							</form>
						</div>
						<!--//app-search-box-->

						<div class="app-utilities col-auto">
							<!--//app-utility-item-->
							<div class="app-utility-item">
								<a href="settings.php" title="Settings">
									<!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
									<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-gear icon" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" d="M8.837 1.626c-.246-.835-1.428-.835-1.674 0l-.094.319A1.873 1.873 0 0 1 4.377 3.06l-.292-.16c-.764-.415-1.6.42-1.184 1.185l.159.292a1.873 1.873 0 0 1-1.115 2.692l-.319.094c-.835.246-.835 1.428 0 1.674l.319.094a1.873 1.873 0 0 1 1.115 2.693l-.16.291c-.415.764.42 1.6 1.185 1.184l.292-.159a1.873 1.873 0 0 1 2.692 1.116l.094.318c.246.835 1.428.835 1.674 0l.094-.319a1.873 1.873 0 0 1 2.693-1.115l.291.16c.764.415 1.6-.42 1.184-1.185l-.159-.291a1.873 1.873 0 0 1 1.116-2.693l.318-.094c.835-.246.835-1.428 0-1.674l-.319-.094a1.873 1.873 0 0 1-1.115-2.692l.16-.292c.415-.764-.42-1.6-1.185-1.184l-.291.159A1.873 1.873 0 0 1 8.93 1.945l-.094-.319zm-2.633-.283c.527-1.79 3.065-1.79 3.592 0l.094.319a.873.873 0 0 0 1.255.52l.292-.16c1.64-.892 3.434.901 2.54 2.541l-.159.292a.873.873 0 0 0 .52 1.255l.319.094c1.79.527 1.79 3.065 0 3.592l-.319.094a.873.873 0 0 0-.52 1.255l.16.292c.893 1.64-.902 3.434-2.541 2.54l-.292-.159a.873.873 0 0 0-1.255.52l-.094.319c-.527 1.79-3.065 1.79-3.592 0l-.094-.319a.873.873 0 0 0-1.255-.52l-.292.16c-1.64.893-3.433-.902-2.54-2.541l.159-.292a.873.873 0 0 0-.52-1.255l-.319-.094c-1.79-.527-1.79-3.065 0-3.592l.319-.094a.873.873 0 0 0 .52-1.255l-.16-.292c-.892-1.64.902-3.433 2.541-2.54l.292.159a.873.873 0 0 0 1.255-.52l.094-.319z" />
										<path fill-rule="evenodd" d="M8 5.754a2.246 2.246 0 1 0 0 4.492 2.246 2.246 0 0 0 0-4.492zM4.754 8a3.246 3.246 0 1 1 6.492 0 3.246 3.246 0 0 1-6.492 0z" />
									</svg>
								</a>
							</div>
							<!--//app-utility-item-->

							<div class="app-utility-item app-user-dropdown dropdown">
								<a class="dropdown-toggle" id="user-dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><?= $profilePhoto ?></a>
								<ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle">
									<li><a class="dropdown-item" href="account.php">Account</a></li>
									<li><a class="dropdown-item" href="settings.php">Settings</a></li>
									<li>
										<hr class="dropdown-divider">
									</li>
									<li><a class="dropdown-item" href="logout.php" id="logout">Log Out</a></li>
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
					<a class="app-logo" href="index.php"><img class="logo-icon me-2" src="assets/images/app-logo.png" alt="logo"><span class="logo-text">Ngampus.id</span></a>

				</div>
				<!--//app-branding-->

				<nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
					<ul class="app-menu list-unstyled accordion" id="menu-accordion">
						<li class="nav-item">
							<!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
							<a class="nav-link active" href="index.php">
								<span class="nav-icon">
									<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-house-door" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" d="M7.646 1.146a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 .146.354v7a.5.5 0 0 1-.5.5H9.5a.5.5 0 0 1-.5-.5v-4H7v4a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .146-.354l6-6zM2.5 7.707V14H6v-4a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v4h3.5V7.707L8 2.207l-5.5 5.5z" />
										<path fill-rule="evenodd" d="M13 2.5V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
									</svg>
								</span>
								<span class="nav-link-text">Overview</span>
							</a>
							<!--//nav-link-->
						</li>
						<li class="nav-item has-submenu">
							<!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
							<a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#submenu-1" aria-expanded="false" aria-controls="submenu-1">
								<span class="nav-icon">
									<!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
									<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-files" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" d="M4 2h7a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H4z" />
										<path d="M6 0h7a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2v-1a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H6a1 1 0 0 0-1 1H4a2 2 0 0 1 2-2z" />
									</svg>
								</span>
								<span class="nav-link-text">Manage User</span>
								<span class="submenu-arrow">
									<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
									</svg>
								</span>
								<!--//submenu-arrow-->
							</a>
							<!--//nav-link-->
							<div id="submenu-1" class="collapse submenu submenu-1" data-bs-parent="#menu-accordion">
								<ul class="submenu-list list-unstyled">
									<li class="submenu-item"><a class="submenu-link" href="manageuser.php">Users Account</a></li>
									<li class="submenu-item"><a class="submenu-link" href="manageRoles.php">Users Roles</a></li>
								</ul>
							</div>
						</li>
						<!--//nav-item-->
						<li class="nav-item has-submenu">
							<!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
							<a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#submenu-2" aria-expanded="false" aria-controls="submenu-2">
								<span class="nav-icon">
									<!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
									<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-card-list" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" d="M14.5 3h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
										<path fill-rule="evenodd" d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5z" />
										<circle cx="3.5" cy="5.5" r=".5" />
										<circle cx="3.5" cy="8" r=".5" />
										<circle cx="3.5" cy="10.5" r=".5" />
									</svg>
								</span>
								<span class="nav-link-text">Manage News</span>
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
									<li class="submenu-item"><a class="submenu-link" href="manageBlog.php">Blog</a></li>
									<li class="submenu-item"><a class="submenu-link" href="managemedia.php">Media</a></li>
									<li class="submenu-item"><a class="submenu-link" href="manageCategory.php">News Category</a></li>
									<li class="submenu-item"><a class="submenu-link" href="manageAds.php">Ads</a></li>
									<li class="submenu-item"><a class="submenu-link" href="manageEvent.php">Event</a></li>
									<li class="submenu-item"><a class="submenu-link" href="manageJobVacancies.php">Job Vacancies</a></li>
								</ul>
							</div>
						</li>
					</ul>
					<!--//app-menu-->
				</nav>
				<!--//app-nav-->
				<div class="app-sidepanel-footer">
					<nav class="app-nav app-nav-footer">
						<ul class="app-menu footer-menu list-unstyled">
							<li class="nav-item">
								<!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
								<a class="nav-link" href="account.php">
									<span class="nav-icon">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
											<path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z" />
										</svg>
									</span>
									<span class="nav-link-text">Account</span>
								</a><!--//nav-link-->
							</li><!--//nav-item-->
							<li class="nav-item">
								<!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
								<a class="nav-link" href="settings.php">
									<span class="nav-icon">
										<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-gear" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd" d="M8.837 1.626c-.246-.835-1.428-.835-1.674 0l-.094.319A1.873 1.873 0 0 1 4.377 3.06l-.292-.16c-.764-.415-1.6.42-1.184 1.185l.159.292a1.873 1.873 0 0 1-1.115 2.692l-.319.094c-.835.246-.835 1.428 0 1.674l.319.094a1.873 1.873 0 0 1 1.115 2.693l-.16.291c-.415.764.42 1.6 1.185 1.184l.292-.159a1.873 1.873 0 0 1 2.692 1.116l.094.318c.246.835 1.428.835 1.674 0l.094-.319a1.873 1.873 0 0 1 2.693-1.115l.291.16c.764.415 1.6-.42 1.184-1.185l-.159-.291a1.873 1.873 0 0 1 1.116-2.693l.318-.094c.835-.246.835-1.428 0-1.674l-.319-.094a1.873 1.873 0 0 1-1.115-2.692l.16-.292c.415-.764-.42-1.6-1.185-1.184l-.291.159A1.873 1.873 0 0 1 8.93 1.945l-.094-.319zm-2.633-.283c.527-1.79 3.065-1.79 3.592 0l.094.319a.873.873 0 0 0 1.255.52l.292-.16c1.64-.892 3.434.901 2.54 2.541l-.159.292a.873.873 0 0 0 .52 1.255l.319.094c1.79.527 1.79 3.065 0 3.592l-.319.094a.873.873 0 0 0-.52 1.255l.16.292c.893 1.64-.902 3.434-2.541 2.54l-.292-.159a.873.873 0 0 0-1.255.52l-.094.319c-.527 1.79-3.065 1.79-3.592 0l-.094-.319a.873.873 0 0 0-1.255-.52l-.292.16c-1.64.893-3.433-.902-2.54-2.541l.159-.292a.873.873 0 0 0-.52-1.255l-.319-.094c-1.79-.527-1.79-3.065 0-3.592l.319-.094a.873.873 0 0 0 .52-1.255l-.16-.292c-.892-1.64.902-3.433 2.541-2.54l.292.159a.873.873 0 0 0 1.255-.52l.094-.319z" />
											<path fill-rule="evenodd" d="M8 5.754a2.246 2.246 0 1 0 0 4.492 2.246 2.246 0 0 0 0-4.492zM4.754 8a3.246 3.246 0 1 1 6.492 0 3.246 3.246 0 0 1-6.492 0z" />
										</svg>
									</span>
									<span class="nav-link-text">Settings</span>
								</a>
								<!--//nav-link-->
							</li>
							<!--//nav-item-->
						</ul>
						<!--//footer-menu-->
					</nav>
				</div>
				<!--//app-sidepanel-footer-->

			</div>
			<!--//sidepanel-inner-->
		</div>
		<!--//app-sidepanel-->
	</header>
	<!--//app-header-->

	<div class="app-wrapper">
		<div class="app-content pt-3 p-md-3 p-lg-4">
			<div class="container-xl">
				<div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">
					<div class="inner">
						<div class="app-card-body p-3 p-lg-4">
							<h3 class="mb-3">Welcome, <strong><?php echo $username; ?></strong>!</h3>
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>

					</div>
				</div>

				<!-- Post -->
				<div class="row g-4 mb-4">

					<!-- Media -->
					<div class="col-6 col-lg-3">
						<div class="app-card app-card-stat shadow-sm h-100">
							<div class="app-card-body p-3 p-lg-4">
								<h4 class="stats-type mb-1">Media</h4>
								<div class="stats-figure">
									<?php
									$conn = getConnectionMysqli();

									$sql = "SELECT * FROM tb_media";

									// Execute the query
									$result = mysqli_query($conn, $sql);

									// Check for query execution success
									if ($result) {
										echo mysqli_num_rows($result);

										// Free result set
										mysqli_free_result($result);
									} else {
										// Handle query execution failure
										echo "Error executing the query: " . mysqli_error($conn);
									}

									// Close the database connection
									mysqli_close($conn);
									?>
								</div>
							</div>
							<a class="app-card-link-mask" href="#"></a>
						</div>
					</div>

					<!-- Event -->
					<div class="col-6 col-lg-3">
						<div class="app-card app-card-stat shadow-sm h-100">
							<div class="app-card-body p-3 p-lg-4">
								<h4 class="stats-type mb-1">Event</h4>
								<div class="stats-figure">
									<?php
									$conn = getConnectionMysqli();

									$sql = "SELECT * FROM tb_event";

									// Execute the query
									$result = mysqli_query($conn, $sql);

									// Check for query execution success
									if ($result) {
										echo mysqli_num_rows($result);

										// Free result set
										mysqli_free_result($result);
									} else {
										// Handle query execution failure
										echo "Error executing the query: " . mysqli_error($conn);
									}

									// Close the database connection
									mysqli_close($conn);
									?>
								</div>
							</div>
							<a class="app-card-link-mask" href="#"></a>
						</div>
					</div>

					<!-- Job Vacancy -->
					<div class="col-6 col-lg-3">
						<div class="app-card app-card-stat shadow-sm h-100">
							<div class="app-card-body p-3 p-lg-4">
								<h4 class="stats-type mb-1">Job Vacancy</h4>
								<div class="stats-figure">
									<?php
									$conn = getConnectionMysqli();

									$sql = "SELECT * FROM tb_job_vacancies";

									// Execute the query
									$result = mysqli_query($conn, $sql);

									// Check for query execution success
									if ($result) {
										echo mysqli_num_rows($result);

										// Free result set
										mysqli_free_result($result);
									} else {
										// Handle query execution failure
										echo "Error executing the query: " . mysqli_error($conn);
									}

									// Close the database connection
									mysqli_close($conn);
									?>
								</div>
							</div>
							<a class="app-card-link-mask" href="#"></a>
						</div>
					</div>

					<!-- Blog -->
					<div class="col-6 col-lg-3">
						<div class="app-card app-card-stat shadow-sm h-100">
							<div class="app-card-body p-3 p-lg-4">
								<h4 class="stats-type mb-1">Blog</h4>
								<div class="stats-figure">
									<?php
									$conn = getConnectionMysqli();

									$sql = "SELECT * FROM tb_blog";

									// Execute the query
									$result = mysqli_query($conn, $sql);

									// Check for query execution success
									if ($result) {
										echo mysqli_num_rows($result);

										// Free result set
										mysqli_free_result($result);
									} else {
										// Handle query execution failure
										echo "Error executing the query: " . mysqli_error($conn);
									}

									// Close the database connection
									mysqli_close($conn);
									?>
								</div>
							</div>
							<a class="app-card-link-mask" href="#"></a>
						</div>
					</div>
				</div>

				<!-- Users -->
				<div class="row g-4 mb-4">

					<!-- Admin -->
					<div class="col-12 col-lg-4">
						<div class="app-card app-card-basic d-flex flex-column align-items-start shadow-sm">
							<div class="app-card-header p-3 border-bottom-0">
								<div class="row align-items-center gx-3">
									<div class="col-auto">
										<div class="app-icon-holder">
											<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-receipt" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
												<path fill-rule="evenodd" d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27zm.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0l-.509-.51z" />
												<path fill-rule="evenodd" d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z" />
											</svg>
										</div>

									</div>
									<div class="col-auto">
										<h4 class="app-card-title">Admin</h4>
									</div>
								</div>
							</div>
							<div class="app-card-body px-4">
								<div class="intro">
									Amount of Admin account: <?php
																$conn = getConnectionMysqli();

																$sql = "SELECT * FROM tb_admin";

																// Execute the query
																$result = mysqli_query($conn, $sql);

																// Check for query execution success
																if ($result) {
																	echo mysqli_num_rows($result);

																	// Free result set
																	mysqli_free_result($result);
																} else {
																	// Handle query execution failure
																	echo "Error executing the query: " . mysqli_error($conn);
																}

																// Close the database connection
																mysqli_close($conn);
																?>
								</div>
							</div>
							<div class="app-card-footer p-4 mt-auto">
								<a class="btn app-btn-secondary" href="#">Create New Admin Account</a>
							</div>
						</div>
					</div>

					<!-- Editor -->
					<div class="col-12 col-lg-4">
						<div class="app-card app-card-basic d-flex flex-column align-items-start shadow-sm">
							<div class="app-card-header p-3 border-bottom-0">
								<div class="row align-items-center gx-3">
									<div class="col-auto">
										<div class="app-icon-holder">
											<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-code-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
												<path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
												<path fill-rule="evenodd" d="M6.854 4.646a.5.5 0 0 1 0 .708L4.207 8l2.647 2.646a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 0 1 .708 0zm2.292 0a.5.5 0 0 0 0 .708L11.793 8l-2.647 2.646a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708 0z" />
											</svg>
										</div>

									</div>
									<div class="col-auto">
										<h4 class="app-card-title">Editor</h4>
									</div>
								</div>
							</div>
							<div class="app-card-body px-4">
								<div class="intro">
									Amount of Editor account: <?php
																$conn = getConnectionMysqli();

																$sql = "SELECT * FROM tb_editor";

																// Execute the query
																$result = mysqli_query($conn, $sql);

																// Check for query execution success
																if ($result) {
																	echo mysqli_num_rows($result);

																	// Free result set
																	mysqli_free_result($result);
																} else {
																	// Handle query execution failure
																	echo "Error executing the query: " . mysqli_error($conn);
																}

																// Close the database connection
																mysqli_close($conn);
																?>
								</div>
							</div>
							<div class="app-card-footer p-4 mt-auto">
								<a class="btn app-btn-secondary" href="#">Create New Editor Account</a>
							</div>
						</div>
					</div>
				</div>

				<!-- Tags & Category -->
				<div class="row g-4 mb-4">
					<div class="col-12 col-lg-6">
						<div class="app-card app-card-stats-table h-100 shadow-sm">
							<div class="app-card-body p-3 p-lg-4">
								<div class="table-responsive">
									<table class="table table-borderless mb-0">
										<thead>
											<tr>
												<th class="meta">Tag</th>
												<th class="meta stat-cell">Popularity</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$conn = getConnectionMysqli();

											$sql = "SELECT tag_name, popularity FROM tb_tag ORDER BY popularity DESC";

											// Execute the query
											$result = mysqli_query($conn, $sql);

											// Check for query execution success
											if ($result) {
												// Fetch data and display in the HTML table
												while ($row = mysqli_fetch_assoc($result)) {
													echo "<tr>";
													echo "<td><a href='#'>{$row['tag_name']}</a></td>";
													echo "<td class='stat-cell'>{$row['popularity']}</td>";
													echo "</tr>";
												}

												// Free result set
												mysqli_free_result($result);
											} else {
												// Handle query execution failure
												echo "Error executing the query: " . mysqli_error($conn);
											}

											// Close the database connection
											mysqli_close($conn);
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-6">
						<div class="app-card app-card-stats-table h-100 shadow-sm">
							<div class="app-card-body p-3 p-lg-4">
								<div class="table-responsive">
									<table class="table table-borderless mb-0">
										<thead>
											<tr>
												<th class="meta">Category</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$conn = getConnectionMysqli();

											$sql = "SELECT category_name FROM tb_category_blog";

											// Execute the query
											$result = mysqli_query($conn, $sql);

											// Check for query execution success
											if ($result) {
												// Fetch data and display in the HTML table
												while ($row = mysqli_fetch_assoc($result)) {
													echo "<tr>";
													echo "<td><a href='#'>{$row['category_name']}</a></td>";
													echo "</tr>";
												}

												// Free result set
												mysqli_free_result($result);
											} else {
												// Handle query execution failure
												echo "Error executing the query: " . mysqli_error($conn);
											}

											// Close the database connection
											mysqli_close($conn);
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<footer class="app-footer">
			<div class="container text-center py-3">
				<!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
				<small class="copyright">Designed with <span class="sr-only">love</span><i class="fas fa-heart" style="color: #fb866a;"></i> by <a class="app-link" href="http://themes.3rdwavemedia.com" target="_blank">Xiaoying Riley</a> for developers</small>

			</div>
		</footer>
		<!--//app-footer-->

	</div>
	<!--//app-wrapper-->


	<!-- Javascript -->
	<script src="assets/plugins/popper.min.js"></script>
	<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

	<!-- Charts JS -->
	<script src="assets/plugins/chart.js/chart.min.js"></script>
	<script src="assets/js/index-charts.js"></script>

	<!-- Page Specific JS -->
	<script src="assets/js/app.js"></script>
</body>

</html>