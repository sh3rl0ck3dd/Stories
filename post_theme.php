<?php
    ob_start();
        session_start();
include_once 'dbconnect.php';

if(isset($_POST['post_theme']) )
{
  $psttheme=$_POST['post_theme'];
$updatequery=mysql_query("update users set theme='".$psttheme."' where user_id=".$_SESSION['user']); 
  

 }
  ?>
      <div id="all-likes">
                          <p class="nooflik-s"><?php echo $psttheme?></p> 

                       </div>

  <?php
exit;

