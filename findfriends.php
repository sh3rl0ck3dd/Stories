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
  <link rel="stylesheet" type="text/css" href="friend.css"/>

</head>

<body >
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
  <div class =" container below-navbar">
    <div id="friend-form">
     <!--  <form method="post"  autocomplete="on" onsubmit="return find_frinds();">

        <div class="col-md-12">

          <div class="form-group">
            <h2 class="">Socialise</h2>
          </div>

          <div class="form-group">
            <hr />
          </div>
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
              <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" maxlength="50"  />
            </div>
          </div>


          <div class="form-group">
            <hr />
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-block btn-primary" name="btn-friend">FIND</button>
          </div>

          <div class="form-group">
            <hr />
          </div>



        </div>

      </form> -->  
      <table>
  
        
                  <?php
          $counter=0;
          $names_pick = mysql_query("select user_name,user_dp from users");
          while($row2=mysql_fetch_array($names_pick)){
            $ownername=$row2['user_name'];
            $ownerdp=$row2['user_dp'];
            $tablename=mysql_query("select user_name from users where user_id=".$_SESSION['user']."" );
            $row3 = mysql_fetch_array($tablename);
            $session_name=$row3['user_name'];
            


            
            $is_friend=mysql_query("select * from ".$session_name."  where friend_name='".$ownername."' " );
                      //$is_friend=mysql_query("select * from ".$_SESSION['user']."likes where likedposts=6 " );

            $count_rows = mysql_num_rows($is_friend);
            if($count_rows==0){
             $likecolor='';
             $text='follow';
           }
           else{
            $likecolor='btn-primary';
            $text='unfollow';
          }     

          ?>
          
          
          <tr ><td style="padding: 4px;" >
             <img class="my-image-size" src="<?php echo $ownerdp;?>"  />
            </td>
            <td style="padding-left:20px;">
            <div id="all_friends<?php echo $counter?>"   > 

              <p class="ownername"><?php echo $ownername;?>     </p></td>
              
              <td style="padding: 5px;"><form method='post' action="" onsubmit="return post_follow('<?php echo $counter ?>');">
                <div class="form-group input-group">
                  <input type="hidden" id="pstd<?php echo $counter?>" value=<?php echo $ownername ?>>
                  <input type="hidden" id="rowss<?php echo $counter?>" value=<?php echo $count_rows ?>>
                  

                  <input id="bttn<?php echo $counter?>" class="btn <?php echo $likecolor ?> "  type="submit" value="<?php echo $text ?>">
                
              </form>
                </td>
              
            </tr>
            <?php
            $counter++;

          }    


          ?>
      </div>

        </table>


      <script type="text/javascript">
      function find_friends()
      {
        var name = document.getElementById("name").value;
        
        if(name)
        {
          $.ajax
          ({
            type: 'post',
            url: 'find_friends.php',
            data: 
            {
             post_name:name,
             
           },
           success: function (response) 
           {
            document.getElementById("all-friends").innerHTML=response+document.getElementById("all-friends").innerHTML;
            

          }
        });
        }

        return false;
      }
      function post_follow(var1){
        var fllow = document.getElementById("pstd"+var1).value;
        var clor = document.getElementById("rowss"+var1).value;



        if(clor==0)
        {
                  // console.log("in iff functionn");

                  $.ajax
                  ({
                    type: 'post',
                    url: 'post_follow.php',


                    data: 

                    {

                     post_name:fllow,

                   },
                   success: function (response) 
                   {

                    document.getElementById("bttn"+var1).classList.toggle('btn-primary');
                    document.getElementById("bttn"+var1).value = "unfollow";
                    



                  }
                });
                  clor=1;
                }
                else{
                 $.ajax
                 ({
                  type: 'post',
                  url: 'post_unfollow.php',


                  data: 

                  {

                   post_name:fllow,

                 },
                 success: function (response) 
                 {

                  document.getElementById("bttn"+var1).classList.toggle('btn-primary');
                  document.getElementById("bttn"+var1).value = "follow";




                }
              });
                 clor=0;
               }

               return false;



             }
             
             </script>    
           </body>
           </html>