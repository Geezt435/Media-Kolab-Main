<?php
require_once __DIR__ . "/../helper/getConnectionMsqli.php";
require_once __DIR__ . "/../helper/cloudinary.php";
require_once __DIR__ . "/../helper/hash.php";

$conn = getConnectionMysqli();
$sql = "SELECT tb_blog.blog_title,tb_blog.date_release,tb_editor.username,tb_category_blog.category_name, tb_blog.blog_id, tb_blog.image_url FROM tb_blog inner join tb_editor on tb_blog.editor_id = tb_editor.editor_id inner join tb_category_blog on tb_blog.category_id = tb_category_blog.category_id";
$req = mysqli_query($conn, $sql);
$result = mysqli_fetch_all($req);
$sql2 = "SELECT tb_blog.blog_title,tb_blog.date_release,tb_editor.username,tb_category_blog.category_name, tb_blog.blog_id  FROM tb_blog inner join tb_editor on tb_blog.editor_id = tb_editor.editor_id inner join tb_category_blog on tb_blog.category_id = tb_category_blog.category_id ORDER BY tb_blog.views desc limit 4";
$req2 = mysqli_query($conn, $sql2);
$result2 = mysqli_fetch_all($req2);
$sqlRecentBlog = "SELECT tb_blog.blog_title,tb_blog.date_release,tb_editor.username,tb_category_blog.category_name, tb_blog.blog_id  FROM tb_blog inner join tb_editor on tb_blog.editor_id = tb_editor.editor_id inner join tb_category_blog on tb_blog.category_id = tb_category_blog.category_id ORDER BY tb_blog.date_release desc limit 4";
$reqRecentBlog = mysqli_query($conn, $sqlRecentBlog);
$resultRecentBlog = mysqli_fetch_all($reqRecentBlog);
$sql3 = "SELECT tb_media.media_title,tb_media.date_release,tb_editor.username,tb_category_media.category_name, tb_media.media_id, tb_media.thumbnail FROM tb_media inner join tb_editor on tb_media.editor_id = tb_editor.editor_id inner join tb_category_media on tb_media.category_id = tb_category_media.category_id ORDER BY tb_media.date_release desc limit 6";
$req3 = mysqli_query($conn, $sql3);
$result3 = mysqli_fetch_all($req3);
$sqlPopular = "SELECT tb_media.media_title,tb_media.date_release,tb_editor.username,tb_category_media.category_name, tb_media.media_id, tb_media.thumbnail FROM tb_media inner join tb_editor on tb_media.editor_id = tb_editor.editor_id inner join tb_category_media on tb_media.category_id = tb_category_media.category_id ORDER BY tb_media.views desc limit 3";
$reqPopular = mysqli_query($conn, $sqlPopular);
$resultPopular = mysqli_fetch_all($reqPopular);
$sql4 = "SELECT tb_event.event_title,tb_event.date_release,tb_editor.username,tb_category_event.category_name, tb_event.image_url, tb_event.event_id FROM tb_event inner join tb_editor on tb_event.editor_id = tb_editor.editor_id inner join tb_category_event on tb_event.category_id = tb_category_event.category_id ORDER BY tb_event.date_release desc limit 6";
$req4 = mysqli_query($conn, $sql4);
$result4 = mysqli_fetch_all($req4);
$sql5 = "SELECT tb_job_vacancies.vacancy_title,tb_job_vacancies.date_release,tb_editor.username,tb_category_job_vacancy.category_name, tb_job_vacancies.image_url, tb_job_vacancies.vacancy_id FROM tb_job_vacancies inner join tb_editor on tb_job_vacancies.editor_id = tb_editor.editor_id inner join tb_category_job_vacancy on tb_job_vacancies.category_id = tb_category_job_vacancy.category_id ORDER BY tb_job_vacancies.date_release desc limit 5";
$req5 = mysqli_query($conn, $sql5);
$result5 = mysqli_fetch_all($req5);
$sql6 = "SELECT tb_blog.blog_title,tb_blog.date_release,tb_editor.username,tb_category_blog.category_name, tb_blog.blog_id, tb_blog.image_url, tb_blog.blog_content FROM tb_blog inner join tb_editor on tb_blog.editor_id = tb_editor.editor_id inner join tb_category_blog on tb_blog.category_id = tb_category_blog.category_id ORDER BY RAND() LIMIT 2";
$req6 = mysqli_query($conn, $sql6);
$result6 = mysqli_fetch_all($req6);
$sql7 = "SELECT tb_media.media_title,tb_media.date_release,tb_editor.username,tb_category_media.category_name, tb_media.media_id, tb_media.thumbnail, tb_media.media_content FROM tb_media inner join tb_editor on tb_media.editor_id = tb_editor.editor_id inner join tb_category_media on tb_media.category_id = tb_category_media.category_id ORDER BY RAND() LIMIT 2";
$req7 = mysqli_query($conn, $sql7);
$result7 = mysqli_fetch_all($req7);
$sqlPopularCat = "SELECT tb_blog.blog_id, tb_category_blog.category_name, tb_blog.blog_title, tb_editor.username, tb_blog.date_release, tb_blog.image_url FROM tb_blog INNER JOIN tb_category_blog ON tb_blog.category_id = tb_category_blog.category_id INNER JOIN tb_editor ON tb_blog.editor_id = tb_editor.editor_id WHERE tb_blog.category_id = (SELECT category_id FROM tb_category_blog where popularity = (SELECT MAX(popularity) FROM tb_category_blog) LIMIT 1) ORDER BY RAND() LIMIT 5";
$reqPopularCat = mysqli_query($conn, $sqlPopularCat);
$resultPopularCat = mysqli_fetch_all($reqPopularCat);
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
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all">

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
		<header class="header-default">
			<nav class="navbar navbar-expand-lg">
				<div class="container-xl">
					<!-- site logo -->
					<a class="navbar-brand" href="index.html"><img src="images/logo-text.png" width="130" alt="logo" /></a>

					<div class="collapse navbar-collapse">
						<!-- menus -->
						<ul class="navbar-nav mr-auto">
							<li class="nav-item active">
								<a class="nav-link" href="index.php">Home</a>
							</li>
							<li class="nav-item"><a class="nav-link" href="listEvent.php">Event</a></li>
							<li class="nav-item"><a class="nav-link" href="listBlog.php">Blog</a></li>
							<li class="nav-item">
								<a class="nav-link" href="listMedia.php">Media</a>
							</li>
							<li class="nav-item"><a class="nav-link" href="listJobVacancies.php">Loker/Magang</a></li>
						</ul>
					</div>

					<!-- header right section -->
					<div class="header-right">
						<!-- social icons -->
						<ul class="social-icons list-unstyled list-inline mb-0">
							<li class="list-inline-item"><a href="#"><i class="fab fa-instagram"></i></a></li>
							<li class="list-inline-item"><a href="#"><i class="fab fa-youtube"></i></a></li>
						</ul>
						<!-- header buttons -->
						<div class="header-buttons">
							<button class="search icon-button">
								<i class="icon-magnifier"></i>
							</button>
							<button class="burger-menu icon-button">
								<span class="burger-icon"></span>
							</button>
						</div>
					</div>
				</div>
			</nav>
		</header>

		<!-- hero section -->
		<section id="hero">

			<div class="container-xl">

				<div class="row gy-4">

					<div class="col-lg-8">

						<!-- featured post large -->
						<div class="post featured-post-lg">
							<div class="details clearfix">
								<a href="category.html" class="category-badge"><?php echo $result[0][3] ?></a>
								<h2 class="post-title"><a href="detailBlog.php?blogId=<?php echo $result[0][4] ?>"><?php echo $result[0][0] ?></a></h2>
								<ul class="meta list-inline mb-0">
									<li class="list-inline-item"><a href="detailBlog.php?blogId=<?php echo $result[0][4] ?>"><?php echo $result[0][1] ?></a></li>
									<li class="list-inline-item"><?php echo $result[0][2] ?></li>
								</ul>
							</div>
							<a href="detailBlog.php?blogId=<?php echo $result[0][4] ?>">
								<div class="thumb rounded">
									<div class="inner data-bg-image" data-bg-image=<?php echo getImageDefault(decryptPhotoProfile($result[0][5])); ?>></div>
								</div>
							</a>
						</div>
					</div>

					<div class="col-lg-4">
						<?php
						foreach ($result as $home) {
						}
						?>
						<!-- post tabs -->
						<div class="post-tabs rounded bordered">
							<!-- tab navs -->
							<ul class="nav nav-tabs nav-pills nav-fill" id="postsTab" role="tablist">
								<li class="nav-item" role="presentation"><button aria-controls="popular" aria-selected="true" class="nav-link active" data-bs-target="#popular" data-bs-toggle="tab" id="popular-tab" role="tab" type="button">Popular</button></li>
								<li class="nav-item" role="presentation"><button aria-controls="recent" aria-selected="false" class="nav-link" data-bs-target="#recent" data-bs-toggle="tab" id="recent-tab" role="tab" type="button">Recent</button></li>
							</ul>
							<!-- tab contents -->
							<div class="tab-content" id="postsTabContent">
								<!-- loader -->
								<div class="lds-dual-ring"></div>
								<!-- popular posts -->
								<div aria-labelledby="popular-tab" class="tab-pane fade show active" id="popular" role="tabpanel">
									<!-- post -->
									<?php
									foreach ($result2 as $data) {
										$blog_title = $data[0];
										$date_release = $data[1];
										$blogId = $data[4];
										echo <<<Buat
									<div class="post post-list-sm circle">
									<div class="thumb circle">
										<a href="detailBlog.php?blogId=$blogId">
											<div class="inner">
												<img src="images/posts/tabs-2.jpg" alt="post-title" />
											</div>
										</a>
									</div>
									<div class="details clearfix">
										<h6 class="post-title my-0"><a href="detailBlog.php?blogId=$blogId">$blog_title</a></h6>
										<ul class="meta list-inline mt-1 mb-0">
											<li class="list-inline-item">$date_release</li>
										</ul>
									</div>
									</div>
									Buat;
									}
									?>
								</div>
								<!-- recent posts -->
								<div aria-labelledby="recent-tab" class="tab-pane fade" id="recent" role="tabpanel">
									<!-- post -->
									<?php
									foreach ($resultRecentBlog as $data) {
										$blog_title = $data[0];
										$date_release = $data[1];
										$blogId = $data[4];
										echo <<<Buat
										<div class="post post-list-sm circle">
										<div class="thumb circle">
											<a href="detailBlog.php?blogId=$blogId">
												<div class="inner">
													<img src="images/posts/tabs-2.jpg" alt="post-title" />
												</div>
											</a>
										</div>
										<div class="details clearfix">
											<h6 class="post-title my-0"><a href="detailBlog.php?blogId=$blogId">$blog_title</a></h6>
											<ul class="meta list-inline mt-1 mb-0">
												<li class="list-inline-item">$date_release</li>
											</ul>
										</div>
										</div>
										Buat;
									}
									?>
								</div>
							</div>
						</div>
					</div>

				</div>

			</div>

		</section>

		<!-- section main content -->
		<section class="main-content">
			<div class="container-xl">
				<div class="row gy-4">

					<div class="col-lg-8">

						<!-- section header -->
						<div class="section-header">
							<h3 class="section-title">Media</h3>
							<img src="images/wave.svg" class="wave" alt="wave" />
						</div>

						<div class="padding-30 rounded bordered">
							<div class="row gy-5">
								<div class="col-sm-6">
									<!-- post -->
									<?php
									$index = 0;
									foreach ($result3 as $file) {
										if ($index == 0) {
											$image = getImageNews(decryptPhotoProfile($file[5]));
											echo <<<Buat
											<div class="post">
											<div class="thumb rounded">
												<a href="category.html" class="category-badge position-absolute">$file[3]</a>
												<span class="post-format">
													<i class="icon-picture"></i>
												</span>
												<a href="detailMedia.php?mediaId=$file[4]">
													<div class="inner">
														$image
													</div>
												</a>
											</div>
											<ul class="meta list-inline mt-4 mb-0">
												<li class="list-inline-item"><a href="#">$file[2]</a></li>
												<li class="list-inline-item">$file[1]</li>
											</ul>
											<h5 class="post-title mb-3 mt-3"><a href="detailMedia.php?mediaId=$file[4]">$file[0]</a></h5>
											</div>
											Buat;
										} else {
											break;
										}
										$index++;
									}
									?>
								</div>
								<div class="col-sm-6">
									<?php
									$index = 0;
									foreach ($result3 as $file) {
										if ($index > 0) {
											$image = getImageNews(decryptPhotoProfile($file[5]));
											echo <<<Buat
											<div class="post post-list-sm square">
											<div class="thumb rounded">
												<a href="detailMedia.php?mediaId=$file[4]">
													<div class="inner">
														$image
													</div>
												</a>
											</div>
											<div class="details clearfix">
												<h6 class="post-title my-0"><a href="detailMedia.php?mediaId=$file[4]">$file[0]</a></h6>
												<ul class="meta list-inline mt-1 mb-0">
													<li class="list-inline-item">$file[1]</li>
												</ul>
											</div>
											</div>
										Buat;
										}
										$index++;
									}
									?>
								</div>
							</div>
						</div>

						<div class="spacer" data-height="50"></div>

						<!-- horizontal ads -->
						<div class="ads-horizontal text-md-center">
							<span class="ads-title">- Sponsored Ad -</span>
							<a href="#">
								<img src="images/ads/ad-750.png" alt="Advertisement" />
							</a>
						</div>

						<div class="spacer" data-height="50"></div>

						<!-- section header -->
						<div class="section-header">
							<h3 class="section-title">Event</h3>
							<img src="images/wave.svg" class="wave" alt="wave" />
						</div>

						<div class="padding-30 rounded bordered">
							<div class="row gy-5">
								<div class="col-sm-6">
									<!-- post -->
									<?php
									for ($index = 0; $index < count($result4); $index++) {
										$eventTitle = $result4[$index][0];
										$eventDateRelease = $result4[$index][1];
										$usernameEditor = $result4[$index][2];
										$eventCategory = $result4[$index][3];
										$eventUrlImage = $result4[$index][4];
										$eventId = $result4[$index][5];

										if ($index == 0) {
											$image = getImageNews(decryptPhotoProfile($eventUrlImage));
											echo <<<Buat
											<div class="post">
												<div class="thumb rounded">
													<a href="detailEvent.php?eventId=$eventId" class="category-badge position-absolute">$eventCategory</a>
													<span class="post-format">
														<i class="icon-picture"></i>
													</span>
													<a href="detailEvent.php?eventId=$eventId">
														<div class="inner">
															$image
														</div>
													</a>
												</div>
												<ul class="meta list-inline mt-4 mb-0">
													<li class="list-inline-item"><a href="#">$usernameEditor</a></li>
													<li class="list-inline-item">$eventDateRelease</li>
												</ul>
												<h5 class="post-title mb-3 mt-3"><a href="detailEvent.php?eventId=$eventId">$eventTitle</a></h5>
											</div>
											Buat;
										} else if ($index <= 2) {
											$image = getImageNews(decryptPhotoProfile($eventUrlImage));
											echo <<<Buat
											<div class="post post-list-sm square before-seperator">
												<div class="thumb rounded">
													<a href="detailEvent.php?eventId=$eventId">
														<div class="inner">
															$image
														</div>
													</a>
												</div>
												<div class="details clearfix">
													<h6 class="post-title my-0">
														<a href="detailEvent.php?eventId=$eventId">$eventTitle</a>
													</h6>
													<ul class="meta list-inline mt-1 mb-0">
														<li class="list-inline-item">$eventDateRelease</li>
													</ul>
												</div>
											</div>
											Buat;
										} else {
											break;
										}
									}
									?>
									<!-- post -->
								</div>
								<div class="col-sm-6">
									<!-- post -->
									<?php
									for ($index = 3; $index < count($result4); $index++) {
										$eventTitle = $result4[$index][0];
										$eventDateRelease = $result4[$index][1];
										$usernameEditor = $result4[$index][2];
										$eventCategory = $result4[$index][3];
										$eventUrlImage = $result4[$index][4];
										$eventId = $result4[$index][5];

										if ($index == 3) {
											$image = getImageNews(decryptPhotoProfile($eventUrlImage));
											echo <<<Buat
											<div class="post">
												<div class="thumb rounded">
													<a href="detailEvent.php?eventId=$eventId" class="category-badge position-absolute">$eventCategory</a>
													<span class="post-format">
														<i class="icon-picture"></i>
													</span>
													<a href="detailEvent.php?eventId=$eventId">
														<div class="inner">
															$image
														</div>
													</a>
												</div>
												<ul class="meta list-inline mt-4 mb-0">
													<li class="list-inline-item"><a href="#">$usernameEditor</a></li>
													<li class="list-inline-item">$eventDateRelease</li>
												</ul>
												<h5 class="post-title mb-3 mt-3"><a href="detailEvent.php?eventId=$eventId">$eventTitle</a></h5>
											</div>
											Buat;
										} else if ($index <= 5) {
											$image = getImageNews(decryptPhotoProfile($eventUrlImage));
											echo <<<Buat
											<div class="post post-list-sm square before-seperator">
												<div class="thumb rounded">
													<a href="detailEvent.php?eventId=$eventId">
														<div class="inner">
															$image
														</div>
													</a>
												</div>
												<div class="details clearfix">
													<h6 class="post-title my-0">
														<a href="detailEvent.php?eventId=$eventId">$eventTitle</a>
													</h6>
													<ul class="meta list-inline mt-1 mb-0">
														<li class="list-inline-item">$eventDateRelease</li>
													</ul>
												</div>
											</div>
											Buat;
										} else {
											break;
										}
									}
									?>
								</div>
							</div>

							<div class="spacer" data-height="50"></div>

							<!-- section header -->
							<div class="section-header">
								<h3 class="section-title">Loker/Magang</h3>
								<img src="images/wave.svg" class="wave" alt="wave" />
								<div class="slick-arrows-top">
									<button type="button" data-role="none" class="carousel-topNav-prev slick-custom-buttons" aria-label="Previous"><i class="icon-arrow-left"></i></button>
									<button type="button" data-role="none" class="carousel-topNav-next slick-custom-buttons" aria-label="Next"><i class="icon-arrow-right"></i></button>
								</div>
							</div>

							<div class="row post-carousel-twoCol post-carousel">
								<!-- Post -->
								<?php
								foreach ($result5 as $data) {
									echo <<<Buat
									<div class="post post-over-content col-md-6">
										<div class="details clearfix">
											<a href="detailJobVacancies.php?jobId=$data[5]" class="category-badge">$data[3]</a>
											<h4 class="post-title"><a href="detailJobVacancies.php?jobId=$data[5]">$data[0]</a></h4>
											<ul class="meta list-inline mb-0">
												<li class="list-inline-item"><a href="detailJobVacancies.php?jobId=$data[5]">$data[2]</a></li>
												<li class="list-inline-item">$data[1]</li>
											</ul>
										</div>
										<a href="detailJobVacancies.php?jobId=$data[5]">
											<div class="thumb rounded">
												<div class="inner">
													<img src="images/posts/inspiration-1.jpg" alt="thumb" />
												</div>
											</div>
										</a>
									</div>
									Buat;
								}
								?>
							</div>

							<div class="spacer" data-height="50"></div>

							<!-- section header -->
							<div class="section-header">
								<h3 class="section-title">Latest Posts</h3>
								<img src="images/wave.svg" class="wave" alt="wave" />
							</div>

							<div class="padding-30 rounded bordered">

								<div class="row">


									<?php
									$indexMedia = 0;
									$indexBlog = 0;
									for ($loop = 0; $loop < 4; $loop++) {
										if ($loop % 2 == 0) {
											$data = $result7;
											$redirect = "detailMedia.php?mediaId=";
											$index = $indexMedia++;
										} else {
											$data = $result6;
											$redirect = "detailBlog.php?blogId=";
											$index = $indexBlog++;
										}
										$contentTitle = $data[$index][0];
										$contentRelease = $data[$index][1];
										$contentEditor = $data[$index][2];
										$contentCategory = $data[$index][3];
										$contentId = $data[$index][4];
										$contentImage = getImageNews(decryptPhotoProfile($data[$index][5]));

										echo <<<Buat
											<div class="col-md-12 col-sm-6">
												<div class="post post-list clearfix">
													<div class="thumb rounded">
														<a href="$redirect$contentId">
															<div class="inner">
																$contentImage
															</div>
														</a>
													</div>
													<div class="details">
														<ul class="meta list-inline mb-3">
															<li class="list-inline-item"><a href="#">$contentEditor</a></li>
															<li class="list-inline-item"><a href="#">$contentCategory</a></li>
															<li class="list-inline-item">$contentRelease</li>
														</ul>
														<h5 class="post-title"><a href="$redirect$contentId">$contentTitle</a></h5>
														<p class="excerpt mb-0"><br><br></p>
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
																<a href="$redirect$contentId"><span class="icon-options"></span></a>
															</div>
														</div>
													</div>
												</div>
											</div>
											Buat;
									}
									?>
								</div>
								<!-- load more button -->
								<div class="text-center">
									<button class="btn btn-simple">Load More</button>
								</div>

							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<!-- sidebar -->
						<div class="sidebar">
							<!-- widget popular posts -->
							<div class="widget rounded">
								<div class="widget-header text-center">
									<h3 class="widget-title">Popular Media</h3>
									<img src="images/wave.svg" class="wave" alt="wave" />
								</div>
								<div class="widget-content">
									<?php
									$number = 1;
									foreach ($resultPopular as $data) {
										$popularMediaId = $data[4];
										$popularMediaTitle = $data[0];
										$popularMediaDate = $data[1];
										echo <<<Buat
											<div class="post post-list-sm circle">
											<div class="thumb circle">
												<span class="number">$number</span>
												<a href="detailMedia?mediaId=$popularMediaId">
													<div class="inner">
														<img src="images/posts/tabs-1.jpg" alt="post-title" />
													</div>
												</a>
											</div>
											<div class="details clearfix">
												<h6 class="post-title my-0"><a href="detailMedia?mediaId=$popularMediaId">$popularMediaTitle</a></h6>
												<ul class="meta list-inline mt-1 mb-0">
													<li class="list-inline-item">$popularMediaDate</li>
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
										<li><a href="#">Lifestyle</a><span>(5)</span></li>
										<li><a href="#">Inspiration</a><span>(2)</span></li>
										<li><a href="#">Fashion</a><span>(4)</span></li>
										<li><a href="#">Politic</a><span>(1)</span></li>
										<li><a href="#">Trending</a><span>(7)</span></li>
										<li><a href="#">Culture</a><span>(3)</span></li>
									</ul>
								</div>

							</div>

							<!-- widget post carousel -->
							<div class="widget rounded">
								<div class="widget-header text-center">
									<h3 class="widget-title"><?php echo $resultPopularCat[0][1] ?></h3>
									<img src="images/wave.svg" class="wave" alt="wave" />
								</div>
								<div class="widget-content">
									<div class="post-carousel-widget">
										<?php
										foreach ($resultPopularCat as $data) {
											$image = getImageNews(decryptPhotoProfile($data[5]));
											echo <<<Buat
											<div class="post post-carousel">
												<div class="thumb rounded">
													<a href="category.html" class="category-badge position-absolute">$data[1]</a>
													<a href="detailBlog.php?blogId=$data[0]">
														<div class="inner">
															$image
														</div>
													</a>
												</div>
												<h5 class="post-title mb-0 mt-4"><a href="detailBlog.php?blogId=$data[0]">$data[2]</a></h5>
												<ul class="meta list-inline mt-2 mb-0">
													<li class="list-inline-item"><a href="#">$data[3]</a></li>
													<li class="list-inline-item">$data[4]</li>
												</ul>
											</div>
											Buat;
										}
										?>
									</div>
									<!-- carousel arrows -->
									<div class="slick-arrows-bot">
										<button type="button" data-role="none" class="carousel-botNav-prev slick-custom-buttons" aria-label="Previous"><i class="icon-arrow-left"></i></button>
										<button type="button" data-role="none" class="carousel-botNav-next slick-custom-buttons" aria-label="Next"><i class="icon-arrow-right"></i></button>
									</div>
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
				<li class="active">
					<a href="index.php">Home</a>
				</li>
				<li><a href="listEvent.php">Event</a></li>
				<li><a href="listBlog.php">Blog</a></li>
				<li>
					<a href="listMedia.php">Media</a>
				</li>
				<li><a href="listJobVacancies">Loker/Magang</a></li>
			</ul>
		</nav>

		<!-- social icons -->
		<ul class="social-icons list-unstyled list-inline mb-0 mt-auto w-100">
			<li class="list-inline-item"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
			<li class="list-inline-item"><a href="#"><i class="fab fa-twitter"></i></a></li>
			<li class="list-inline-item"><a href="#"><i class="fab fa-instagram"></i></a></li>
			<li class="list-inline-item"><a href="#"><i class="fab fa-pinterest"></i></a></li>
			<li class="list-inline-item"><a href="#"><i class="fab fa-medium"></i></a></li>
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