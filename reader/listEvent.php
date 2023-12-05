<?php
include('../helper/getConnectionMsqli.php');
require_once __DIR__ . '/../helper/cloudinary.php';
require_once __DIR__ . '/../helper/hash.php';

$conn = getConnectionMysqli();

$getCategory = isset($_GET['category']) ? $_GET['category'] : null;

if (is_null($getCategory)) {
	$query = "SELECT tb_event.event_id, tb_event.event_title, tb_event.date_release, tb_event.image_url, tb_editor.username, tb_category_event.category_name FROM tb_event INNER JOIN tb_editor ON tb_event.editor_id = tb_editor.editor_id INNER JOIN  tb_category_event ON tb_category_event.category_id = tb_event.category_id";
} else {
	$query = "SELECT tb_event.event_id, tb_event.event_title, tb_event.date_release, tb_event.image_url, tb_editor.username, tb_category_event.category_name FROM tb_event INNER JOIN tb_editor ON tb_event.editor_id = tb_editor.editor_id INNER JOIN  tb_category_event ON tb_category_event.category_id = tb_event.category_id WHERE tb_category_event.category_name = '$getCategory'";
}

$data = mysqli_query($conn, $query);
$result = mysqli_fetch_all($data);
$query2 = "SELECT tb_event.category_id, tb_category_event.category_name, COUNT(tb_event.category_id) AS jumlah_kategori FROM tb_category_event INNER JOIN tb_event ON tb_category_event.category_id = tb_event.category_id GROUP BY tb_event.category_id";
$query3 = "SELECT COUNT(event_id) AS jumlah_event FROM tb_event";
$data2 = mysqli_query($conn, $query2);
$result2 = mysqli_fetch_all($data2);
$data3 = mysqli_query($conn, $query3);
$result3 = mysqli_fetch_array($data3);

$query4 = "SELECT event_id, event_title, date_release, views, image_url FROM tb_event ORDER BY views desc limit 3";
$data4 = mysqli_query($conn, $query4);
$result4 = mysqli_fetch_all($data4);
?>

<!DOCTYPE html>
<html lang="en-US">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Nguliah.id - Media Campus</title>
	<meta name="description" content="Nguliah.id - Media Campus">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">

	<!-- STYLES -->
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" media="all">
	<link rel="stylesheet" href="css/all.min.css" type="text/css" media="all">
	<link rel="stylesheet" href="css/slick.css" type="text/css" media="all">
	<link rel="stylesheet" href="css/simple-line-icons.css" type="text/css" media="all">
	<link rel="stylesheet" href="css/style.css?v=2" type="text/css" media="all">

	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

	<!-- preloader -->
	<div id="preloader">
		<div class="book">
			<div class="inner">
				<div class="left"></div>
				<div class="middle"></div>
				<div class="right"></div>
			</div>
			<ul>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
			</ul>
		</div>
	</div>

	<!-- site wrapper -->
	<div class="site-wrapper">

		<div class="main-overlay"></div>

		<!-- header -->
		<header class="header-personal">
			<div class="container-xl header-top">
				<div class="row align-items-center">

					<div class="col-4 d-none d-md-block d-lg-block">
						<!-- social icons -->
						<ul class="social-icons list-unstyled list-inline mb-0">
							<li class="list-inline-item"><a href="#"><i class="fab fa-instagram"></i></a></li>
							<li class="list-inline-item"><a href="#"><i class="fab fa-youtube"></i></a></li>
						</ul>
					</div>

					<div class="col-md-4 col-sm-12 col-xs-12 text-center">
						<!-- site logo -->
						<a class="navbar-brand" href="index.php"><img src="images/logo-text.png" height="30" alt="logo" /></a>
					</div>

					<div class="col-md-4 col-sm-12 col-xs-12">
						<!-- header buttons -->
						<div class="header-buttons float-md-end mt-4 mt-md-0">
							<button class="search icon-button">
								<i class="icon-magnifier"></i>
							</button>
							<button class="burger-menu icon-button ms-2 float-end float-md-none">
								<span class="burger-icon"></span>
							</button>
						</div>
					</div>

				</div>
			</div>

			<nav class="navbar navbar-expand-lg">
				<div class="container-xl">

					<div class="collapse navbar-collapse justify-content-center centered-nav">
						<!-- menus -->
						<ul class="navbar-nav">
							<li class="nav-item">
								<a class="nav-link" href="index.php">Home</a>
							</li>
							<li class="nav-item active">
								<a class="nav-link" href="listEvent.php">Event</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="listBlog.php">Blog</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="listMedia.php">Media</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="listJobVacancies.php">Loker/Magang</a>
							</li>
						</ul>
					</div>

				</div>
			</nav>
		</header>

		<section class="page-header">
			<div class="container-xl">
				<div class="text-center">
					<h1 class="mt-0 mb-2">Event</h1>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb justify-content-center mb-0">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active" aria-current="page">Event</li>
						</ol>
					</nav>
				</div>
			</div>
		</section>

		<!-- section main content -->
		<section class="main-content">
			<div class="container-xl">

				<div class="row gy-4">

					<div class="col-lg-8">

						<div class="row gy-4">
							<?php
							if (mysqli_num_rows($data) > 0) {
								foreach ($result as $isi) {
									$eventId = $isi[0];
									$eventTitle = $isi[1];
									$dateRelease = $isi[2];
									$image = getImageNews(decryptPhotoProfile($isi[3]));
									$editorUsername = $isi[4];
									$categoryName = $isi[5];

									echo <<<BERITA
										<div class="col-sm-6">
											<!-- post -->
											<div class="post post-grid rounded bordered">
												<div class="thumb top-rounded">
													<a href="category.html" class="category-badge position-absolute">$categoryName</a>
													<a href="detailEvent.php?eventId=$eventId">
														<div class="inner">
															$image
														</div>
													</a>
												</div>
												<div class="details">
													<ul class="meta list-inline mb-0">
														<li class="list-inline-item"><a href="#">$editorUsername</a></li>
														<li class="list-inline-item">$dateRelease</li>
													</ul>
													<h5 class="post-title mb-3 mt-3"><a href="detailEvent.php?eventId=$eventId">$eventTitle</a></h5>
												</div>
												<div class="post-bottom clearfix d-flex align-items-center">
													<div class="social-share me-auto">
														<button class="toggle-button icon-share"></button>
														<ul class="icons list-unstyled list-inline mb-0">
															<li class="list-inline-item"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
															<li class="list-inline-item"><a href="#"><i class="fab fa-twitter"></i></a></li>
															<li class="list-inline-item"><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
															<li class="list-inline-item"><a href="#"><i class="fab fa-pinterest"></i></a></li>
															<li class="list-inline-item"><a href="#"><i class="fab fa-telegram-plane"></i></a></li>
															<li class="list-inline-item"><a href="#"><i class="far fa-envelope"></i></a></li>
														</ul>
													</div>
													<div class="more-button float-end">
														<a href="detailEvent.php?eventId=$eventId"><span class="icon-options"></span></a>
													</div>
												</div>
											</div>
										</div>
									BERITA;
								}
							} ?>

						</div>

						<nav>
							<ul class="pagination justify-content-center">
								<li class="page-item active" aria-current="page">
									<span class="page-link">1</span>
								</li>
								<li class="page-item"><a class="page-link" href="#">2</a></li>
								<li class="page-item"><a class="page-link" href="#">3</a></li>
							</ul>
						</nav>

					</div>
					<div class="col-lg-4">

						<!-- sidebar -->
						<div class="sidebar">
							<!-- widget about -->


							<!-- widget popular posts -->
							<div class="widget rounded">
								<div class="widget-header text-center">
									<h3 class="widget-title">Popular Posts</h3>
									<img src="images/wave.svg" class="wave" alt="wave" />
								</div>
								<div class="widget-content">
									<?php
									$number = 1;
									foreach ($result4 as $data) {
										$popularEventId = $data[0];
										$popularEventTitle = $data[1];
										$popularEventDate = $data[2];
										echo <<<Buat
											<div class="post post-list-sm circle">
											<div class="thumb circle">
												<span class="number">$number</span>
												<a href="detailEvent.php?eventId=$popularEventId">
													<div class="inner">
														<img src="images/posts/tabs-1.jpg" alt="post-title" />
													</div>
												</a>
											</div>
											<div class="details clearfix">
												<h6 class="post-title my-0"><a href="detailEvent.php?eventId=$popularEventId">$popularEventTitle</a></h6>
												<ul class="meta list-inline mt-1 mb-0">
													<li class="list-inline-item">$popularEventDate</li>
												</ul>
											</div>
										</div>
										Buat;
										$number++;
									}
									?>
								</div>
							</div>

							<!-- widget categories -->
							<div class="widget rounded">
								<div class="widget-header text-center">
									<h3 class="widget-title">Explore Topics</h3>
									<img src="images/wave.svg" class="wave" alt="wave" />
								</div>
								<div class="widget-content">
									<ul class="list">
										<?php
										$jumlah = $result3[0][0];
										echo "<li><a href='listEvent.php'>ALL</a><span>($jumlah)</span></li>";
										foreach ($result2 as $isi) {
											$categoryName = $isi[1];
											$jumlah = $isi[2];
											echo "<li><a href='listEvent.php?category=$categoryName'>$categoryName</a><span>($jumlah)</span></li>";
										}
										?>

									</ul>
								</div>

							</div>

							<!-- widget advertisement -->
							<div class="widget no-container rounded text-md-center">
								<span class="ads-title">- Sponsored Ad -</span>
								<a href="#" class="widget-ads">
									<img src="images/ads/ad-360.png" alt="Advertisement" />
								</a>
							</div>

							<!-- widget tags -->
							<div class="widget rounded">
								<div class="widget-header text-center">
									<h3 class="widget-title">Tag Clouds</h3>
									<img src="images/wave.svg" class="wave" alt="wave" />
								</div>
								<div class="widget-content">
									<a href="#" class="tag">#Trending</a>
									<a href="#" class="tag">#Video</a>
									<a href="#" class="tag">#Featured</a>
									<a href="#" class="tag">#Gallery</a>
									<a href="#" class="tag">#Celebrities</a>
								</div>
							</div>

						</div>

					</div>

				</div>

			</div>
		</section>

		<!-- instagram feed -->
		<div class="instagram">
			<div class="container-xl">
				<!-- button -->
				<a href="https://www.instagram.com/kolabfit/" class="btn btn-default btn-instagram">@Ko+Lab on Instagram</a>
				<!-- images -->
				<div class="instagram-feed d-flex flex-wrap">
					<div class="insta-item col-sm-2 col-6 col-md-2">
						<a href="#">
							<img src="images/instagram/instagram-content1.jpg" alt="insta-title" />
						</a>
					</div>
					<div class="insta-item col-sm-2 col-6 col-md-2">
						<a href="#">
							<img src="images/instagram/instagram-content2.jpg" alt="insta-title" />
						</a>
					</div>
					<div class="insta-item col-sm-2 col-6 col-md-2">
						<a href="#">
							<img src="images/instagram/instagram-content3.jpg" alt="insta-title" />
						</a>
					</div>
					<div class="insta-item col-sm-2 col-6 col-md-2">
						<a href="#">
							<img src="images/instagram/instagram-content4.jpg" alt="insta-title" />
						</a>
					</div>
					<div class="insta-item col-sm-2 col-6 col-md-2">
						<a href="#">
							<img src="images/instagram/instagram-content5.jpg" alt="insta-title" />
						</a>
					</div>
					<div class="insta-item col-sm-2 col-6 col-md-2">
						<a href="#">
							<img src="images/instagram/instagram-content6.jpg" alt="insta-title" />
						</a>
					</div>
				</div>
			</div>
		</div>

		<!-- footer -->
		<footer>
			<div class="container-xl">
				<div class="footer-inner">
					<div class="row d-flex align-items-center gy-4">
						<!-- copyright text -->
						<div class="col-md-4">
							<span class="copyright">© 2023 Nguliah.id</span>
						</div>

						<!-- social icons -->
						<div class="col-md-4 text-center">
							<ul class="social-icons list-unstyled list-inline mb-0">
								<li class="list-inline-item"><a href="https://www.instagram.com/kolabfit/"><i class="fab fa-instagram"></i></a></li>
								<li class="list-inline-item"><a href="#"><i class="fab fa-youtube"></i></a></li>
							</ul>
						</div>

						<!-- go to top button -->
						<div class="col-md-4">
							<a href="#" id="return-to-top" class="float-md-end"><i class="icon-arrow-up"></i>Back to Top</a>
						</div>
					</div>
				</div>
			</div>
		</footer>

	</div><!-- end site wrapper -->

	<!-- search popup area -->
	<div class="search-popup">
		<!-- close button -->
		<button type="button" class="btn-close" aria-label="Close"></button>
		<!-- content -->
		<div class="search-content">
			<div class="text-center">
				<h3 class="mb-4 mt-0">Press ESC to close</h3>
			</div>
			<!-- form -->
			<form class="d-flex search-form">
				<input class="form-control me-2" type="search" placeholder="Search and press enter ..." aria-label="Search">
				<button class="btn btn-default btn-lg" type="submit"><i class="icon-magnifier"></i></button>
			</form>
		</div>
	</div>

	<!-- canvas menu -->
	<div class="canvas-menu d-flex align-items-end flex-column">
		<!-- close button -->
		<button type="button" class="btn-close" aria-label="Close"></button>

		<!-- logo -->
		<div class="logo">
			<img src="images/logo.svg" alt="Katen" />
		</div>

		<!-- menu -->
		<nav>
			<ul class="vertical-menu">
				<li>
					<a href="index.html">Home</a>
				</li>
				<li><a class="active" href="category.html">Event</a></li>
				<li><a href="category.html">Blog</a></li>
				<li>
					<a href="#">Media</a>
				</li>
				<li><a href="contact.html">Loker/Magang</a></li>
			</ul>
		</nav>

		<!-- social icons -->
		<ul class="social-icons list-unstyled list-inline mb-0 mt-auto w-100">
			<li class="list-inline-item"><a href="#"><i class="fab fa-instagram"></i></a></li>
			<li class="list-inline-item"><a href="#"><i class="fab fa-youtube"></i></a></li>
		</ul>
	</div>

	<!-- JAVA SCRIPTS -->
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/slick.min.js"></script>
	<script src="js/jquery.sticky-sidebar.min.js"></script>
	<script src="js/custom.js"></script>

</body>

</html>