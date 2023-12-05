<?php
require_once __DIR__ . "/helper/getConnection.php";
require_once __DIR__ . "/helper/validateLogin.php";
require_once __DIR__ . "/helper/getConnectionMsqli.php";

$conn = getConnectionMysqli();

if (isset($_GET['deleteButton'])) {
	$eventId = $_GET['eventId'];

	$sqlDelete = "DELETE FROM tb_event WHERE event_id = ?";
	$requestDelete = mysqli_prepare($conn, $sqlDelete);

	mysqli_stmt_bind_param($requestDelete, "s", $eventId);
	mysqli_stmt_execute($requestDelete);
	mysqli_stmt_close($requestDelete);
	mysqli_close($conn);

	header("Location:manageEvent.php");
	exit;
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
						</div><!--//col-->
						<div class="search-mobile-trigger d-sm-none col">
							<i class="search-mobile-trigger-icon fa-solid fa-magnifying-glass"></i>
						</div><!--//col-->
						<div class="app-search-box col">
							<form class="app-search-form">
								<input type="text" placeholder="Search..." name="search" class="form-control search-input">
								<button type="submit" class="btn search-btn btn-primary" value="Search"><i class="fa-solid fa-magnifying-glass"></i></button>
							</form>
						</div><!--//app-search-box-->

						<div class="app-utilities col-auto">
							<div class="app-utility-item">
								<a href="settings.php" title="Settings">
									<!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
									<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-gear icon" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" d="M8.837 1.626c-.246-.835-1.428-.835-1.674 0l-.094.319A1.873 1.873 0 0 1 4.377 3.06l-.292-.16c-.764-.415-1.6.42-1.184 1.185l.159.292a1.873 1.873 0 0 1-1.115 2.692l-.319.094c-.835.246-.835 1.428 0 1.674l.319.094a1.873 1.873 0 0 1 1.115 2.693l-.16.291c-.415.764.42 1.6 1.185 1.184l.292-.159a1.873 1.873 0 0 1 2.692 1.116l.094.318c.246.835 1.428.835 1.674 0l.094-.319a1.873 1.873 0 0 1 2.693-1.115l.291.16c.764.415 1.6-.42 1.184-1.185l-.159-.291a1.873 1.873 0 0 1 1.116-2.693l.318-.094c.835-.246.835-1.428 0-1.674l-.319-.094a1.873 1.873 0 0 1-1.115-2.692l.16-.292c.415-.764-.42-1.6-1.185-1.184l-.291.159A1.873 1.873 0 0 1 8.93 1.945l-.094-.319zm-2.633-.283c.527-1.79 3.065-1.79 3.592 0l.094.319a.873.873 0 0 0 1.255.52l.292-.16c1.64-.892 3.434.901 2.54 2.541l-.159.292a.873.873 0 0 0 .52 1.255l.319.094c1.79.527 1.79 3.065 0 3.592l-.319.094a.873.873 0 0 0-.52 1.255l.16.292c.893 1.64-.902 3.434-2.541 2.54l-.292-.159a.873.873 0 0 0-1.255.52l-.094.319c-.527 1.79-3.065 1.79-3.592 0l-.094-.319a.873.873 0 0 0-1.255-.52l-.292.16c-1.64.893-3.433-.902-2.54-2.541l.159-.292a.873.873 0 0 0-.52-1.255l-.319-.094c-1.79-.527-1.79-3.065 0-3.592l.319-.094a.873.873 0 0 0 .52-1.255l-.16-.292c-.892-1.64.902-3.433 2.541-2.54l.292.159a.873.873 0 0 0 1.255-.52l.094-.319z" />
										<path fill-rule="evenodd" d="M8 5.754a2.246 2.246 0 1 0 0 4.492 2.246 2.246 0 0 0 0-4.492zM4.754 8a3.246 3.246 0 1 1 6.492 0 3.246 3.246 0 0 1-6.492 0z" />
									</svg>
								</a>
							</div><!--//app-utility-item-->

							<div class="app-utility-item app-user-dropdown dropdown">
								<a class="dropdown-toggle" id="user-dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><?= $profilePhoto ?></a>
								<ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle">
									<li><a class="dropdown-item" href="account.php">Account</a></li>
									<li><a class="dropdown-item" href="settings.php">Settings</a></li>
									<li>
										<hr class="dropdown-divider">
									</li>
									<li><a class="dropdown-item" href="logout.php">Log Out</a></li>
								</ul>
							</div><!--//app-user-dropdown-->
						</div><!--//app-utilities-->
					</div><!--//row-->
				</div><!--//app-header-content-->
			</div><!--//container-fluid-->
		</div><!--//app-header-inner-->
		<div id="app-sidepanel" class="app-sidepanel sidepanel-hidden">
			<div id="sidepanel-drop" class="sidepanel-drop"></div>
			<div class="sidepanel-inner d-flex flex-column">
				<a href="#" id="sidepanel-close" class="sidepanel-close d-xl-none">&times;</a>
				<div class="app-branding">
					<a class="app-logo" href="index.php"><img class="logo-icon me-2" src="assets/images/app-logo.png" alt="logo"><span class="logo-text">Ngampus.id</span></a>

				</div><!--//app-branding-->
				<nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
					<ul class="app-menu list-unstyled accordion" id="menu-accordion">
						<nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
							<ul class="app-menu list-unstyled accordion" id="menu-accordion">
								<li class="nav-item">
									<!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
									<a class="nav-link" href="index.php">
										<span class="nav-icon">
											<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-house-door" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
												<path fill-rule="evenodd" d="M7.646 1.146a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 .146.354v7a.5.5 0 0 1-.5.5H9.5a.5.5 0 0 1-.5-.5v-4H7v4a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .146-.354l6-6zM2.5 7.707V14H6v-4a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v4h3.5V7.707L8 2.207l-5.5 5.5z" />
												<path fill-rule="evenodd" d="M13 2.5V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
											</svg>
										</span>
										<span class="nav-link-text">Overview</span>
									</a><!--//nav-link-->
								</li><!--//nav-item-->
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
									<div id="submenu-2" class="collapse submenu submenu-2 show" data-bs-parent="#menu-accordion">
										<ul class="submenu-list list-unstyled">
											<li class="submenu-item"><a class="submenu-link" href="manageBlog.php">Blog</a></li>
											<li class="submenu-item"><a class="submenu-link" href="managemedia.php">Media</a></li>
											<li class="submenu-item"><a class="submenu-link" href="manageCategory.php">News Category</a></li>
											<li class="submenu-item"><a class="submenu-link" href="manageAds.php">Ads</a></li>
											<li class="submenu-item"><a class="submenu-link active" href="manageEvent.php">Event</a></li>
											<li class="submenu-item"><a class="submenu-link" href="manageJobVacancies.php">Job Vacancies</a></li>
										</ul>
									</div>
								</li>
							</ul><!--//app-menu-->
						</nav><!--//app-nav-->
					</ul><!--//app-menu-->
				</nav><!--//app-nav-->
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
								</a><!--//nav-link-->
							</li><!--//nav-item-->
						</ul><!--//footer-menu-->
					</nav>
				</div><!--//app-sidepanel-footer-->
			</div><!--//sidepanel-inner-->
		</div><!--//app-sidepanel-->
	</header><!--//app-header-->

	<div class="app-wrapper">

		<div class="app-content pt-3 p-md-3 p-lg-4">
			<div class="container-xl">

				<div class="row g-3 mb-4 align-items-center justify-content-between">
					<div class="col-auto">
						<h1 class="app-page-title mb-0">Event</h1>
					</div>

					<div class="col-auto">
						<div class="page-utilities">
							<div class="row g-2 justify-content-start justify-content-md-end align-items-center">
								<div class="col-auto">
									<form class="table-search-form row gx-1 align-items-center" action="news.php" method="GET">
										<div class="col-auto">
											<input type="text" id="search-orders" name="searchorders" class="form-control search-orders" placeholder="Search">
										</div>
										<div class="col-auto">
											<button type="submit" class="btn app-btn-secondary" name="search-news">Search</button>
										</div>
									</form>

								</div><!--//col-->
								<div class="col-auto">

									<select class="form-select w-auto">
										<option selected value="option-1">All</option>
										<option value="option-2">This week</option>
										<option value="option-3">This month</option>
										<option value="option-4">Last 3 months</option>

									</select>
								</div>
							</div><!--//row-->
						</div><!--//table-utilities-->
					</div><!--//col-auto-->
				</div><!--//row-->

				<div class="tab-content" id="orders-table-tab-content">
					<div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
						<div class="app-card app-card-orders-table shadow-sm mb-5">
							<div class="app-card-body">
								<div class="table-responsive">
									<table class="table app-table-hover mb-0 text-left">
										<thead>
											<tr>
												<th class="cell">Event ID</th>
												<th class="cell">Title</th>
												<th class="cell">Category</th>
												<th class="cell">Date Release</th>
												<th class="cell">Tag</th>
												<th class="cell">Publisher</th>
												<th class="cell"></th>
												<th class="cell"></th>
											</tr>
										</thead>
										<tbody>
											<?php
											$conn = getConnectionMysqli();
											if (isset($_GET['search-news'])) {
												$searchNews = $_GET['searchorders'];
												$sql = "SELECT tb_event.event_id, tb_event.event_title, tb_category_event.category_name, tb_event.date_release, tb_editor.username FROM ((tb_event INNER JOIN tb_category_event ON tb_event.category_id = tb_category_event.category_id) INNER JOIN tb_editor ON tb_event.editor_id = tb_editor.editor_id) WHERE tb_event.event_title LIKE '%$searchNews%'";
											} else {
												$sql = "SELECT tb_event.event_id, tb_event.event_title, tb_category_event.category_name, tb_event.date_release, tb_editor.username FROM ((tb_event INNER JOIN tb_category_event ON tb_event.category_id = tb_category_event.category_id) INNER JOIN tb_editor ON tb_event.editor_id = tb_editor.editor_id)";
											}

											$request = mysqli_query($conn, $sql);

											if (mysqli_num_rows($request) > 0) {
												foreach ($result = mysqli_fetch_all($request) as $index) {
													$eventId = $index[0];
													$eventTitle = $index[1];
													$category = $index[2];
													$dateRelease = $index[3];
													$publisher = $index[4];


													echo <<<TULIS
                                                                <tr>
                                                                    <td class="cell">$eventId</td>
                                                                    <td class="cell"><span class="truncate">$eventTitle</span></td>
                                                                    <td class="cell">$category</td>
                                                                    <td class="cell"><span>$dateRelease</span><span class="note">2:16 PM</span></td>
                                                                    <td class="cell"><span class="badge bg-success">Paid</span></td>
                                                                    <td class="cell">$publisher</td>
                                                                    <td class="cell">
                                                                        <a class="btn-sm app-btn-secondary" href="#">View</a>
                                                                    </td>
                                                                    <td class="cell">

                                                                        <a class="btn-sm app-btn-danger" data-toggle="modal" href="#exampleModal" onclick="getEventId('$eventId')">Delete</a>
                                                                    </td>
                                                                </tr>
                                                            TULIS;
												}
											}

											mysqli_close($conn);
											?>



										</tbody>
									</table>
								</div><!--//table-responsive-->

							</div><!--//app-card-body-->
						</div><!--//app-card-->

						<nav class="app-pagination">
							<ul class="pagination justify-content-center">
								<li class="page-item disabled">
									<a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
								</li>
								<li class="page-item active"><a class="page-link" href="#">1</a></li>
								<li class="page-item"><a class="page-link" href="#">2</a></li>
								<li class="page-item"><a class="page-link" href="#">3</a></li>
								<li class="page-item">
									<a class="page-link" href="#">Next</a>
								</li>
							</ul>
						</nav><!--//app-pagination-->
					</div><!--//tab-pane-->
				</div><!--//tab-content-->

				<!-- Modal -->


				<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<p>Apakah anda yakin ingin menghapus berita ini?</p>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn app-btn-secondary" data-dismiss="modal">Close</button>
								<form action="manageEvent.php" method="GET" id="conDeleteEvent">
									<input href="$hapus" id="submit" type="submit" name="deleteButton" class="btn app-btn-confirmation" value="Ya, Saya yakin"></input>
								</form>
							</div>
						</div>
					</div>
				</div>




			</div><!--//container-fluid-->
		</div><!--//app-content-->

		<footer class="app-footer">
			<div class="container text-center py-3">
				<!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
				<small class="copyright">Designed with <span class="sr-only">love</span><i class="fas fa-heart" style="color: #fb866a;"></i> by <a class="app-link" href="http://themes.3rdwavemedia.com" target="_blank">Xiaoying Riley</a> for developers</small>

			</div>
		</footer><!--//app-footer-->

	</div><!--//app-wrapper-->


	<!-- Javascript -->
	<script src="assets/plugins/popper.min.js"></script>
	<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<script>
		function getEventId(eventId) {
			console.log(eventId);
			const formDelete = document.getElementById("conDeleteEvent");
			const createInput = document.createElement("input");

			createInput.setAttribute("type", "hidden");
			createInput.setAttribute("name", "eventId");
			createInput.setAttribute("value", eventId);

			formDelete.appendChild(createInput);
		}
	</script>


	<!-- Page Specific JS -->
	<script src="assets/js/app.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>