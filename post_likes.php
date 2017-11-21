<?php
    ob_start();
        session_start();
include_once 'dbconnect.php';

if(isset($_POST['post_pesstid']) )
{
  $paastid=$_POST['post_pesstid'];
 $likes_individual = mysql_query("insert into ".$_SESSION['user']."likes values (".$paastid.")");

$likes_pick = mysql_query("select nooflikes from likes where like_id=".$paastid." ");
                      $rowlike=mysql_fetch_array($likes_pick);
                      $number=$rowlike['nooflikes'];
                      $number++;
  $insert2=mysql_query(" UPDATE likes SET nooflikes ='$number' where like_id=".$paastid."");
  $xpquery=mysql_query("UPDATE users set XP=XP + 5 where user_id=".$_SESSION['user']);
     
  ?>
      <div id="all-likes">
                          <p class="nooflik-s"><?php echo $number?></p> 

                       </div>

  <?php
  
exit;
}
