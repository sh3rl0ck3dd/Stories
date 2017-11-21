<?php
ob_start();
session_start();

include_once 'dbconnect.php';


$error = false;
if( isset($_SESSION['user']) ) {
	header("Location: home.php");
	exit;
}

if ( isset($_POST['btn-signup']) ) {
	
		// clean user inputs to prevent sql injections
	$name = trim($_POST['name']);
	$name = strip_tags($name);
	$name = htmlspecialchars($name);

	$email = trim($_POST['email']);
	$email = strip_tags($email);
	$email = htmlspecialchars($email);
	
	$pass = trim($_POST['pass']);
	$pass = strip_tags($pass);
	$pass = htmlspecialchars($pass);
	
		// basic name validation
	if (empty($name)) {
		$error = true;
		$nameError = "Please enter your full name.";
	} else if (strlen($name) < 3) {
		$error = true;
		$nameError = "Name must have atleat 3 characters.";
	} else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
		$error = true;
		$nameError = "Name must contain alphabets and space.";
	}

	else {
		$query = "SELECT user_name FROM users WHERE user_name='$name'";
		$result = mysql_query($query);
		$count = mysql_num_rows($result);
		if($count!=0){
			$error = true;
			$nameError = "Provided username is already in use.";
		}
	}
	
		//basic email validation
	if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
		$error = true;
		$emailError = "Please enter valid email address.";
	} else {
			// check email exist or not
		$query = "SELECT user_email FROM users WHERE user_email='$email'";
		$result = mysql_query($query);
		$count = mysql_num_rows($result);
		if($count!=0){
			$error = true;
			$emailError = "Provided Email is already in use.";
		}
	}
		// password validation
	if (empty($pass)){
		$error = true;
		$passError = "Please enter password.";
	} else if(strlen($pass) < 6) {
		$error = true;
		$passError = "Password must have atleast 6 characters.";
	}
	
		// password encrypt using SHA256();
	 $password = hash('sha256', $pass);
	
		// if there's no error, continue to signup
	if( !$error ) {
		
		$query = "INSERT INTO users (user_name,user_email,user_password,user_dp,XP) VALUES('$name','$email','$password','gallery/default.jpg',100)";
		$query2="CREATE TABLE ".$name." (friend_id int ,friend_name varchar(30) )";  
		$res = mysql_query($query);

		$find_id=mysql_query("select user_id from users where user_name ='".$name."'");
     	$row=mysql_fetch_array($find_id);
     	$idd=$row["user_id"];
		$query4="CREATE TABLE ".$idd."likes (likedposts int  )";  
   		$query3 = "INSERT INTO ".$name." VALUES(".$idd.",'".$name."')";

		$res2=mysql_query($query2);
		$res3=mysql_query($query3);
		$res4=mysql_query($query4);


		
		if ($res && $res2) {
			$errTyp = "success";
			$errMSG = "Successfully registered, you may login now";
			unset($name);
			unset($email);
			unset($pass);
		} else {
			$errTyp = "danger";
			$errMSG = "Something went wrong, try again later...";	
		}	
		
	}
	
	
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Register</title>
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
							<a href="login.php">LOGIN</a>
					</li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</nav> 






		<div class="container below-navbar"  >

			<div id="login-form">
				<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">

					<div class="col-md-12">

						<div class="form-group">
							<h2 class="">Sign Up.</h2>
						</div>

						<div class="form-group">
							<hr />
						</div>

						<?php
						if ( isset($errMSG) ) {

							?>
							<div class="form-group">
								<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
									<span class="glyphicon glyphicon-info-sign">You are register ..pls login to continue</span> <?php echo $errMSG1; ?>
								</div>
							</div>
							<?php
						}
						?>

						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
								<input type="text" name="name" class="form-control" placeholder="Enter Name" maxlength="50" value="<?php echo $name ?>" />
							</div>
							<span class="text-danger"><?php echo $nameError; ?></span>
						</div>

						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
								<input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php echo $email ?>" />
							</div>
							<span class="text-danger"><?php echo $emailError; ?></span>
						</div>

						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
								<input type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="15" />
							</div>
							<span class="text-danger"><?php echo $passError; ?></span>
						</div>

						<div class="form-group">
							<hr />
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
						</div>

						<div class="form-group">
							<hr />
						</div>

						

					</div>

				</form>
			</div>	

		</div>
	</div>

</div>


</body>
</html>
<?php ob_end_flush(); ?>














































































































































































































































































































































































































































