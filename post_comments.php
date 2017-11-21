<?php
    ob_start();
        session_start();
include_once 'dbconnect.php';

if(isset($_POST['post_pestid']) && isset($_POST['post_cmmnts']))
{
  $comments=$_POST['post_cmmnts'];
  $paastid=$_POST['post_pestid'];

  $res2=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
                 $userRow2=mysql_fetch_array($res2);
                  $name1=$userRow2['user_name'];
                  $userid=$userRow2['user_id'];
  $insert=mysql_query("insert into comments(post_id,comment,comment_owner,time) values('$paastid','$comments','$name1',now())");
  $xpquery=mysql_query("UPDATE users set XP=XP + 10 where user_id=".$_SESSION['user']);
  ?>
      
                 
                  <div id ="all-comments" >
                            <table>
                                <tr>
                                  <div id="all_comments<?php echo $counter?>"  > 
                                    <td><p class="ownername"><?php echo $name1;?>  :  </p><hr ></td>
                                    <td><p class="fullcomment"><?php echo $comments;?></p><hr></td>


                                  </tr>


                                   </table>
                                 </div>

  <?php
  
exit;
}

?>