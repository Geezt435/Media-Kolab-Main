<?php
require_once __DIR__ . "/../helper/validateLoginEditor.php";
require_once "../helper/getConnection.php";
require_once "../helper/validateLoginEditor.php";
require_once "../helper/getConnectionMsqli.php";
require_once "../helper/cloudinary.php";
require_once "../helper/hash.php";
require "../vendor/autoload.php";

try {
	$conn = getConnection();
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// MEDIA
	$sql = "SELECT date_release, COUNT(*) as count_per_date FROM tb_media GROUP BY date_release ORDER BY date_release DESC";

	$stmt = $conn->prepare($sql);
	$stmt->execute();

	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$medialabels = [];
	$mediacounts = [];

	foreach ($data as $row) {
		$medialabels[] = $row['date_release'];
		$mediacounts[] = $row['count_per_date'];
	}

	// EVENT
	$sql = "SELECT date_release, COUNT(*) as count_per_date FROM tb_event GROUP BY date_release ORDER BY date_release DESC";

	$stmt = $conn->prepare($sql);
	$stmt->execute();

	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$eventlabels = [];
	$eventcounts = [];

	foreach ($data as $row) {
		$eventlabels[] = $row['date_release'];
		$eventcounts[] = $row['count_per_date'];
	}

	// JOB VACANCY
	$sql = "SELECT date_release, COUNT(*) as count_per_date FROM tb_job_vacancies GROUP BY date_release ORDER BY date_release DESC";

	$stmt = $conn->prepare($sql);
	$stmt->execute();

	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$jobVacancylabels = [];
	$jobVacancycounts = [];

	foreach ($data as $row) {
		$jobVacancylabels[] = $row['date_release'];
		$jobVacancycounts[] = $row['count_per_date'];
	}

	// BLOG
	$sql = "SELECT date_release, COUNT(*) as count_per_date FROM tb_blog GROUP BY date_release ORDER BY date_release DESC";

	$stmt = $conn->prepare($sql);
	$stmt->execute();

	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$bloglabels = [];
	$blogcounts = [];

	foreach ($data as $row) {
		$bloglabels[] = $row['date_release'];
		$blogcounts[] = $row['count_per_date'];
	}

	$conn = null;
} catch (PDOException $e) {
	echo "Connection failed: " . $e->getMessage();
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['NewTag'])) {
		$newTag = $_POST['NewTag'];

		// Connect to the database
		$connMyqli = getConnectionMysqli();

		// Prepare the SQL query
		$sqlInsertTag = "INSERT INTO tb_tag (tag_name) VALUES (?)";
		$stmt = mysqli_prepare($connMyqli, $sqlInsertTag);

		// Bind parameters to the prepared statement
		mysqli_stmt_bind_param($stmt, "s", $newTag);

		// Execute the prepared statement
		mysqli_stmt_execute($stmt);

		// Close the database connection
		mysqli_close($connMyqli);
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Nguliah.id - For Editor</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Media KoLab">
	<meta name="author" content="Dekorin">

	<!-- Include necessary libraries -->
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

	<!-- Favicon -->
	<link rel="shortcut icon" href="favicon.ico">
	<script defer src="../assets/plugins/fontawesome/js/all.min.js"></script>

	<!-- CSS -->
	<link id="theme-style" rel="stylesheet" href="../assets/css/portal.css">

	<!-- Custom Script -->
	<script>
		var ctx = document.getElementById('mediaChart').getContext('2d');

		var chartData = {
			labels: <?php echo json_encode($medialabels); ?>,
			datasets: [{
				label: 'Media Released',
				data: <?php echo json_encode($mediacounts); ?>,
				backgroundColor: 'rgba(54, 162, 235, 0.5)',
				borderColor: 'rgba(54, 162, 235, 1)',
				borderWidth: 1
			}]
		};

		var myChart = new Chart(ctx, {
			type: 'bar',
			data: chartData,
			options: {
				scales: {
					y: {
						beginAtZero: true
					}
				}
			}
		});
	</script>
	<script>
		var ctx = document.getElementById('eventChart').getContext('2d');

		var chartData = {
			labels: <?php echo json_encode($eventlabels); ?>,
			datasets: [{
				label: 'Event Released',
				data: <?php echo json_encode($eventcounts); ?>,
				backgroundColor: 'rgba(54, 162, 235, 0.5)',
				borderColor: 'rgba(54, 162, 235, 1)',
				borderWidth: 1
			}]
		};

		var myChart = new Chart(ctx, {
			type: 'bar',
			data: chartData,
			options: {
				scales: {
					y: {
						beginAtZero: true
					}
				}
			}
		});
	</script>
	<script>
		var ctx = document.getElementById('jobVacancyChart').getContext('2d');

		var chartData = {
			labels: <?php echo json_encode($jobVacancylabels); ?>,
			datasets: [{
				label: 'Job Vacancy Released',
				data: <?php echo json_encode($jobVacancycounts); ?>,
				backgroundColor: 'rgba(54, 162, 235, 0.5)',
				borderColor: 'rgba(54, 162, 235, 1)',
				borderWidth: 1
			}]
		};

		var myChart = new Chart(ctx, {
			type: 'bar',
			data: chartData,
			options: {
				scales: {
					y: {
						beginAtZero: true
					}
				}
			}
		});
	</script>
	<script>
		var ctx = document.getElementById('blogChart').getContext('2d');

		var chartData = {
			labels: <?php echo json_encode($bloglabels); ?>,
			datasets: [{
				label: 'Blog Released',
				data: <?php echo json_encode($blogcounts); ?>,
				backgroundColor: 'rgba(54, 162, 235, 0.5)',
				borderColor: 'rgba(54, 162, 235, 1)',
				borderWidth: 1
			}]
		};

		var myChart = new Chart(ctx, {
			type: 'bar',
			data: chartData,
			options: {
				scales: {
					y: {
						beginAtZero: true
					}
				}
			}
		});
	</script>

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
							<a class="nav-link active" href="indexEditor.php">
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
									<li class="submenu-item"><a class="submenu-link" href="accountEditor.php">Account</a></li>
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
				<div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">
					<div class="inner">
						<div class="app-card-body p-3 p-lg-4">
							<h3 class="mb-3">Welcome, <strong><?php echo $name; ?></strong>!</h3>
							<div class="row gx-5 gy-3">
								<p>Your current account role is <strong><?php echo $Role; ?></strong>!</p>
							</div>
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
								<h4 class="stats-type mb-1">Media Created</h4>
								<div class="stats-figure">
									<?php
									$conn = getConnectionMysqli();

									$sql = "SELECT * FROM tb_media WHERE editor_id = '$editorId'";

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
								<h4 class="stats-type mb-1">Event Created</h4>
								<div class="stats-figure">
									<?php
									$conn = getConnectionMysqli();

									$sql = "SELECT * FROM tb_event WHERE editor_id = '$editorId'";

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
								<h4 class="stats-type mb-1">Job Vacancy Created</h4>
								<div class="stats-figure">
									<?php
									$conn = getConnectionMysqli();

									$sql = "SELECT * FROM tb_job_vacancies WHERE editor_id = '$editorId'";

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
								<h4 class="stats-type mb-1">Blog Created</h4>
								<div class="stats-figure">
									<?php
									$conn = getConnectionMysqli();

									$sql = "SELECT * FROM tb_blog WHERE editor_id = '$editorId'";

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

				<!-- Statistic -->
				<div class="row g-4 mb-4">

					<!-- Media -->
					<div class="col-12 col-lg-6">
						<div class="app-card app-card-chart h-100 shadow-sm">
							<div class="app-card-header p-3">
								<div class="row justify-content-between align-items-center">
									<div class="col-auto">
										<h4 class="app-card-title">Media</h4>
									</div>
									<div class="col-auto">
										<div class="card-header-action">
											<div class="mb-3 d-flex">
												<select class="form-select form-select-sm ms-auto d-inline-flex w-auto">
													<option value="1" selected>This week</option>
													<option value="2">Today</option>
													<option value="3">This Month</option>
													<option value="3">This Year</option>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="app-card-body p-3 p-lg-4">
								<div class="chart-container">
									<canvas id="mediaChart"></canvas>
								</div>
							</div>
							<div class="app-card-footer p-4 mt-auto">
								<a class="btn app-btn-primary" href="#">Create New Media</a>
							</div>
						</div>
					</div>

					<!-- tag -->
					<div class="col-12 col-lg-6">
						<div class="app-card app-card-chart h-100 shadow-sm">
							<div class="app-card-header p-3">
								<div class="row justify-content-between align-items-center">
									<div class="col-auto">
										<h4 class="app-card-title">Tag</h4>
									</div>
									<div class="col-auto">
										<div class="card-header-action">
											<div class="mb-3 d-flex">
												<select class="form-select form-select-sm ms-auto d-inline-flex w-auto">
													<option value="1" selected>This week</option>
													<option value="2">Today</option>
													<option value="3">This Month</option>
													<option value="3">This Year</option>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="app-card-body p-3 p-lg-4">
								<div class="chart-container">
									<canvas id="mediaChart"></canvas>
								</div>
							</div>
							<div class="app-card-footer p-4 mt-auto">
								<button type="button" class="btn app-btn-primary" data-bs-toggle="modal" data-bs-target="#new-tag">
									Create New tag
								</button>

							</div>
						</div>
					</div>

					<!-- Event -->
					<div class="col-12 col-lg-6">
						<div class="app-card app-card-chart h-100 shadow-sm">
							<div class="app-card-header p-3">
								<div class="row justify-content-between align-items-center">
									<div class="col-auto">
										<h4 class="app-card-title">Event</h4>
									</div>
									<div class="col-auto">
										<div class="card-header-action">
											<div class="mb-3 d-flex">
												<select class="form-select form-select-sm ms-auto d-inline-flex w-auto">
													<option value="1" selected>This week</option>
													<option value="2">Today</option>
													<option value="3">This Month</option>
													<option value="3">This Year</option>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="app-card-body p-3 p-lg-4">
								<div class="chart-container">
									<canvas id="eventChart"></canvas>
								</div>
							</div>
							<div class="app-card-footer p-4 mt-auto">
								<a class="btn app-btn-primary" href="#">Create New Event</a>
							</div>
						</div>
					</div>

					<!-- Job Vacancies -->
					<div class="col-12 col-lg-6">
						<div class="app-card app-card-chart h-100 shadow-sm">
							<div class="app-card-header p-3">
								<div class="row justify-content-between align-items-center">
									<div class="col-auto">
										<h4 class="app-card-title">Job Vacancies</h4>
									</div>
									<div class="col-auto">
										<div class="card-header-action">
											<div class="mb-3 d-flex">
												<select class="form-select form-select-sm ms-auto d-inline-flex w-auto">
													<option value="1" selected>This week</option>
													<option value="2">Today</option>
													<option value="3">This Month</option>
													<option value="3">This Year</option>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="app-card-body p-3 p-lg-4">
								<div class="chart-container">
									<canvas id="jobVacancyChart"></canvas>
								</div>
							</div>
							<div class="app-card-footer p-4 mt-auto">
								<a class="btn app-btn-primary" href="#">Create New Job Vacancy</a>
							</div>
						</div>
					</div>

					<!-- Blog -->
					<div class="col-12 col-lg-6">
						<div class="app-card app-card-chart h-100 shadow-sm">
							<div class="app-card-header p-3">
								<div class="row justify-content-between align-items-center">
									<div class="col-auto">
										<h4 class="app-card-title">Blog</h4>
									</div>
									<div class="col-auto">
										<div class="card-header-action">
											<div class="mb-3 d-flex">
												<select class="form-select form-select-sm ms-auto d-inline-flex w-auto">
													<option value="1" selected>This week</option>
													<option value="2">Today</option>
													<option value="3">This Month</option>
													<option value="3">This Year</option>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="app-card-body p-3 p-lg-4">
								<div class="chart-container">
									<canvas id="blogChart"></canvas>
								</div>
							</div>
							<div class="app-card-footer p-4 mt-auto">
								<a class="btn app-btn-primary" href="#">Create New Blog</a>
							</div>
						</div>
					</div>
				</div>

				<!-- Tags & Category -->
				<div class="row g-4 mb-4">

					<!-- Tags -->
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

					<!-- Blog Category -->
					<div class="col-12 col-lg-6">
						<div class="app-card app-card-stats-table h-100 shadow-sm">
							<div class="app-card-body p-3 p-lg-4">
								<div class="table-responsive">
									<table class="table table-borderless mb-0">
										<thead>
											<tr>
												<th class="meta">Blog Categories</th>
												<th class="meta stat-cell">Popularity</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$conn = getConnectionMysqli();

											$sql = "SELECT category_name, popularity FROM tb_category_blog LIMIT 5";

											// Execute the query
											$result = mysqli_query($conn, $sql);

											// Check for query execution success
											if ($result) {
												// Fetch data and display in the HTML table
												while ($row = mysqli_fetch_assoc($result)) {
													echo "<tr>";
													echo "<td><a href='#'>{$row['category_name']}</a></td>";
													echo "<td><a href='#'>{$row['popularity']}</a></td>";
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

					<!-- Media Category -->
					<div class="col-12 col-lg-6">
						<div class="app-card app-card-stats-table h-100 shadow-sm">
							<div class="app-card-body p-3 p-lg-4">
								<div class="table-responsive">
									<table class="table table-borderless mb-0">
										<thead>
											<tr>
												<th class="meta">Media Categories</th>
												<th class="meta stat-cell">Popularity</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$conn = getConnectionMysqli();

											$sql = "SELECT category_name, popularity FROM tb_category_media LIMIT 5";

											// Execute the query
											$result = mysqli_query($conn, $sql);

											// Check for query execution success
											if ($result) {
												// Fetch data and display in the HTML table
												while ($row = mysqli_fetch_assoc($result)) {
													echo "<tr>";
													echo "<td><a href='#'>{$row['category_name']}</a></td>";
													echo "<td><a href='#'>{$row['popularity']}</a></td>";
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

					<!-- Event Category -->
					<div class="col-12 col-lg-6">
						<div class="app-card app-card-stats-table h-100 shadow-sm">
							<div class="app-card-body p-3 p-lg-4">
								<div class="table-responsive">
									<table class="table table-borderless mb-0">
										<thead>
											<tr>
												<th class="meta">Event Categories</th>
												<th class="meta stat-cell">Popularity</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$conn = getConnectionMysqli();

											$sql = "SELECT category_name, popularity FROM tb_category_event LIMIT 5";

											// Execute the query
											$result = mysqli_query($conn, $sql);

											// Check for query execution success
											if ($result) {
												// Fetch data and display in the HTML table
												while ($row = mysqli_fetch_assoc($result)) {
													echo "<tr>";
													echo "<td><a href='#'>{$row['category_name']}</a></td>";
													echo "<td><a href='#'>{$row['popularity']}</a></td>";
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

					<!-- Job Vacancies Category -->
					<div class="col-12 col-lg-6">
						<div class="app-card app-card-stats-table h-100 shadow-sm">
							<div class="app-card-body p-3 p-lg-4">
								<div class="table-responsive">
									<table class="table table-borderless mb-0">
										<thead>
											<tr>
												<th class="meta">Job Vacancies Categories</th>
												<th class="meta stat-cell">Popularity</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$conn = getConnectionMysqli();

											$sql = "SELECT category_name, popularity FROM tb_category_job_vacancy LIMIT 5";

											// Execute the query
											$result = mysqli_query($conn, $sql);

											// Check for query execution success
											if ($result) {
												// Fetch data and display in the HTML table
												while ($row = mysqli_fetch_assoc($result)) {
													echo "<tr>";
													echo "<td><a href='#'>{$row['category_name']}</a></td>";
													echo "<td><a href='#'>{$row['popularity']}</a></td>";
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
		<!-- <div class="modal fade" id="new-tag" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
											<input type="text" class="form-control" name="NewPasswoard" placeholder="change your password" required>
											</div>
											<div class="form-group">
											<input type="submit" id="submit" name="changePasswoard" class="btn app-btn-primary" value="Change">
									</div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

				<div class="modal fade" id="new-tag" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Masukan tag</h5>
							</div>
							<div class="modal-body">
								<p>tag</p>
								<form action="accountEditor.php" method="POST" id=""  enctype="multipart/form-data">
									<div class="form-group">
										<textarea class="form-control" rows="4" name = "NewTag" placeholder="Masukan Tag baru"></textarea>
									</div>
								</form>
							</div>
							<div class="modal-footer">
								<div class="form-group">
									<input type="submit" id="submit" name="NewTag" class="btn app-btn-primary" value="input">
								</div>
							</div>
						</div>
					</div>
				</div> -->




		<!-- Footer -->
		<footer class="app-footer">
			<div class="container text-center py-3">
				<strong class="copyright">
					Dekorin &copy 2023 - <?php echo (date("Y") + 1); ?>
				</strong>
			</div>
		</footer>
	</div>
	<!--//app-wrapper-->
	<!-- Javascript -->
	<script src="../assets/plugins/popper.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>


	<!-- Page Specific JS -->
	<script src="../assets/js/app.js"></script>

	<!-- Javascript -->
	<script src="../assets/plugins/popper.min.js"></script>
	<script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>

	<!-- Charts JS -->
	<script src="../assets/plugins/chart.js/chart.min.js"></script>
	<script src="../assets/js/index-charts.js"></script>

	<!-- Page Specific JS -->
	<script src="../assets/js/app.js"></script>

	<!-- Scripts -->
	<script src="../assets/plugins/popper.min.js"></script>
	<script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="../assets/plugins/chart.js/chart.min.js"></script>
	<script src="../assets/js/index-charts.js"></script>
	<script src="../assets/js/app.js"></script>
</body>

</html>