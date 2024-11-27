<?php

include 'connect.php';

session_start();

if(isset($_SESSION['user_id'])){
$user_id = $_SESSION['user_id'];
}else{
$user_id = '';
}

if(isset($_GET['post_id'])){

$get_id = $_GET['post_id'];

}else{
$get_id = '1';
}


if(isset($_POST['add_comment'])){

   $user_name = $_POST['user_name'];
   $user_name = filter_var($user_name, FILTER_SANITIZE_STRING);
   $comment = $_POST['comment'];
   $comment = filter_var($comment, FILTER_SANITIZE_STRING);

   $verify_comment = $conn->prepare("SELECT * FROM `comments` WHERE post_id = ? AND user_id = ? AND user_name = ? AND comment = ?");
   $verify_comment->execute([$get_id, $user_id, $user_name, $comment]);

   if($verify_comment->rowCount() > 0){
      $message[] = 'comment already added!';
   }else{
      $insert_comment = $conn->prepare("INSERT INTO `comments`(post_id, user_id, user_name, comment) VALUES(?,?,?,?)");
      $insert_comment->execute([$get_id, $user_id, $user_name, $comment]);
      $message[] = 'new comment added!';
   }

}

if(isset($_POST['edit_comment'])){

   $edit_comment_id = $_POST['edit_comment_id'];
   $edit_comment_id = filter_var($edit_comment_id, FILTER_SANITIZE_STRING);
   $edit_comment_box = $_POST['edit_comment_box'];
   $edit_comment_box = filter_var($edit_comment_box, FILTER_SANITIZE_STRING);

   $verify_edit_comment = $conn->prepare("SELECT * FROM `comments` WHERE id = ? AND comment = ?");
   $verify_edit_comment->execute([$edit_comment_id, $edit_comment_box]);

   if($verify_edit_comment->rowCount() > 0){
   $message[] = 'comment already added';
   }else{
   $update_comment = $conn->prepare("UPDATE `comments` SET comment = ? WHERE id = ?");
   $update_comment->execute([$edit_comment_box, $edit_comment_id]);
   $message[] = 'message edited';
   }

}

if(isset($_POST['delete_comment'])){

   $delete_comment_id = $_POST['comment_id'];
   $delete_comment_id = filter_var($delete_comment_id, FILTER_SANITIZE_STRING);

   $delete_comment = $conn->prepare("DELETE FROM `comments` WHERE id = ?");
   $delete_comment->execute([$delete_comment_id]);
   $message[] ='comment deleted';

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<script src="https://kit.fontawesome.com/edc2caccf4.js" crossorigin="anonymous" defer></script>
    <title>read post</title>
</head>
<style>
*{
padding:0;
margin:0;
box-sizing:border-box;
}

body{
overflow-x:hidden;
}



.comments{
display:flex;
align-items:center;
justify-content:center;
flex-direction:column;
padding:20px;
}

.comments .add-comment{
display:flex;
align-items:center;
justify-content:center;
flex-direction:column;
padding:20px;
border:2px solid black;
}

textarea{
width:80vw;
resize:none;
font-size:22px;
}

.inline-btn{
position:relative;
right:-30vw;
text-decoration:none;
font-size:18px;
border-bottom:1px solid white;
transition:0.3s;
box-shadow:0px 2px 0px 2px grey;
}

.inline-btn:hover{
box-shadow:0 0 0px 0 grey;
}

.show-comments{
border:1px solid black;
width:80vw;
margin:20px 0px;
}

.comment-box{
position:relative;
left:100px;
font-size:22px;
width:50vw;
word-wrap:break-word;
line-height:1.4em;
}

.edit-comment-box{
display:flex;
align-items:center;
justify-content:center;
flex-direction:column;
}

.edit-comment-box p{
font-size:30px;
}

.edit-comment-box form{
display:flex;
align-items:center;
justify-content:center;
flex-direction:column;
padding:20px;
border:2px solid black;
}

.comment-box2{
font-size:22px;
width:50vw;
word-wrap:break-word;
line-height:1.4em;
}

.btn{
width:200px;
height:25px;
border:1px solid black;
display:flex;
align-items:center;
justify-content:center;
flex-direction:column;
}

.edit-comment-box form a{
width:200px;
height:25px;
border:1px solid black;
display:flex;
align-items:center;
justify-content:center;
flex-direction:column;
color:black;
text-decoration:none;
}

</style>
<body>

<?php include 'user_header.php'; ?>

<?php
if(isset($_POST['open_edit_box'])){
$comment_id = $_POST['comment_id'];
$comment_id = filter_var($comment_id, FILTER_SANITIZE_STRING);
?>

<section class="edit-comment-box">
<p>edit your comment</p>
<?php
$select_edit_comment = $conn->prepare("SELECT * FROM `comments` WHERE id = ?");
$select_edit_comment->execute([$comment_id]);
$fetch_edit_comment = $select_edit_comment->fetch(PDO::FETCH_ASSOC);
?>
<form action="" method="POST">
<input type="hidden" name="edit_comment_id" value="<?= $fetch_edit_comment['id'];?>">
<textarea name="edit_comment_box" class="comment-box2" cols="30" rows="10" placeholder="enter comment"
 maxlength="1000"><?= $fetch_edit_comment['comment'];?></textarea>
<input type="submit" value="edit comment" class="btn" name="edit_comment">
<a href="view_post.php?post_id=<?= $get_id;?>">cancel edit</a>
</form>
</section>
<?php
}
?>


<section class="comments">

   <p class="comment-title">add comment</p>
   <?php
      if($user_id != ''){
         $select_admin_id = $conn->prepare("SELECT * FROM `comments` WHERE id = ?");
         $select_admin_id->execute([$user_id]);
         $fetch_admin_id = $select_admin_id->fetch(PDO::FETCH_ASSOC);
   ?>
   <form action="" method="post" class="add-comment">
      <input type="hidden" name="user_name" value="<?= $fetch_profile['name']; ?>">
      <p class="user"><i class="fas fa-user"></i><?= $fetch_profile['name']; ?></p>
      <textarea name="comment" maxlength="1000" cols="30" rows="10" placeholder="write your comment" required></textarea>
      <input type="submit" value="add comment" class="inline-btn" name="add_comment">
   </form>
   <?php
   }else{
   ?>
   <div class="add-comment">
      <p>please login to add or edit your comment</p>
      <a href="login.php" class="inline-btn">login now</a>
   </div>
   <?php
      }
   ?>

   <p class="comment-title">comments</p>
   <div class="user-comments-container">
      <?php
         $select_comments = $conn->prepare("SELECT * FROM `comments` WHERE post_id = ?");
         $select_comments->execute([$get_id]);
         if($select_comments->rowCount() > 0){
            while($fetch_comments = $select_comments->fetch(PDO::FETCH_ASSOC)){
      ?>
      <div class="show-comments" style="<?php if($fetch_comments['user_id'] == $user_id){echo 'order:-1;'; } ?>">
         <div class="comment-user">
            <i class="fas fa-user"></i>
            <div>
               <span><?= $fetch_comments['user_name']; ?></span>
               <div><?= $fetch_comments['date']; ?></div>
            </div>
         </div>
         <div class="comment-box" style="<?php if($fetch_comments['user_id'] == $user_id){echo 'color:var(--white); background:var(--black);'; } ?>"><?= $fetch_comments['comment']; ?></div>
         <?php
            if($fetch_comments['user_id'] == $user_id){
         ?>
         <form action="" method="POST">
            <input type="hidden" name="comment_id" value="<?= $fetch_comments['id']; ?>">
            <button type="submit" class="inline-option-btn" name="open_edit_box">edit comment</button>
            <button type="submit" class="inline-delete-btn" name="delete_comment" onclick="return confirm('delete this comment?');">delete comment</button>
         </form>
                  <?php
         }
         ?>
      </div>
      <?php
            }
         }else{
            echo '<p class="empty">no comments added yet!</p>';
         }
      ?>
   </div>

</section>


</body>
</html>