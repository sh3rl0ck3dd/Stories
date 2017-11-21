<?php
    ob_start();
        session_start();
include_once 'dbconnect.php';

if(isset($_POST['post_pessstid']) )
{
  $paastid=$_POST['post_pessstid'];
$delete_post = mysql_query(" delete from stories where post_id=".$paastid." ");
                      
  $delete_like=mysql_query(" delete from likes where like_id=".$paastid."");
  $delete_comments=mysql_query("delete from comments where post_id=".$paastid . "");
  $xpquery=mysql_query("UPDATE users set XP=XP - 25 where user_id=".$_SESSION['user']);
  
  ?>
  <div id="all-posts">
                  <?php 
                  $posts_pick = mysql_query("select owner_id,post_head,post_description,post_id,post_image from stories order by time desc");


                  $counter=0;
                  $likesscounter=0;
                  $commentcounter=0;

                  while(($row=mysql_fetch_array($posts_pick)) && ($counter>=0))
                  {
                    $owner_name=$row['owner_id'];
                    $head=$row['post_head'];
                    $imgsource=$row['post_image'];
                    $description=$row['post_description'];
                    $postid=$row['post_id']
                    ?>
                    <div class="posts_div"> 
                      <h3 class="owner_name"><?php echo $owner_name;?></h3>
                      <h4 class="head"><?php echo $head;?></h4> 

                      <img class="my-image-size" src="<?php echo $imgsource;?>"/>
                      <h5 class="description"><?php echo $description;?></h5>



                      <?php
                      $likes_pick = mysql_query("select nooflikes from likes where like_id=".$postid." ");
                      $rowlike=mysql_fetch_array($likes_pick);
                      $number=$rowlike['nooflikes'];
                      ?> 
                      <div>
                        <form method='post' action="" onsubmit="return post_likes('<?php echo $likesscounter ?>');">
                          <div class="form-group input-group">
                            <input type="hidden" id="likeid<?php echo $likesscounter?>" value=<?php echo $postid ?>>


                            <input type="submit" class="btn  btn-info "value="like">
                          </div>
                        </form>
                          <form method='post' action="" onsubmit="return post_deletes('<?php echo $counter ?>');">
                          <div class="form-group input-group">
                            <input type="hidden" id="deleteid<?php echo $likesscounter?>" value=<?php echo $postid ?>>


                            <input type="submit" class="btn  btn-danger "value="delete">
                          </div>
                        </form>

                        <div id="all-likes">
                          <p class="nooflik-s"><?php echo $number?></p> 

                        </div>
                      </div>

                      <div>

                        <form method='post' action="" onsubmit="return post_comments('<?php echo $counter ?>','<?php echo $commentcounter ?>');">
                          <div class="form-group input-group">
                            <input type="text" class="form-control"id="cmmnt<?php echo $commentcounter?>" placeholder="write comment here.. ">
                            <input type="hidden" id="pstd<?php echo $counter?>" value=<?php echo $postid ?>>

                            <input type="submit" class="btn  btn-primary" value="Post Comment">
                          </div>
                        </form>

                      </div>


                      <div id ="all-comments">
                        <?php
                        $comments_pick = mysql_query("select comment_owner,comment,comment_time from comments where post_id=".$postid." order by comment_time desc");
                        while($row2=mysql_fetch_array($comments_pick)){
                          $ownername=$row2['comment_owner'];
                          $fullcomment=$row2['comment'];
                          $commenttime=$row2['comment_time'];


                          ?>
                          <div class="all_comments"> 
                            <p class="ownername">comment By:<?php echo $ownername;?></p>
                            <p class="fullcomment"><?php echo $fullcomment;?></p> 
                            <p class="commenttime"><?php echo $commenttime;?></p>
                            <?php
                          }    

                          ?>

                        </div>


                      </div>


                      <?php
                      $counter++;
                      $likesscounter++;
                      $commentcounter++;

                    }
                    ?>
                  </div>
                </div>
              </div>
  <?php
  
exit;
}
