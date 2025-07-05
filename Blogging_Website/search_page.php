<?php

include 'connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
header('location:admin_login.php');
}

if(isset($_POST['delete'])){

   $post_id = $_POST['post_id'];
   $post_id = filter_var($p_id, FILTER_SANITIZE_STRING);
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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<script src="https://kit.fontawesome.com/edc2caccf4.js" crossorigin="anonymous" defer></script>
    <title>search page</title>
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



.show-posts{
position:absolute;
top:0px;
left:32vw;
display:flex;
align-items:center;
justify-content:center;
flex-direction:column;
}

.box-container{
display:flex;
align-items:flex-start;
flex-wrap:wrap;
}



.box{
margin:10px;
width:300px;
border:1px solid black;
padding:10px;

}

.box img{
width:100%;
}

.title{
width:300px;
display:flex;
flex-wrap:wrap;
}

.flex-btn{
}

.option-btn{
width:200px;
height:20px;
font-size:20px;
border:1px solid black;
text-decoration:none;
color:black;
}

.delete-btn{
cursor:pointer;
width:200px;
height:20px;
font-size:20px;
border:1px solid black;
text-decoration:none;
color:black;

}

.vbtn{
width:200px;
height:20px;
font-size:20px;
border:1px solid black;
text-decoration:none;
color:black;

}


.search-form{
width:48vw;
height:50px;
position:relative;
left:-115px;
}
.search-form input{
padding:10px;
font-size:20px;
width:43vw;
height:25px;
border:none;
}

.search-form button{
width:30px;
height:30px;
font-size:20px;
transition:0.5s;
}
.search-form button:hover{
font-size:22px;
}


</style>
<body>

<?php include 'admin_header.php'?>

<section class="show-posts">

<h1>search page</h1>

<form action="search_page.php" method="POST" class="search-form">

<input type="text" placeholder="search posts" required maxlength="100" name="search_box">
<button class="fas fa-search" name="search_btn" type="submit"></button>

</form>

<div class="box-container">
<?php
if(isset($_POST['search_box']) or isset($_POST['search_btn'])){
$search_box = $_POST['search_box'];
$select_posts = $conn->prepare("SELECT * FROM `posts` WHERE admin_id = ? AND
title LIKE '%{$search_box}%'");
$select_posts = $conn->prepare("SELECT * FROM `posts` WHERE admin_id = ?");
$select_posts->execute([$admin_id]);
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
<input type="hidden" name="post_id" value="<?= $post_id; ?>">
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
<div class="title"><?= $fetch_post['content'];?></div>
<div class="icons">
<div><i class="fas fa-comments"></i><span><?= $fetch_post_comments; ?></span></div>
<div><i class="fas fa-heart"></i><span><?= $fetch_post_likes; ?></span></div>
</div>
<div class="flex-btn">
<a href="edit_post.php?post_id=<?= $post_id; ?>" class="option-btn">edit</a>
<button type="submit" value="delete" name="delete" onclick="return confirm('delete this post');"
class="delete-btn">delete</button>
</div>
<a href="read_post.php?post_id=<?= $post_id; ?>" class="vbtn">view post</a>
</form>
<?php
}
}else{
echo '<p class="empty">no posts found</p>';
}
}
?>

</div>

</section>



</body>
</html>