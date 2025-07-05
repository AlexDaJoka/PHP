<?php

include 'connect.php';

session_start();

if(isset($_SESSION['user_id'])){
$user_id = $_SESSION['user_id'];
}else{
$user_id = '';
}

if(isset($_GET['author'])){
   $author = $_GET['author'];
}else{
   $author = '';
}

@include 'like_post.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<script src="https://kit.fontawesome.com/edc2caccf4.js" crossorigin="anonymous" defer></script>
    <title>author posts</title>
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


.posts-grid{
display:flex;
align-items:center;
justify-content:center;
flex-wrap:wrap;
padding:20px;
width:100vw;
}

.heading{
display:flex;
align-items:center;
justify-content:center;
}

.posts-grid form{
width:300px;
word-wrap:break-word;
border:1px solid black;
margin:20px;
}

form img{
width:100%;
}

.title{
display:flex;
align-items:center;
justify-content:center;
border-bottom:2px solid black;
font-size:20px;
}

.content{
font-size:20px;
line-height:1.5em;
padding:10px;
}

.inline-btn{
color:red;
text-decoration:none;
font-size:18px;
border-bottom:1px solid white;
transition:0.5s;
}

.inline-btn:hover{
border-bottom:1px solid black;
}

form a{

}

.admin-info a{
color:black;
text-decoration:none;
}


</style>
<body>

<?php include 'user_header.php'; ?>


<h1 class="heading">author posts</h1>
<section class="posts-grid">


<?php
$select_posts = $conn->prepare("SELECT * FROM `posts` WHERE name = ? AND status = ?");
$select_posts->execute([$author, 'active']);
if($select_posts->rowCount() > 0){
while($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)){
$post_id = $fetch_posts['id'];

$count_posts_comments = $conn->prepare("SELECT * FROM `comments` WHERE post_id = ?");
$count_posts_comments->execute([$post_id]);
$total_post_comments = $count_posts_comments->rowCount();

$count_posts_likes = $conn->prepare("SELECT * FROM `likes` WHERE post_id = ?");
$count_posts_likes->execute([$post_id]);
$total_post_likes = $count_posts_likes->rowCount();
?>
<form action="" method="POST">
<input type="hidden" name="post_id" value="<?= $post_id; ?>">
<input type="hidden" name="admin_id" value="<?= $fetch_posts['admin_id']; ?>">
<div class="admin">
<i class="fas fa-user"></i>
<div class="admin-info">
<a href="author_posts.php?authors=<?= $fetch_posts['name'];?>"><?= $fetch_posts['name'];?></a>
<p><?= $fetch_posts['date'];?></p>
</div>
</div>
<?php
if($fetch_posts['image'] != ''){
?>
<img src="uploaded_img/<?= $fetch_posts['image']; ?>">
<?php
}
?>
<div class="title"><?= $fetch_posts['title']; ?></div>
<div class="content"><?= $fetch_posts['content']; ?></div>
<a href="view_post.php?post_id=<?= $post_id; ?>" class="inline-btn">read more</a>
<a class="category" href="category.php?category=<?= $fetch_posts['category']; ?>"><i class="fas fa-tag"></i><span><?= $fetch_posts['category']; ?></span></a>
<div class="cl">
<a href="view_post.php?post_id=<?= $post_id; ?>"><i class="fas fa-comment"></i><span><?= $total_post_comments; ?></span></a>
<button type="submit" name="like_post" ><i class="fas fa-heart"></i><span><?= $total_post_likes; ?></span></button>
</div>
</form>
<?php
}
}else{
echo '<p class="empty">no result</p>';
}
?>

</section>


<?php include 'user_footer.php';?>

</body>
</html>