<?php
require_once __DIR__ . "/../helper/hash.php";
require_once __DIR__ . "/../helper/getConnection.php";
require_once __DIR__ . "/../helper/getConnectionMsqli.php";
require_once __DIR__ . "/../helper/eventfunctions.php";
require_once __DIR__ . "/../helper/validateLoginEditor.php";
require_once __DIR__ . "/../helper/cloudinary.php";

// Get connections
$conn = getConnectionMysqli();
$dbConnection = getConnection();

// Fetching data from the tb_tag table
$query = $dbConnection->query("SELECT * FROM tb_tag");
$tags = $query->fetchAll(PDO::FETCH_ASSOC);

// Fetching data from the tb_category table
$query = $dbConnection->query("SELECT * FROM tb_category_event");
$categories = $query->fetchAll(PDO::FETCH_ASSOC);

// Post Detection
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Script Update event
    if (isset($_POST['updateButton'])) {
        try {
            $eventId = $_POST['eventId'];
            $updateTitle = $_POST['updateTitle'];
            $tagId = $_POST['taginput'];
            $categoryId = $_POST['catinput'];

            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sqlUpdate = "UPDATE tb_event SET 
					event_title = :updateTitle,
					tag_id = :tagId,
					category_id = :categoryId
					WHERE event_id = :eventId";

            $request = $dbConnection->prepare($sqlUpdate);

            $request->bindParam('updateTitle', $updateTitle);
            $request->bindParam('tagId', $tagId);
            $request->bindParam('categoryId', $categoryId);
            $request->bindParam('eventId', $eventId);
            $request->execute();

            header("Location:manageevent.php");
        } catch (PDOException $e) {
            echo "<script>alert('Error! $e');</script>";
        }
    }

    // Script Delete event
    if (isset($_POST['deleteButton'])) {
        $eventId = $_POST['eventId'];

        $sqlDelete = "DELETE FROM tb_event WHERE event_id = ?";
        $requestDelete = mysqli_prepare($conn, $sqlDelete);

        mysqli_stmt_bind_param($requestDelete, "s", $eventId);
        mysqli_stmt_execute($requestDelete);
        mysqli_stmt_close($requestDelete);
    }

    header("location:manageEvent.php");
    exit;
}

if (isset($_GET['search-event'])) {
    $searchEvent = $_GET['searchorders'];
    $sql = "SELECT * FROM tb_event WHERE event_title LIKE '%$searchEvent%'";
} else {
    $sql = "SELECT * FROM tb_event";
}

// Setting event Datasets
$events = mysqli_query($conn, $sql);

if ($events) {
    $eventArray = [];
    while ($event = mysqli_fetch_assoc($events)) {
        $eventArray[] = $event;
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
    <title>Nguliah.id - For Editor</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Nguliah.id - For Editor">
    <meta name="author" content="Xiaoying Riley at 3rd Wave event">
    <link rel="shortcut icon" href="favicon.ico">

    <!-- Script -->
    <script defer src="../assets/plugins/fontawesome/js/all.min.js"></script>

    <!-- CSS -->
    <link id="theme-style" rel="stylesheet" href="../assets/css/portal.css">
    <link id="theme-style" rel="stylesheet" href="../assets\scss\portal.css">
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
                            <a class="nav-link active" href="manageEvent.php">
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
                <div class="row g-3 mb-4 align-items-center justify-content-between">
                    <div class="col-auto">
                        <h1 class="app-page-title mb-0">My Event</h1>
                    </div>
                    <div class="col-auto">
                        <div class="page-utilities">
                            <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                                <div class="col-auto">
                                    <form class="table-search-form row gx-1 align-items-center" action="manageevent.php" method="GET">
                                        <div class="col-auto">
                                            <input type="text" id="search-orders" name="searchorders" class="form-control search-orders" placeholder="Search">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn app-btn-secondary" name="search-event">Search</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-auto">
                                    <a class="btn app-btn-secondary" href="createevent.php">
                                        <svg xmlns=" http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                                        </svg>
                                    </a>
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
                                                <th class="cell">Id event</th>
                                                <th class="cell">Title</th>
                                                <th class="cell">Date Release</th>
                                                <th class="cell">Views</th>
                                                <th class="cell">Category</th>
                                                <th class="cell">Tag</th>
                                                <th class="cell">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($eventArray as $event) {
                                                $eventId = $event['event_id'];
                                                $tagname = getTagNameFromId($event['tag_id']);
                                                $categname = getCategoryeventNameFromId($event['category_id']);
                                                echo <<<TULIS
														<tr>
															<td class="cell"><strong>{$event['event_id']}</strong></td>
															<td class="cell">{$event['event_title']}</td>
															<td class="cell">{$event['date_release']}</td>
															<td class="cell">{$event['views']}</td>
															<td class="cell">{$categname}</td>
															<td class="cell">{$tagname}</td>
															<td class="cell">
																<a class="btn btn-light" data-toggle="modal" href="#view-event-{$event['event_id']}">View</a>
																<a class="btn btn-secondary" data-toggle="modal" href="#update-event-{$event['event_id']}">Edit</a>
																<a class="btn btn-danger" data-toggle="modal" href="#delete-event" onclick="getDeleteEventId('$eventId')">Delete</a>
															</td>
														</tr>
													TULIS;
                                            }
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
                <small class="copyright">Designed with <span class="sr-only">love</span><i class="fas fa-heart" style="color: #fb866a;"></i> by <a class="app-link" href="http://themes.3rdwaveevent.com" target="_blank">Xiaoying Riley</a> for developers</small>
            </div>
        </footer>
    </div>

    <!-- View event Modal Pop Up -->
    <?php foreach ($eventArray as $event) {
        $tagname = getTagNameFromId($event['tag_id']);
        $categname = getCategoryeventNameFromId($event['category_id']);
        $formattedDate = dateFormatter($event['date_release']);
        if ($event['image_url'] != "") {
            $imageurl = "<div class='form-outline mb-4'><h3>Image</h3><p><a href='{$event['image_url']}' target='_blank'><img src='{$event['image_url']}' alt='Image'></a></div>";
        } else {
            $imageurl = "";
        }
        echo <<<TULIS
			<div class="modal fade" id="view-event-{$event['event_id']}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h3>View event</h3>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row d-flex justify-content-center align-items-center">
								<div class="card-body p-4">
									<div class="form-outline mb-4">
										<h3>event ID</h3>
										<p>{$event['event_id']}</p>
									</div>
									<div class="form-outline mb-4">
										<h3>Title</h3>
										<p>{$event['event_title']}</p>
									</div>
									<div class="form-outline mb-4">
										<h3>Content</h3>
										<p>{$event['event_content']}</p>
									</div>
									<div class="form-outline mb-4">
										<h3>Date Release</h3>
										<p>{$formattedDate}</p>
									</div>
									{$imageurl}
									<div class="form-outline mb-4">
										<h3>Views</h3>
										<p>{$event['views']}</p>
									</div>
									<div class="form-outline mb-4">
										<h3>Tag</h3>
										<p>{$tagname}</p>
									</div>
									<div class="form-outline mb-4">
										<h3>Category</h3>
										<p>{$categname}</p>
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

    <!-- Update event Modal Pop Up -->
    <?php foreach ($eventArray as $event) {
        $tagname = getTagNameFromId($event['tag_id']);
        $categname = getCategoryeventNameFromId($event['category_id']);
        $formattedDate = dateFormatter($event['date_release']);
        if ($event['image_url'] != "") {
            $imageurl = "<div class='form-outline mb-4'><label class='form-label'>Image URL</label><input type='text' name='updateImageUrl' class='form-control form-control-lg' value='{$event['image_url']}'></div>";
        } else {
            $imageurl = "<div class='form-outline mb-4'><label class='form-label'>Image URL</label><input type='text' name='updateImageUrl' class='form-control form-control-lg'></div>";
        }
        $tagselections = "";
        $categoryselections = "";
        foreach ($tags as $tag) {
            if ($tag['tag_id'] == $event['tag_id']) {
                $tagselections .= "<option value='{$tag['tag_id']}' selected>{$tag['tag_name']}</option>";
            } else {
                $tagselections .= "<option value='{$tag['tag_id']}'>{$tag['tag_name']}</option>";
            }
        }
        foreach ($categories as $category) {
            if ($category['category_id'] == $event['category_id']) {
                $categoryselections .= "<option value='{$category['category_id']}' selected>{$category['category_name']}</option>";
            } else {
                $categoryselections .= "<option value='{$category['category_id']}'>{$category['category_name']}</option>";
            }
        }
        echo <<<TULIS
			<div class="modal fade" id="update-event-{$event['event_id']}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
				<form action="" method="POST" id="formUpdateevent" enctype="multipart/form-data">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h3>Update event</h3>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="row d-flex justify-content-center align-items-center">
									<div class="card-body p-4">
										<input type="hidden" name="eventId" value="{$event['event_id']}">
										<div class="form-outline mb-4">
											<label class="form-label">Judul event</label>
											<input type="text" name="updateTitle" class="form-control form-control-lg" required value='{$event['event_title']}'>
										</div>
										<div class="form-outline mb-4">
											<label class="form-label">Tag</label>
											<select name="taginput" id="taginput" class="form-control">
											{$tagselections}
											</select>
										</div>
										<div class="form-outline mb-4">
											<label class="form-label">Categories</label>
											<select name="catinput" id="catinput" class="form-control">
											{$categoryselections}
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-secondary" name="updateButton" data-bs-dismiss="modal">Update</button>
							</div>
						</div>
					</div>
				</form>
			</div>
			
		TULIS;
    } ?>

    <!-- Delete event Modal Pop Up -->
    <div class="modal fade" id="delete-event" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Deletion Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this event?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn app-btn-secondary" data-dismiss="modal">Close</button>
                    <form action="" method="POST" id="formDeleteevent">
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
        function getDeleteEventId(eventId) {
            console.log(eventId)
            const formDelete = document.getElementById("formDeleteevent");
            const deleteInput = document.createElement("input");

            deleteInput.setAttribute("type", "hidden");
            deleteInput.setAttribute("name", "eventId");
            deleteInput.setAttribute("value", eventId);

            formDelete.appendChild(deleteInput);
        }
    </script>
</body>

</html>