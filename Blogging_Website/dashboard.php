<?php

include 'connect.php';

session_start();


$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
header('location:admin_login.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<script src="https://kit.fontawesome.com/edc2caccf4.js" crossorigin="anonymous" defer></script>
    <title>dashboard</title>
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

.dashboard{
position:absolute;
top:50px;
left:250px;
}
.box-container{
    display:flex;
    flex-wrap:wrap;
}

.box{
    margin:10px;
    width:150px;
    height:150px;
    border:1px solid black;
    display:flex;
align-items:center;
justify-content:center;
flex-direction:column;
background:#c2c24a;
}

.box a{
text-decoration:none;
color:white;
font-size:22px;
transition:0.5s;
border-bottom:1px solid #c2c24a;
}

.box a:hover{
border-bottom:1px solid white;
}

.box p{
font-size:18px;
}
.box h3{
font-size:18px;
}
</style>    
<body>

<?php include 'admin_header.php'?>

<section class="dashboard">

<div class="box-container">

<div class="box">
<?php
$select_posts = $conn->prepare("SELECT * FROM `posts` WHERE admin_id = ?");
$select_posts->execute([$admin_id]);
$number_of_posts = $select_posts->rowCount();
?>
<h3><?= $number_of_posts; ?><h3>
    <p>posts added</p>
    <a href="add_posts.php" class="btn">add new post</a>
</div>

<div class="box">
<?php
$select_active_posts = $conn->prepare("SELECT * FROM `posts` WHERE admin_id = ? AND status = ?");
$select_active_posts->execute([$admin_id, 'active']);
$number_of_active_posts = $select_active_posts->rowCount();
?>
<h3><?= $number_of_active_posts; ?><h3>
    <p>active posts</p>
    <a href="view_posts.php" class="btn">view post</a>
</div>

<div class="box">
<?php
$select_deactive_posts = $conn->prepare("SELECT * FROM `posts` WHERE admin_id = ? AND status = ?");
$select_deactive_posts->execute([$admin_id, 'deactive']);
$number_of_deactive_posts = $select_deactive_posts->rowCount();
?>
<h3><?= $number_of_deactive_posts; ?><h3>
    <p>deactive posts</p>
    <a href="view_posts.php" class="btn">view post</a>
</div>

<div class="box">
<?php
$select_users = $conn->prepare("SELECT * FROM `users` ");
$select_users->execute();
$number_of_users = $select_users->rowCount();
?>
<h3><?= $number_of_users; ?><h3>
    <p>total users</p>
    <a href="users_accounts.php" class="btn">view users</a>
</div>

<div class="box">
<?php
$select_admins = $conn->prepare("SELECT * FROM `admin`");
$select_admins->execute();
$number_of_admins = $select_admins->rowCount();
?>
<h3><?= $number_of_admins; ?><h3>
    <p>total admins</p>
    <a href="admin_accounts.php" class="btn">view admins</a>
</div>

<div class="box">
<?php
$select_comments = $conn->prepare("SELECT * FROM `comments` WHERE admin_id = ?");
$select_comments->execute([$admin_id]);
$select_comments->execute();
$number_of_comments = $select_comments->rowCount();
?>
<h3><?= $number_of_comments; ?><h3>
    <p>total comments</p>
    <a href="comments.php" class="btn">view comments</a>
</div>

<div class="box">
<?php
$select_likes = $conn->prepare("SELECT * FROM `likes` WHERE admin_id = ?");
$select_likes->execute([$admin_id]);
$select_likes->execute();
$number_of_likes = $select_likes->rowCount();
?>
<h3><?= $number_of_likes; ?><h3>
    <p>total likes</p>
    <a href="view_posts.php" class="btn">view likes</a>
</div>

</div>

</section>

</body>
</html>