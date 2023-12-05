<?php
require_once __DIR__ . '/../helper/getConnection.php';
require_once __DIR__ . '/../helper/getConnectionMsqli.php';
require_once __DIR__ . '/../helper/validateLoginEditor.php';

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

	// ACCOUNT DATA
	$sql = "SELECT tb_editor.username, tb_role.role_name FROM tb_editor INNER JOIN tb_role ON tb_editor.role_id = tb_editor.role_id WHERE tb_editor.editor_id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(1, $editorId);
	$stmt->execute();

	$accountData = $stmt->fetch(PDO::FETCH_ASSOC);

	$conn = null;
} catch (PDOException $e) {
	echo "Connection failed: " . $e->getMessage();
}
?>

<html lang="En">

<head>
	<title>Editor Dashboard</title>
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
	<div class="app-wrapper">
		<div class="app-content pt-3 p-md-3 p-lg-4">
			<div class="container-xl">
				<div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">
					<div class="inner">
						<div class="app-card-body p-3 p-lg-4">
							<h3 class="mb-3">Welcome, <strong><?php echo $accountData['username']; ?></strong>!</h3>
							<div class="row gx-5 gy-3">
								<p>Your current account role is <strong><?php echo $accountData['role_name']; ?></strong>!</p>
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

		<!-- Footer -->
		<footer class="app-footer">
			<div class="container text-center py-3">
				<strong class="copyright">
					Dekorin &copy 2023 - <?php echo (date("Y") + 1); ?>
				</strong>
			</div>
		</footer>
	</div>

	<!-- Scripts -->
	<script src="../assets/plugins/popper.min.js"></script>
	<script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="../assets/plugins/chart.js/chart.min.js"></script>
	<script src="../assets/js/index-charts.js"></script>
	<script src="../assets/js/app.js"></script>
</body>

</html>