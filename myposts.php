       <?php
            ob_start();
            session_start();
            include_once 'dbconnect.php';
            $error = false;
            if( !isset($_SESSION['user']) ) {
              header("Location: login.php");
              exit;
            }
            ?>
            <html>
            <head>
              <title>STORIES</title>

              <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

              <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
              <link rel="javaScript" type="text/js" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
              <link rel="stylesheet" type="text/css" href="main.css">

            </head>

            <body>
               <div class="container ">
                <div class="row" >
                  <div class="col-lg-3 col-sm-2"></div>
                  <div class="col-lg-6 col-sm-8">

              <div id="background"></div>

              <nav class="navbar navbar-default navbar-fixed-top">
              <div class="container">
                <div class="navbar-header">

                  <a class="navbar-brand " >STORIES </a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                  <ul class="nav navbar-nav">
                    <li><a href="home.php">Home</a></li>

                    <li ><a href="myposts.php">MyPosts</a></li>
                    <li><a href="findfriends.php">FindFriends</a> </li>

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

              <div class ="container below-navbar">
               


                <div id="all-posts">
                  <?php 
                  $posts_pick = mysql_query("select owner_id,post_head,post_description,post_id,post_image from stories where owner_id=".$_SESSION['user']." order by time desc");


                  $counter=0;
                  $likesscounter=0;
                  $commentcounter=0;

                  while(($row=mysql_fetch_array($posts_pick)) && ($counter>=0))
                  {
                    $owner_name=$row['owner_id'];
                    $head=$row['post_head'];
                    $imgsource=$row['post_image'];
                    $description=$row['post_description'];
                    $postid=$row['post_id'];
                    $name_pick = mysql_query("select user_name from users where user_id=".$owner_name.""); 
                    while($rowname=mysql_fetch_array($name_pick)){
                      $owner_original_name=$rowname['user_name'];
                    }
                    ?>
                    <div class="contentcontainer"> 
                      <div class="posts_div" > 
                        <h3 class="owner_name"><?php echo $owner_original_name ;?></h3>
                        <h5 class="description"><?php echo $description;?></h5>

                        
                        <div class="polaroid">
                          <img class="my-image-size" src="<?php echo $imgsource;?>" alt="Loading image error chck path"/>
                          <div class="container1">
                            <p><?php echo $head;?></p>
                          </div>
                        </div>



                        <?php
                        $likes_pick = mysql_query("select nooflikes from likes where like_id=".$postid." ");
                        $rowlike=mysql_fetch_array($likes_pick);
                        

                        $number=$rowlike['nooflikes'];
                        
                        

                        
                        $is_liked=mysql_query("select * from ".$_SESSION['user']."likes where likedposts=".$postid." " );
                        $count_rows = mysql_num_rows($is_liked);
                        if($count_rows==0){
                         $likecolor='';
                       }
                       else{
                        $likecolor='btn-primary';
                      }     
                      ?> 
                      <div>
                        <table>
                          <tr>
                            <td>
                              <form method='post' action="" onsubmit="return post_likes('<?php echo $likesscounter ?>');">
                                <div class="form-group input-group">
                                  <input  type="hidden" id="likeid<?php echo $likesscounter?>" value=<?php echo $postid ?>>
                                  <input  type="hidden" id="rowss<?php echo $likesscounter?>" value=<?php echo $count_rows ?>>

                                  <input id="bttn<?php echo $counter?>" class="btn <?php echo $likecolor ?> "  type="submit" value="LIKE">
                                </div>
                              </form>
                            </td>

                            <td>
                              
                              <div id="all-likes">
                                <p class="nooflik-s"><?php echo $number?></p> 

                              </div>
                            </td >
                            <td style="padding-left:260px;"><form method='post' action="" onsubmit="return post_deletes('<?php echo $counter ?>');">
                          <div class="form-group input-group">
                            <input type="hidden" id="deleteid<?php echo $likesscounter?>" value=<?php echo $postid ?>>


                            <input type="submit" class="btn  btn-danger "value="delete">
                          </div>
                        </form></td>
                          </tr>
                        </table>
                      </div>

                      <div>
                        <table>
                          <tr>
                            <form method='post' action="" onsubmit="return post_comments('<?php echo $counter ?>','<?php echo $commentcounter ?>');">
                              <div class="form-group input-group">
                                <td><input type="text" size="35" class="form-control"id="cmmnt<?php echo $commentcounter?>" placeholder="write comment here.. "></td>
                                <input type="hidden" id="pstd<?php echo $counter?>" value=<?php echo $postid ?>>

                                <td> <input  type="submit" class="btn  btn-primary" value="Post Comment"></td>
                              </div>
                            </tr>
                          </form>
                        </table>

                      </div>

                      <!-- <button data-toggle="collapse" data-target="#cahl">View all Comments</button> -->

                      <div id ="all-comments" >
                        <table>
                          <?php
                          $comments_pick = mysql_query("select comment_owner,comment,time from comments where post_id=".$postid." order by time desc");
                          while($row2=mysql_fetch_array($comments_pick)){
                            $ownername=$row2['comment_owner'];
                            $fullcomment=$row2['comment'];
                            $commenttime=$row2['comment_time'];


                            ?>
                            <tr>
                              <div id="all_comments<?php echo $counter?>"  > 
                                <td><p class="ownername"><?php echo $ownername;?>  :  </p><hr></td>
                                <td><p class="fullcomment"><?php echo $fullcomment;?></p><hr></td>
                                
                                
                              </tr>


                              <?php
                            }
                            if($row2==null){
                              ?>
                              <li class="comment-border" >
                                <div id="all_comments<?php echo $counter?>"  > 
                                 <p>  .  </p>


                               </li>
                               <?php
                             }    

                             ?>
                           </table>
                         </div>


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
              </div>
               <script type="text/javascript">
              function post_likes(var1){
              var psstid = document.getElementById("likeid"+var1).value;
              var clor = document.getElementById("rowss"+var1).value;



              if(clor==0)
              {
                  // console.log("in iff functionn");

                  $.ajax
                  ({
                    type: 'post',
                    url: 'post_likes.php',
                    data: 
                    {
                     post_pesstid:psstid,
                   },
                   success: function (response) 
                   {

                    // console.log("in iff functionn");
                    document.getElementById("bttn"+var1).classList.toggle('btn-primary');
                    



                  }
                });
                  clor=1;
                }
                else{
                 $.ajax
                 ({
                  type: 'post',
                  url: 'post_dislike.php',


                  data: 

                  {

                   post_pesstid:psstid,

                 },
                 success: function (response) 
                 {

                  console.log("in iff functionn");
                  document.getElementById("bttn"+var1).classList.toggle('btn-primary');



                }
              });
                 clor=0;
               }

               return false;



             }
              function post_deletes(var1){
                var pssstid = document.getElementById("deleteid"+var1).value;
                console.log("in functionn");
                if('true')
                {
                  console.log("in iff functionn");

                  $.ajax
                  ({
                    type: 'post',
                    url: 'post_delete.php',


                    data: 

                    {

                     post_pessstid:pssstid,

                   },
                   success: function (response) 
                   {

                    console.log("in iff functionn");
                    document.getElementById("all-posts").innerHTML=response;



                  }
                });

                }
                else{
                  console.log("nobody is perfect");
                }
                
                return false;



              }

              function post_comments(var1,var2){
                var commentss = document.getElementById("cmmnt"+var2).value;
                var pstid = document.getElementById("pstd"+var1).value;
                console.log(commentss);
                console.log(pstid);




                if(commentss)
                {

                  $.ajax
                  ({
                    type: 'post',
                    url: 'post_comments.php',


                    data: 

                    {
                     post_cmmnts:commentss,
                     post_pestid:pstid,

                   },
                   success: function (response) 
                   {


                    document.getElementById("all-comments").innerHTML=response+document.getElementById("all-comments").innerHTML;
                    document.getElementById("cmmnt"+var2).value="";


                  }
                });

                }
                else{
                  console.log("nobody is perfect");
                }
                
                return false;

              }
              </script>
                  </div>
          <div class="col-lg-3 col-sm-2"></div>

        </div>
      </div>
            </body>
            </html>
            <?php ob_end_flush(); ?>
