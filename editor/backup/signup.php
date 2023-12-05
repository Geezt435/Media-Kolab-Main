<?php
require_once  __DIR__ .  "/../helper/getConnection.php";
require_once  __DIR__ . "/../helper/getConnectionMsqli.php";
require_once  __DIR__ . "/../helper/hash.php";

$conn = getConnection();
$signupSuccess = null;

if (isset($_POST['signup-submit'])) {
	$username = $_POST['signup-username'];
	$email = $_POST['signup-email'];
	$password = $_POST['signup-password'];
	$confirmPassword = $_POST['signup-confirm-password'];
	$phoneNumber = $_POST['signup-phone-number'];
	$roleId = $_POST['signup-role'];

	// Cek Ketersediaan Username
	$sql = "SELECT * FROM tb_editor WHERE username = :username or email = :email or phone_number = :phoneNumber";
	$request = $conn->prepare($sql);
	$request->bindParam('username', $username);
	$request->bindParam('email', $email);
	$request->bindParam('phoneNumber', $phoneNumber);

	$request->execute();

	if ($result = $request->fetchAll()) {
		$signupSuccess = False;
	} else {
		if ($password != $confirmPassword) {
			echo "Password tidak matching";
		} else {
			$id = generateIdEditor();
			$passwordHashed = hashPassword($confirmPassword);
			$sqlInsert = "INSERT INTO tb_editor(editor_id, username, password, email, phone_number, role_id) values(?, ?, ?, ?, ?, ?)";
			$requestInsert = $conn->prepare($sqlInsert);
			$requestInsert->bindParam(1, $id);
			$requestInsert->bindParam(2, $username);
			$requestInsert->bindParam(3, $passwordHashed);
			$requestInsert->bindParam(4, $email);
			$requestInsert->bindParam(5, $phoneNumber);
			$requestInsert->bindParam(6, $roleId);

			$requestInsert->execute();
			$signupSuccess = True;
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Portal - Bootstrap 5 Admin Dashboard Template For Developers</title>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<meta name="description" content="Portal - Bootstrap 5 Admin Dashboard Template For Developers">
	<meta name="author" content="Xiaoying Riley at 3rd Wave Media">
	<link rel="shortcut icon" href="favicon.ico">

	<!-- FontAwesome JS-->
	<script defer src="../assets/plugins/fontawesome/js/all.min.js"></script>

	<!-- App CSS -->
	<link id="theme-style" rel="stylesheet" href="../assets/css/portal.css">

</head>

<body class="app app-signup p-0">
	<div class="row g-0 app-auth-wrapper">
		<div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
			<?php
			if ($signupSuccess === True) {
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
				echo "<strong>Selamat, </strong>akun telah berhasil ditambahkan. buatlah konten dengan bijak :)</div>";
				echo <<<Javascript
				<script>
					function redirect(){
						window.location.href='loginEditor.php'
					};
					setTimeout(redirect, 3000);
				</script>;
				Javascript;
			} else if ($signupSuccess === False) {
				echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
				echo "<strong>Mohon maaf, </strong>sepertinya username/nomor hp/email yang anda masukkan telah digunakan.</div>";
			}
			?>
			<div class="d-flex flex-column align-content-end">
				<div class="app-auth-body mx-auto">
					<div class="app-auth-branding mb-4"><a class="app-logo" href="index.html"><img class="logo-icon me-2" src="../assets/images/app-logo.svg" alt="logo"></a></div>
					<h2 class="auth-heading text-center mb-4">Sign up to Portal</h2>

					<div class="auth-form-container text-start mx-auto">
						<form class="auth-form auth-signup-form" action="signup.php" method="POST">
							<div class="username mb-3">
								<label class="sr-only" for="signup-username">Username</label>
								<input id="signup-username" user="signup-username" type="text" class="form-control signup-username" name="signup-username" placeholder="Username" required="required">
							</div>
							<div class="email mb-3">
								<label class="sr-only" for="signup-email">Your Email</label>
								<input id="signup-email" name="signup-email" type="email" class="form-control signup-email" placeholder="Email" name="signup-username" required="required">
							</div>
							<div class="password mb-3">
								<label class="sr-only" for="signup-password">Password</label>
								<input id="signup-password" name="signup-password" type="password" class="form-control signup-password" placeholder="Create your password" name="signup-password" required="required">
							</div>
							<div class="confirm-password mb-3">
								<label class="sr-only" for="signup-confirm-password">Password</label>
								<input id="signup-confirm-password" name="signup-confirm-password" type="password" class="form-control signup-confirm-password" placeholder="Confirm your password" name="signup-confirm-password" required="required">
							</div>
							<div class="phone-number mb-3">
								<label class="sr-only" for="signup-phone-number">phone-number</label>
								<input id="signup-phone-number" name="signup-phone-number" type="phone-number" class="form-control signup-phone-number" placeholder="Input your phonenumber, ex : 081234567890" name="singup-phone-number required=" required">
							</div>
							<div class="role mb-3">
								<select class="form-select" name="signup-role">
									<option value="" disabled selected hidden>Pilih Role Anda</option>
									<?php
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
							</div>
							<!--//extra-->
							<!-- <div class="extra mb-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" value="" id="RememberPassword">
									<label class="form-check-label" for="RememberPassword">
										I agree to Portal's <a href="#" class="app-link">Terms of Service</a> and <a href="#" class="app-link">Privacy Policy</a>.
									</label>
								</div>
							</div>//extra -->

							<div class="text-center">
								<button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto" name="signup-submit">Sign Up</button>
							</div>
						</form><!--//auth-form-->

						<div class="auth-option text-center pt-5">Already have an account? <a class="text-link" href="loginEditor.php">Log in</a></div>
					</div><!--//auth-form-container-->



				</div><!--//auth-body-->

				<footer class="app-auth-footer">
					<div class="container text-center py-3">
						<!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
						<small class="copyright">Designed with <span class="sr-only">love</span><i class="fas fa-heart" style="color: #fb866a;"></i> by <a class="app-link" href="http://themes.3rdwavemedia.com" target="_blank">Xiaoying Riley</a> for developers</small>

					</div>
				</footer><!--//app-auth-footer-->
			</div><!--//flex-column-->
		</div><!--//auth-main-col-->
		<div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
			<div class="auth-background-holder">
			</div>
			<div class="auth-background-mask"></div>
			<div class="auth-background-overlay p-3 p-lg-5">
				<div class="d-flex flex-column align-content-end h-100">
					<div class="h-100"></div>
					<div class="overlay-content p-3 p-lg-4 rounded">
						<h5 class="mb-3 overlay-title">Explore Portal Admin Template</h5>
						<div>Portal is a free Bootstrap 5 admin dashboard template. You can download and view the template license <a href="https://themes.3rdwavemedia.com/bootstrap-templates/admin-dashboard/portal-free-bootstrap-admin-dashboard-template-for-developers/">here</a>.</div>
					</div>
				</div>
			</div><!--//auth-background-overlay-->
		</div><!--//auth-background-col-->

	</div><!--//row-->


</body>

</html>