<?php

include 'connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
header('location:admin_login.php');
}

if(!isset($_GET['post_id'])){
header('location:view_posts.php');
}else{
$get_id = $_GET['post_id'];
}

if(isset($_POST['delete'])){

   $post_id = $_POST['post_id'];
   $post_id = filter_var($post_id, FILTER_SANITIZE_STRING);
   $delete_image = $conn->prepare("SELECT * FROM `posts` WHERE id = ?");
   $delete_image->execute([$post_id]);
   $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);
   if($fetch_delete_image['image'] != ''){
      unlink('../uploaded_img/'.$fetch_delete_image['image']);
   }
   $delete_post = $conn->prepare("DELETE FROM `posts` WHERE id = ?");
   $delete_post->execute([$post_id]);
   $delete_comments = $conn->prepare("DELETE FROM `comments` WHERE post_id = ?");
   $delete_comments->execute([$post_id]);
   $message[] = 'post deleted';

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
    <title>read post</title>
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

header{
position:absolute;
top:0;
left:0;
}


.read-post{
        display:flex;
align-items:center;
justify-content:center;
padding:50px;
position:relative;
left:13vw;
}

.status{
width:100px;
height:25px;
position:absolute;
top:0;
left:54px;
}


form{
width:50vw;
line-height:2em;
height:100vh;
}

.image{
width:45vw;
height:45vh;
}


.title_a{
width:45vw;
word-wrap:break-word;
}

.flex-btn{
display:flex;
align-items:center;
justify-content:space-between;
}

.option-btn{
display:flex;
align-items:center;
justify-content:center;
width:200px;
height:25px;
border:1px solid black;
box-shadow:0 0px 0px 0 black;
transition:0.5s;
}

.option-btn:hover{
box-shadow:0 0px 5px 0 black;
}

.delete-btn{
width:200px;
height:25px;
border:1px solid black;
cursor:pointer;
box-shadow:0 0px 0px 0 black;
transition:0.5s;
}

.delete-btn:hover{
box-shadow:0 0px 5px 0 black;
}

.flex-btn a{
display:flex;
align-items:center;
justify-content:center;
width:200px;
height:25px;
border:1px solid black;
text-decoration:none;
color:black;
box-shadow:0 0px 0px 0 black;
transition:0.5s;
}

.flex-btn a:hover{
box-shadow:0 0px 5px 0 black;
}

.comments{
display:flex;
align-items:center;
justify-content:center;
flex-direction:column;
position:relative;
left:13vw;
}

.box-container{
display:flex;
align-items:center;
justify-content:center;
}

.box{
}


.user{
}

.comment-box{

}

.user i{
font-size:40px;
}

.user-info div{
font-size:20px;
}

.text{
word-wrap:break-word;
width:60vw;
}

.delete-comment{
font-size:30px;
}

</style>
<body>

<?php include 'admin_header.php'?>

<section class="read-post">

<?php
$select_posts = $conn->prepare("SELECT * FROM `posts` WHERE id = ? AND admin_id = ?");
$select_posts->execute([$get_id, $admin_id]);
if($select_posts->rowCount() > 0){
while($fetch_post = $select_posts->fetch(PDO::FETCH_ASSOC)){
$post_id = $fetch_post['id'];

$count_post_comments = $conn->prepare("SELECT * FROM `comments` WHERE post_id = ?");
$count_post_comments->execute([$post_id]);
$fetch_post_comments = $count_post_comments->rowCount();

$count_post_likes = $conn->prepare("SELECT * FROM `likes` WHERE post_id = ?");
$count_post_likes->execute([$post_id]);
$fetch_post_likes = $count_post_likes->rowCount();
?>
<form action="" class="box" method="POST">

<?php
if($fetch_post['image'] != ''){
?>
<img src="/uploaded_img/<?= $fetch_post['image'];?>" class="image">
<?php
}
?>
<div class="status"
style="background:<?php if($fetch_post['status'] == 'active')
{echo 'limegreen';}else{echo 'coral';}?>">
<?= $fetch_post['status'];?></div>

<div class="title"><?= $fetch_post['title'];?></div>
<div class="title_a"><?= $fetch_post['content'];?></div>
<div class="icons">
<div><i class="fas fa-comments"></i><span><?= $fetch_post_comments; ?></span></div>
<div><i class="fas fa-heart"></i><span><?= $fetch_post_likes; ?></span></div>
<div class="title"><i class="fas fa-tag"></i><span><?= $fetch_post['category'];?></span></div>
</div>
<div class="flex-btn">
<a href="edit_post.php?post_id=<?= $post_id; ?>" class="option-btn">edit</a>
<button type="submit" value="delete" name="delete" onclick="return confirm('delete this post');"
class="delete-btn">delete</button>
<a href="view_posts.php">Go back</a>
</div>
</form>
<?php
}
}else{
echo '<p class="empty">no posts added</p>';
}
?>
<div>
</section>

<section class="comments">

<h2>post comments</h2>

<div class="box-container">

<?php
$select_comments = $conn->prepare("SELECT * FROM `comments` WHERE post_id = ?");
$select_comments->execute([$get_id]);
if($select_comments->rowCount() > 0){
while($fetch_comments = $select_comments->fetch(PDO::FETCH_ASSOC)){
?>
<div class="comment-box">

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