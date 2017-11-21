<?php
ob_start();
session_start();
include_once 'dbconnect.php';
$error = false;
if( isset($_SESSION['user']) ) {
	header("Location: home.php");
	exit;
}
if( isset($_POST['btn-login']) ) {	
	
		// prevent sql injections/ clear user invalid inputs
	$email = trim($_POST['email']);
	$email = strip_tags($email);
	$email = htmlspecialchars($email);
	
	$pass = trim($_POST['pass']);
	$pass = strip_tags($pass);
	$pass = htmlspecialchars($pass);
		// prevent sql injections / clear user invalid inputs
	
	if(empty($email)){
		$error = true;
		$emailError = "Please enter your email address.";
	} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
		$error = true;
		$emailError = "Please enter valid email address.";
	}
	
	if(empty($pass)){
		$error = true;
		$passError = "Please enter your password.";
	}
	
		// if there's no error, continue to login
	if (!$error) {
		
			$password = hash('sha256', $pass); // password hashing using SHA256
		
		$res=mysql_query("SELECT user_id, user_name, user_password FROM users WHERE user_email='$email'");
		$row=mysql_fetch_array($res);
			$count = mysql_num_rows($res); // if uname/pass correct it returns must be 1 row
			
			if( $count == 1 && $row['user_password']==$password ) {
				$_SESSION['user'] = $row['user_id'];
				header("Location:home.php");
			} else {
				$errMSG = "Incorrect Credentials, Try again...";
			}
			
		}
		
	}
	?>

	<html>
	<head>
		<title>Stories/login</title>
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="javaScript" type="text/js" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
		<link rel="stylesheet" type="text/css" href="main.css">
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					
					<a class="navbar-brand "  href="login.php">STORIES </a>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					

					<ul class="nav navbar-nav navbar-right">

						<li>    
							<a href="register.php">REGISTER</a>
						</li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</nav> 

		<div class="container below-navbar">

			<div id="login-form">
				<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
					
					<div class="col-md-12">
						
						<div class="form-group">
							<h2 class="">Sign In.</h2>
						</div>
						
						<div class="form-group">
							<hr />
						</div>
						
						<?php
						if ( isset($errMSG) ) {
							
							?>
							<div class="form-group">
								<div class="alert alert-danger">
									<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
								</div>
							</div>
							<?php
						}
						?>
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
								<input type="email" name="email" class="form-control" placeholder="Your Email" value="<?php echo $email; ?>" maxlength="40" />
							</div>
							<span class="text-danger"><?php echo $emailError; ?></span>
						</div>
						
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
								<input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="15" />
							</div>
							<span class="text-danger"><?php echo $passError; ?></span>
						</div>
						
						<div class="form-group">
							<hr />
						</div>
						
						<div class="form-group">
							<button type="submit" class="btn btn-block btn-primary" name="btn-login">Sign In</button>
						</div>
						
						<div class="form-group">
							<hr />
						</div>
						
					</body>
					</html>
					<?php ob_end_flush(); ?>
