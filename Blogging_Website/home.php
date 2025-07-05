<?php

include 'connect.php';

session_start();

if(isset($_SESSION['user_id'])){
$user_id = $_SESSION['user_id'];
}else{
$user_id = '';
}

include 'like_post.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<script src="https://kit.fontawesome.com/edc2caccf4.js" crossorigin="anonymous" defer></script>
    <title>home</title>
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

.home-grid{
display:flex;
align-items:center;
justify-content:center;
padding:20px;
}

.box{
margin:20px 0px;
width:100vw;
line-height:2em;
}

.box a{
text-decoration:none;
font-size:20px;
color:black;
flex-wrap:wrap;
padding:0px 20px;
border-bottom:1px solid white;
transition:0.5s;
}

.box a:hover{
border-bottom:1px solid black;
}

.box p{
font-size:40px;
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

.view-btn{
display:flex;
align-items:center;
justify-content:center;
}

.view-btn a{
width:200px;
height:25px;
font-size:40px;
}

</style>
<body>

<?php include 'user_header.php'; ?>

<section  class="home-grid">

<div class="box">

<div class="posts-info">
<?php
$select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$select_profile->execute([$user_id]);
if($select_profile->rowCount() > 0){
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

$count_user_comments = $conn->prepare("SELECT * FROM `comments` WHERE user_id = ? ");
$count_user_comments->execute([$user_id]);
$total_user_comments = $count_user_comments->rowCount();

$count_user_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ? ");
$count_user_likes->execute([$user_id]);
$total_user_likes = $count_user_likes->rowCount();


?>
            <a href="user_likes.php" class="option-btn"><?= $total_user_likes; ?> liked posts</a>
            <a href="user_comments.php" class="option-btn"><?= $total_user_comments; ?> commented posts</a>
<?php
}else{
?>
<?php
}
?>
</div>

<div class="box">
<p>categories</p>
<div class="flex-box">
<a href="category.php?category=nature">nature</a>
<a href="category.php?category=music">music</a>
<a href="category.php?category=news">news</a>
<a href="category.php?category=travel">travel</a>
<a href="category.php?category=food">food</a>
<a href="category.php?category=comedy">comedy</a>
<a href="category.php?category=animals">animals</a>
<a href="category.php?category=animation">animation</a>
<a href="category.php?category=cars">cars</a>
<a href="category.php?category=sport">sport</a>
<a href="all_category.php">view all</a>
</div>
</div>

<div class="box">
<p>authors</p>
<div class="flex-box">
<?php
$select_authors = $conn->prepare("SELECT DISTINCT name FROM `admin` LIMIT 10");
$select_authors->execute();
if($select_authors->rowCount() > 0){
while($fetch_authors = $select_authors->fetch(PDO::FETCH_ASSOC)){

?>
<a href="author_posts.php?author=<?= $fetch_authors['name'];?>"><?= $fetch_authors['name'];?></a>
<?php
}
}else{
echo '<p class="empty">no authors found</p>';
}
?>
<a href="authors.php">view all</a>
</div>
</div>

</div>
</section>
<h1 class="heading">latest posts</h1>
<section class="posts-grid">


<?php
$select_posts = $conn->prepare("SELECT * FROM `posts` WHERE status = ? LIMIT 6");
$select_posts->execute(['active']);
if($select_posts->rowCount() > 0){
while($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)){
$post_id = $fetch_posts['id'];

$count_posts_comments = $conn->prepare("SELECT * FROM `comments` WHERE post_id = ?");
$count_posts_comments->execute([$post_id]);
$total_post_comments = $count_posts_comments->rowCount();

$count_posts_likes = $conn->prepare("SELECT * FROM `likes` WHERE post_id = ?");
$count_posts_likes->execute([$post_id]);
$total_post_likes = $count_posts_likes->rowCount();

$confirm_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ? AND post_id = ? ");
$confirm_likes->execute([$user_id, $post_id]);
?>
<form action="" method="POST">
<input type="hidden" name="post_id" value="<?= $post_id; ?>">
<input type="hidden" name="admin_id" value="<?= $fetch_posts['admin_id']; ?>">
<div class="admin">
<i class="fas fa-user"></i>
<div class="admin-info">
<a href="author_posts.php?author=<?= $fetch_posts['name'];?>"><?= $fetch_posts['name'];?></a>
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
<button type="submit" name="like_post" ><i class="fas fa-heart" style="<?php if($confirm_likes->rowCount() > 0){ echo 'color:var(--red);'; } ?> "></i><span><?= $total_post_likes; ?></span></button>
</div>
</form>
<?php
}
}else{
echo '<p class="empty">no posts found</p>';
}
?>

<div class="view-btn">
<a href="posts.php">view all</a>
</div>
</section>


<?php include 'user_footer.php';?>

<script>
document.querySelectorAll('.posts-grid form .content').forEach(content =>{
if(content.innerHTML.length > 150) content.innerHTML = content.innerHTML.slice(0, 100);
})
</script>
</body>
</html>