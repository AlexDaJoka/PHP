<?php

include 'connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
header('location:admin_login.php');
}

if(isset($_POST['delete_comment'])){
   $comment_id = $_POST['comment_id'];
   $comment_id = filter_var($comment_id, FILTER_SANITIZE_STRING);
   $delete_comment = $conn->prepare("DELETE FROM `comments`WHERE id = ?");
   $delete_comment->execute([$comment_id]);
   $message[] = 'comment deleted';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<script src="https://kit.fontawesome.com/edc2caccf4.js" crossorigin="anonymous" defer></script>
    <title>comments</title>
</head>
<style>
*{
    margin:0;
    padding:0;
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
position:absolute;
top:0;
left:25vw;
}

.box-container{
}

.comment-box{
width:60vw;
word-wrap:break-word;
padding:10px;
border:1px solid black;
line-height:1.5em;
margin:10px 0px;
}

.text{
border:1px solid black;
padding:10px;
}

</style>
<body>

<?php include 'admin_header.php'?>

<section class="comments">

<h2>All comments</h2>

<div class="box-container">

<?php
$select_comments = $conn->prepare("SELECT * FROM `comments` WHERE admin_id = ?");
$select_comments->execute([$admin_id]);
if($select_comments->rowCount() > 0){
while($fetch_comments = $select_comments->fetch(PDO::FETCH_ASSOC)){
?>
<div class="comment-box">
<?php
$select_posts = $conn->prepare("SELECT * FROM `posts` WHERE id = ?");
$select_posts->execute([$fetch_comments['post_id']]);
while($fetch_post = $select_posts->fetch(PDO::FETCH_ASSOC)){
?>
<div class="post-title"><span>from :</span><p><?= $fetch_post['title'];?></p>
<a href="read_post.php?post_id=<?= $fetch_post['id']?>">read post</a></div>
<?php
}
?>
<div class="user">

<i class="fas fa-user"></i>
<div class="user-info">
<span><?= $fetch_comments['user_name'];?><span>
<div><?= $fetch_comments['date'];?></div>
</div>
</div>
<div class="text"><?= $fetch_comments['comment'];?></div>
<form action="" class="icons" method="POST">
<input type="hidden" name="comment_id" value="<?= $fetch_comments['id'];?>">
<button type="submit" value="delete" name="delete_comment" onclick="return confirm('delete this comment');"
class="delete-comment"><i class="fas fa-trash"></i></button>
</form>
</div>
<?php
}
}else{
echo '<p class="empty">no comments added</p>';
}
?>
</div>

</section>


</body>
</html>