<?php
    ob_start();
        session_start();
include_once 'dbconnect.php';
?>
<h6>hellooo</h6>
<?php
if(isset($_POST['post_name']) )
{
  $name=$_POST['post_name'];
 // $find_query = mysql_query("insert into ".$_SESSION['user']."likes values (".$paastid.")");
 $find_query = mysql_query("select * from users where user_name=".$name."");
 $count = mysql_num_rows($find_query);
 if($count==0){
  ?>
  <h2>Nobody Found by this name</h2>
 <?php
 }
 else{
  ?>
      <div id="all-friends">
                          <h4><?php echo $name ?></h4>
                          <input class="btn"  type="submit" value="Follow">

                       </div>

  <?php
  
exit;
}