<?php
require_once __DIR__ . "/../helper/hash.php";
require_once __DIR__ . "/../helper/getConnection.php";
require_once __DIR__ . "/../helper/getConnectionMsqli.php";
require_once __DIR__ . "/../helper/jobfunctions.php";
require_once __DIR__ . '/../helper/validateLoginEditor.php';

// Get connections
$conn = getConnectionMysqli();
$dbConnection = getConnection();

// Fetching data from the tb_tag table
$query = $dbConnection->query("SELECT * FROM tb_tag");
$tags = $query->fetchAll(PDO::FETCH_ASSOC);

// Fetching data from the tb_category table
$query = $dbConnection->query("SELECT * FROM tb_category_job_vacancy");
$categories = $query->fetchAll(PDO::FETCH_ASSOC);

// Post Detection
if ($_SERVER['REQUEST_METHOD'] == "POST") {

	// Script Create New Job
	if (isset($_POST['createJob'])) {
		$vacancy_id = generateIdJobVacancies();
		$createTitle = $_POST['createTitle'];
		$content = $_POST['createContent'];
		if ($_POST['createRequirement']) {
			$requirement = $_POST['createRequirement'];
		} else {
			$requirement = "";
		}
		$currentDate = date("Y-m-d");
		if ($_POST['createVideoUrl']) {
			$videoCreateUrl = $_POST['createVideoUrl'];
		} else {
			$videoCreateUrl = "";
		}
		$tagId = $_POST['taginput'];
		$categoryId = $_POST['catinput'];
		$logoName = random_int(0, PHP_INT_MAX) . date("dmYHis") . $vacancy_id;
		$hashedLogo = hashPhotoProfile($logoName);
		$imageName = random_int(0, PHP_INT_MAX) . date("dmYHis") . $vacancy_id;
		$hashedImage = hashPhotoProfile($imageName);
		$createCompany = $_POST['createCompany'];

		$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sqlCreate = "INSERT INTO tb_job_vacancies (vacancy_id, vacancy_title, vacancy_content, vacancy_requirement, date_release, image_url, video_url, views, tag_id, category_id, editor_id, logo, company_name)
				VALUES (:vacancy_id, :createTitle, :content, :requirements, :currentDate, :image_url, :video_url, 0, :tagId, :categoryId, :editorId, :companyLogo, :company)";
		$request = $dbConnection->prepare($sqlCreate);

		$request->bindParam('vacancy_id', $vacancy_id);
		$request->bindParam('createTitle', $createTitle);
		$request->bindParam('content', $content);
		$request->bindParam('requirements', $requirement);
		$request->bindParam('currentDate', $currentDate);
		$request->bindParam('image_url', $hashedImage);
		$request->bindParam('video_url', $videoCreateUrl);
		$request->bindParam('tagId', $tagId);
		$request->bindParam('categoryId', $categoryId);
		$request->bindParam('editorId', $editorId);
		$request->bindParam('companyLogo', $hashedLogo);
		$request->bindParam('company', $createCompany);
		$request->execute();

		$success = uploadImageJob($logoName, $_FILES['companyLogo']);
		$success = uploadImageJob($imageName, $_FILES['createImageUrl']);
		if ($success) {
			echo '<script>alert("Data berhasil ditambahkan!");</script>';
		} else {
			echo '<script>alert("Data gagal ditambahkan!");</script>';
		}
		header("Location:managejob.php");
	}

	// Script Delete Job
	if (isset($_POST['deleteButton'])) {
		$vacancy_id = $_POST['vacancy_id'];
		$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$fetchLogoName = $dbConnection->prepare("SELECT logo FROM tb_job_vacancies WHERE vacancy_id = :vacancy_id");
		$fetchLogoName->bindParam('vacancy_id', $vacancy_id);
		$fetchLogoName->execute();
		$result = $fetchLogoName->fetch(PDO::FETCH_ASSOC);

		if ($result) {
			$companyLogoName = $result['logo'];
			deleteImageJob($companyLogoName);
		} else {
			echo '<script>alert("Tidak ada Logo!");</script>';
		}

		$sqlDelete = "DELETE FROM tb_job_vacancies WHERE vacancy_id = ?";
		$requestDelete = mysqli_prepare($conn, $sqlDelete);

		mysqli_stmt_bind_param($requestDelete, "s", $vacancy_id);
		mysqli_stmt_execute($requestDelete);
		mysqli_stmt_close($requestDelete);
	}
}

if (isset($_GET['search-job'])) {
	$searchJob = $_GET['searchorders'];
	$sql = "SELECT * FROM tb_job_vacancies WHERE vacancy_title LIKE '%$searchJob%'";
} else {
	$sql = "SELECT * FROM tb_job_vacancies";
}

// Setting Job Datasets
$jobs = mysqli_query($conn, $sql);

if ($jobs) {
	$jobArray = [];
	while ($job = mysqli_fetch_assoc($jobs)) {
		$jobArray[] = $job;
	}
} else {
	echo "Error executing the query: " . mysqli_error($conn);
}

// Closing connections;
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>CRUD Job</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Portal - Bootstrap 5 Admin Dashboard Template For Developers">
	<meta name="author" content="Xiaoying Riley at 3rd Wave Job">
	<link rel="shortcut icon" href="favicon.ico">

	<!-- Script -->
	<script defer src="../assets/plugins/fontawesome/js/all.min.js"></script>

	<!-- CSS -->
	<link id="theme-style" rel="stylesheet" href="../assets/css/portal.css">
	<link id="theme-style" rel="stylesheet" href="../assets\scss\portal.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet" />

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://cdn.tiny.cloud/1/nzng1kbb69fr6bk6p4r9k59igb52we1skltelld77fektcxi/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>


	<script>
		tinymce.init({
			selector: 'textarea#editor',
			paste_as_text: true,
			font_formats: 'Roboto=Roboto',
			content_style: "@import url('https://fonts.googleapis.com/css2?family=Lato:wght@900&family=Roboto&display=swap'); body { font-family: 'Roboto', sans-serif; } h1,h2,h3,h4,h5,h6 { font-family: 'Lato', sans-serif; }",
		});
	</script>

	<script>
		tinymce.init({
			selector: 'textarea#editor',
			plugins: 'lists, link',
			toolbar: 'h1 h2 bold italic strikethrough blockquote bullist numlist backcolor | link | removeformat help',
			menubar: false,
			setup: (editor) => {
				// Apply the focus effect
				editor.on("init", () => {
					editor.getContainer().style.transition = "border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out";
				});
				editor.on("focus", () => {
					(editor.getContainer().style.boxShadow = "0 0 0 .2rem rgba(0, 123, 255, .25)"),
					(editor.getContainer().style.borderColor = "#80bdff");
				});
				editor.on("blur", () => {
					(editor.getContainer().style.boxShadow = ""),
					(editor.getContainer().style.borderColor = "");
				});
			},
		});
	</script>

	<script>
		document.getElementById('myForm').addEventListener('submit', function(event) {
			const content = tinyMCE.get('editor').getContent();

			if (!content.trim()) { // Check if content is empty or contains only whitespace
				event.preventDefault(); // Prevent form submission
				alert('Content is required'); // Display an alert or handle validation error
			}
		});
	</script>
</head>

<body class="app">
	<div class="app-wrapper">
		<div class="app-content pt-3 p-md-3 p-lg-4">
			<div class="container-xl">
				<div class="row g-3 mb-4 align-items-center justify-content-between">
					<div class="col-auto">
						<h1 class="app-page-title mb-0">Job</h1>
					</div>
					<div class="col-auto">
						<div class="page-utilities">
							<div class="row g-2 justify-content-start justify-content-md-end align-items-center">
								<div class="col-auto">
									<form class="table-search-form row gx-1 align-items-center" action="managejob.php" method="GET">
										<div class="col-auto">
											<input type="text" id="search-orders" name="searchorders" class="form-control search-orders" placeholder="Search">
										</div>
										<div class="col-auto">
											<button type="submit" class="btn app-btn-secondary" name="search-job">Search</button>
										</div>
									</form>
								</div>
								<div class="col-auto">
									<select class="form-select w-auto">
										<option selected value="option-1">All</option>
										<option value="option-2">This week</option>
										<option value="option-3">This month</option>
										<option value="option-4">Last 3 months</option>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="tab-content" id="orders-table-tab-content">
					<div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
						<div class="app-card app-card-orders-table shadow-sm mb-5">
							<div class="app-card-body">
								<div class="table-responsive">
									<table class="table app-table-hover mb-0 text-center">
										<thead>
											<tr>
												<th class="cell">Title</th>
												<th class="cell">Content</th>
												<th class="cell">Requirement</th>
												<th class="cell">Company</th>
												<th class="cell">Views</th>
												<th class="cell">Views</th>
												<th class="cell">Category</th>
												<th class="cell">Tag</th>
												<th class="cell">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ($jobArray as $job) {
												$vacancy_id = $job['vacancy_id'];
												$tagname = getTagNameFromId($job['tag_id']);
												$categname = getCategoryJobNameFromId($job['category_id']);
												$companyLogoimg = getImageJob(decryptPhotoProfile($job['logo']), 80);
												echo <<<TULIS
														<tr>
															<td class="cell"><strong>{$job['vacancy_title']}</strong></td>
															<td class="cell">{$job['vacancy_content']}</td>
															<td class="cell">{$job['vacancy_requirement']}</td>
															<td class="cell">{$companyLogoimg}<br><h3>{$job['company_name']}</h3></td>
															<td class="cell">{$job['date_release']}</td>
															<td class="cell">{$job['views']}</td>
															<td class="cell">{$categname}</td>
															<td class="cell">{$tagname}</td>
															<td class="cell">
																<a class="btn btn-light" data-toggle="modal" href="#view-job-{$job['vacancy_id']}">View</a>
																<a class="btn btn-secondary" data-toggle="modal" href="#update-job-{$job['vacancy_id']}">Edit</a>
																<a class="btn btn-danger" data-toggle="modal" href="#delete-job" onclick="getDeleteJobId('$vacancy_id')">Delete</a>
															</td>
														</tr>
													TULIS;
											}
											?>
											<tr>
												<td>-</td>
												<td>-</td>
												<td>-</td>
												<td>-</td>
												<td>-</td>
												<td>-</td>
												<td>-</td>
												<td>-</td>
												<td>
													<button type="button" data-bs-toggle="modal" data-bs-target="#createnew" class="btn btn-primary align-items-center">Create New Job</button>
												</td>
											</tr>
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
				<small class="copyright">Designed with <span class="sr-only">love</span><i class="fas fa-heart" style="color: #fb866a;"></i> by <a class="app-link" href="http://themes.3rdwavejob.com" target="_blank">Xiaoying Riley</a> for developers</small>
			</div>
		</footer>
	</div>

	<!-- Create New Job Modal Pop Up -->
	<form action="" method="POST" id="createJob" enctype="multipart/form-data">
		<div class="modal fade" id="createnew" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createnew" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h3>New Job</h3>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="row d-flex justify-content-center align-items-center">
							<div class="card-body p-4">
								<div class="form-outline mb-4">
									<label class="form-label">Judul Job</label>
									<input type="text" name="createTitle" class="form-control form-control-lg" required>
								</div>
								<div class="form-outline mb-4">
									<label class="form-label">Content Job</label>
									<div class="form-group">
										<textarea id="editor" name="createContent"></textarea>
									</div>
								</div>
								<div class="form-outline mb-4">
									<label class="form-label">Requirement Job</label>
									<div class="form-group">
										<textarea id="editor" name="createRequirement"></textarea>
									</div>
								</div>
								<div class="form-outline mb-4">
									<label class="form-label">Thumbnail</label>
									<input type="file" name="createImageUrl" class="form-control form-control-lg">
								</div>
								<div class="form-outline mb-4">
									<label class="form-label">Url Video</label>
									<input type="text" name="createVideoUrl" class="form-control form-control-lg">
								</div>
								<div class="form-outline mb-4">
									<label class="form-label">Tag</label>
									<select name="taginput" id="taginput" class="form-control">
										<?php foreach ($tags as $tag) { ?>
											<option value="<?php echo $tag['tag_id']; ?>"><?php echo $tag['tag_name']; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-outline mb-4">
									<label class="form-label">Categories</label>
									<select name="catinput" id="catinput" class="form-control">
										<?php foreach ($categories as $categ) { ?>
											<option value="<?php echo $categ['category_id']; ?>"><?php echo $categ['category_name']; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-outline mb-4">
									<label class="form-label">Logo</label>
									<br>
									<input type="file" name="companyLogo" required>
								</div>
								<div class="form-outline mb-4">
									<label class="form-label">Company</label>
									<input type="text" name="createCompany" class="form-control form-control-lg">
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary" name="createJob">Publish</button>
					</div>
				</div>
			</div>
		</div>
	</form>

	<!-- View Job Modal Pop Up -->
	<?php foreach ($jobArray as $job) {
		$tagname = getTagNameFromId($job['tag_id']);
		$categname = getCategoryJobNameFromId($job['category_id']);
		$formattedDate = dateFormatter($job['date_release']);
		$companyLogoimg = getImageJob(decryptPhotoProfile($job['logo']), 200);
		if ($job['image_url'] != "") {
			$imageurl = "<div class='form-outline mb-4'><h3>Image</h3><p><a href='{$job['image_url']}' target='_blank'><img src='{$job['image_url']}' alt='Image'></a></div>";
		} else {
			$imageurl = "";
		}
		if ($job['video_url'] != "") {
			$videourl = "<div class='form-outline mb-4'><h3>Image</h3><p><a href='{$job['video_url']}' target='_blank'>Video</a></div>";
		} else {
			$videourl = "";
		}
		echo <<<TULIS
			<div class="modal fade" id="view-job-{$job['vacancy_id']}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h3>View Job</h3>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row d-flex justify-content-center align-items-center">
								<div class="card-body p-4">
									<div class="form-outline mb-4">
										<h3>Job ID</h3>
										<p>{$job['vacancy_id']}</p>
									</div>
									<div class="form-outline mb-4">
										<h3>Title</h3>
										<p>{$job['vacancy_title']}</p>
									</div>
									<div class="form-outline mb-4">
										<h3>Content</h3>
										<p>{$job['vacancy_content']}</p>
									</div>
									<div class="form-outline mb-4">
										<h3>Requirements</h3>
										<p>{$job['vacancy_requirement']}</p>
									</div>
									<div class="form-outline mb-4">
										<h3>Date Release</h3>
										<p>{$formattedDate}</p>
									</div>
									{$imageurl}
									{$videourl}
									<div class="form-outline mb-4">
										<h3>Views</h3>
										<p>{$job['views']}</p>
									</div>
									<div class="form-outline mb-4">
										<h3>Tag</h3>
										<p>{$tagname}</p>
									</div>
									<div class="form-outline mb-4">
										<h3>Category</h3>
										<p>{$categname}</p>
									</div>
									<div class="form-outline mb-4">
										<h3>Company Logo</h3>
										{$companyLogoimg}
									</div>
									<div class="form-outline mb-4">
										<h3>Company Name</h3>
										<p>{$job['company_name']}</p>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>

		TULIS;
	} ?>

	<!-- Delete Job Modal Pop Up -->
	<div class="modal fade" id="delete-job" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Deletion Confirmation</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Are you sure you want to delete this job?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn app-btn-secondary" data-dismiss="modal">Close</button>
					<form action="" method="POST" id="formDeleteJob">
						<input type="submit" id="submit" name="deleteButton" class="btn app-btn-confirmation" value="Yes">
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Scripts -->
	<script src="../assets/plugins/popper.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="../assets/js/app.js"></script>
	<script>
		function getDeleteJobId(vacancy_id) {
			console.log(vacancy_id)
			const formDelete = document.getElementById("formDeleteJob");
			const deleteInput = document.createElement("input");

			deleteInput.setAttribute("type", "hidden");
			deleteInput.setAttribute("name", "vacancy_id");
			deleteInput.setAttribute("value", vacancy_id);

			formDelete.appendChild(deleteInput);
		}
	</script>
</body>

</html>