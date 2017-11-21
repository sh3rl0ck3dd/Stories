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
   $friend_id=mysql_query("select user_id from users where user_name='".$name."'" );
                          $row2 = mysql_fetch_array($friend_id);
                          $id=$row2['user_id'];
                         
//$likes_individual = mysql_query("insert into ".$session_name." values (".$id.",'".$name."'')");
 $likes_individual = mysql_query("insert into ".$session_name." values (".$id.",'".$name."')");

     
  ?>
 
  <?php
  
exit;
}
