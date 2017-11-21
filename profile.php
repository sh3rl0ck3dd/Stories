<?php
ob_start();
session_start();

include_once 'dbconnect.php';
if( !isset($_SESSION['user']) ) {
	header("Location: login.php");
	exit;
}

$error = false;


// select loggedin users detail
$res=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);
$username=$userRow['user_name'];


if ( isset($_POST['addnew']) ) {
	
	$_SESSION['user'] = $_SESSION['user'];
	header("Location: editprofile.php");
}
?>
<html>
<head>
	<title>Profile</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="javaScript" type="text/js" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
  <link rel="stylesheet" type="text/css" href="profiles.css">

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

          
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </nav> 
<div class="below-navbar">
  <div style="width: 100%;">
   <div style="float:left; width: 48%">
     <img class="my-image-size" src="<?php echo $userRow['user_dp'];  ?>" alt ="check your link"/>

   </div>
   <div >
    <table>
  <tr><td><h3 >NAME:<h3></td><td style="padding-left: 15px;"></h3> <?php echo $userRow['user_name'];;  ?></h3></td></tr>
  <tr><td><h3 >EMAIL: <h3></td><td style="padding-left: 15px;"></h3><?php echo $userRow['user_email'];  ?></h3></td></tr>
  <tr><td><h3 >ADDRESS: <h3></td><td style="padding-left: 15px;"></h3><?php echo $userRow['user_address']; ?></h3></td></tr>
  <tr><td><h3 >INTERESTS: <h3></td><td style="padding-left: 15px;"></h3><?php echo $userRow['user_interests'];  ?></h3></td></tr>
  <tr><td><h3 >WORK: <h3></td><td style="padding-left: 15px;"></h3><?php echo $userRow['user_work'];  ?></h3></td></tr>
  </table>
   </div>
</div>
 
  
  
  <form method="post" action="<?php ($_SERVER['PHP_SELF']); ?>" >
    <div class="form-group">
     <button type="submit" class="btn btn-block btn-primary" name="addnew">Edit Profile</button>
   </div>
 </form>
 </div>

</body>
</html>