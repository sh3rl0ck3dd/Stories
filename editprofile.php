<?php
ob_start();
session_start();

include_once 'dbconnect.php';
if( !isset($_SESSION['user']) ) {
	header("Location: login.php");
	exit;
}
$error = false;

if ( isset($_POST['update']) ) {
	
		// clean user inputs to prevent sql injections
	$address = trim($_POST['address']);
	$address = strip_tags($address);
	$address = htmlspecialchars($address);

	$description = trim($_POST['description']);
	$description = strip_tags($description);
	$description = htmlspecialchars($description);

	$interests = trim($_POST['interests']);
	$interests = strip_tags($interests);
	$interests = htmlspecialchars($interests);
	
	$work = trim($_POST['work']);
	$work = strip_tags($work);
	$work = htmlspecialchars($work);

	$dp = trim($_POST['dp']);
	$dp = strip_tags($dp);
	$dp = htmlspecialchars($dp);



	
	
	if (!empty($address) && (strlen($address) > 1)) {
		$res = mysql_query("UPDATE users SET user_address = '$address' WHERE user_id = ".$_SESSION['user']);
		if ($res) {
			$errTyp = "success";
			$errMSG = "Successfully registered, you may login now";
			unset($address);
			
		}else {
			$errTyp = "danger";
			$errMSG = "Something went wrong, try again later...";	
		}
		
		
	}
	if (!empty($interests) && (strlen($interests) > 1)) {
		$res = mysql_query("UPDATE users SET user_interests = '$interests' WHERE user_id = ".$_SESSION['user']);
		if ($res) {
			$errTyp = "success";
			$errMSG = "Successfully registered, you may login now";
			unset($interests);
			
		}else {
			$errTyp = "danger";
			$errMSG = "Something went wrong, try again later...";	
		}
		
		
	}
	if (!empty($work) && (strlen($work) > 1)) {
		$res = mysql_query("UPDATE users SET user_work = '$work' WHERE user_id = ".$_SESSION['user']);
		if ($res) {
			$errTyp = "success";
			$errMSG = "Successfully registered, you may login now";
			unset($work);
			
		}else {
			$errTyp = "danger";
			$errMSG = "Something went wrong, try again later...";	
		}
		
		
	}
	if (!empty($description) && (strlen($description) > 1)) {
		$res = mysql_query("UPDATE users SET user_description = '$description' WHERE user_id = ".$_SESSION['user']);
		if ($res) {
			$errTyp = "success";
			$errMSG = "Successfully registered, you may login now";
			unset($description);
			
		}else {
			$errTyp = "danger";
			$errMSG = "Something went wrong, try again later...";	
		}
		
		
	}
	if (!empty($dp) && (strlen($dp) > 1)) {
		$res = mysql_query("UPDATE users SET user_dp = '$dp' WHERE user_id = ".$_SESSION['user']);
		if ($res) {
			$errTyp = "success";
			$errMSG = "Successfully registered, you may login now";
			unset($description);
			
		}else {
			$errTyp = "danger";
			$errMSG = "Something went wrong, try again later...";	
		}
		
		
	}
	

}

?>

<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">

				<a class="navbar-brand " >STORIES </a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li><a href="home.php">Home</a></li>

					<li ><a href="myposts.php">MyPosts</a></li>

				</ul>

				<ul class="nav navbar-nav navbar-right">
					<ul class="nav navbar-nav">
						<li><a href="profile.php">Profile</a></li>


					</ul>
					<ul class="nav navbar-nav">
						<li><a href="logout.php?logout">logout</a></li>


					</ul>
				</li>
			</ul>
		</div><!--/.nav-collapse -->
	</div>
</nav> 

<div class="container">
	<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
		
		<div class="col-md-12">
			
			<div class="form-group">
				<h2 >EDIT PROFILE.</h2>
			</div>
			
			<div class="form-group">
				<hr />
			</div>
			
			<?php
			if ( isset($errMSG) ) {
				
				?>
				<div class="form-group">
					<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
						<span class="glyphicon glyphicon-info-sign">data is updated</span> <?php echo $errMSG1; ?>
					</div>
				</div>
				<?php
			}
			?>
			
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-home"></span></span>
					<input type="text" name="address" class="form-control" placeholder="Address" value="<?php echo $address ?>" />
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-tasks"></span></span>
					<input type="text" name="interests" class="form-control" placeholder="interests"  value="<?php echo $interests ?>" />
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-briefcase"></span></span>
					<input type="text" name="work" class="form-control" placeholder="Work" value="<?php echo $work ?>" />
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
					<input type="text" name="description" class="form-control" placeholder="Desscribe Yourself"  value="<?php echo $description ?>" />
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-picture"></span></span>
					<input type="text" name="dp" class="form-control" placeholder="dp link"  value="<?php echo $dp ?>" />
				</div>
			</div>
			
			
			
			<div class="form-group">
				<hr />
			</div>
			
			<div class="form-group">
				<button type="submit" class="btn btn-block btn-primary" name="update">update</button>
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