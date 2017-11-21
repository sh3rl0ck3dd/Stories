<?php
     ob_start();
        session_start();
include_once 'dbconnect.php';
  
if(isset($_POST['post_head']) && isset($_POST['post_src']))
{
  $head=$_POST['post_head'];
  $source=$_POST['post_src'];
  $describe=$_POST['post_desc'];

   $res2=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
                 $userRow2=mysql_fetch_array($res2);
                  $name1=$userRow2['user_name'];
                  $userid=$userRow2['user_id'];
  $xpquery=mysql_query("UPDATE users set XP=XP + 25 where user_id=".$_SESSION['user']);
  $insert=mysql_query("INSERT INTO stories (owner_id,post_head,post_description,post_image,time)  VALUES('$userid','$head','$describe','$source',now())");
  $temp=mysql_insert_id();
  $insert2=mysql_query("INSERT INTO likes (like_id,nooflikes)  VALUES('$temp','0')");
  
  ?>
       <div class="contentcontainer"> 
                      <div class="posts_div" > 
                        <h3 class="owner_name"><?php echo $name1;?></h3>
                        <h5 class="description"><?php echo $describe;?></h5>


                        <div class="polaroid">
                          <img class="my-image-size" src="<?php echo $source;?>" alt="Loading image error chck path"/>
                          <div class="container1">
                            <p><?php echo $head;?></p>
                          </div>
                        </div>
                      </div>
                    </div>
  <?php
  
exit;
}

?>