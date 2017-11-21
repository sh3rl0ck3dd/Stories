<?php
    ob_start();
        session_start();
include_once 'dbconnect.php';

if(isset($_POST['post_name']) )
{
  $name=$_POST['post_name'];
   $tablename=mysql_query("select user_name from users where user_id=".$_SESSION['user']."" );
                          $row3 = mysql_fetch_array($tablename);
                          $session_name=$row3['user_name'];
                         
 $likes_individual = mysql_query("delete from ".$session_name." where friend_name='".$name."'");

     
  ?>
  <?php
  
exit;
}
