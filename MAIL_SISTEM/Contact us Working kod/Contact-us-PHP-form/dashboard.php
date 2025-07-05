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
    <title>dashboard</title>
    <script src="https://kit.fontawesome.com/edc2caccf4.js" crossorigin="anonymous" defer></script>
    <script src="/js/app.js"></script>
</head>
<style>
*{
padding:0;
margin:0;
box-sizing:border-box;
}

html{
overflow-x:hidden;
}

.dashboard{
flex-wrap:wrap;
top:0;
position:absolute;
left:300px;
display:flex;
}

.box{
 background:grey;
 margin:10px;
 color:black;
 width:100px;
 height:100px;
 border:1px solid black;
 border-radius:20px;
 box-shadow:0 10px 10px 0 black;
 transition:0.5s;
}

.box:hover{
    box-shadow:0 5px 0 0 black;
}

.box a{
text-decoration:none;
color:black;
font-weight:600;
}

.box h3{
    display:flex;
    align-items:center;
    justify-content:center;
    position:relative;
    top:10px;
}
.box p{
    display:flex;
    align-items:center;
    justify-content:center;
    position:relative;
    top:10px;
}

.btn{
    position:relative;
    left:10px;
    top:10px;
    width:70px;
    height:30px;
    background:green;
    border:1px solid black;
    border-radius:20px;
    transition:0.5s;
}
.btn:hover{
color:white;
}
</style>
<body>
<?php
include 'admin_header.php'
?>

<section class="dashboard">


<div class="box">
<?php
$select_users = $conn->prepare("SELECT * FROM `users`");
$select_users->execute();
$numbers_of_users = $select_users->rowCount();
?>
<h3><?= $numbers_of_users; ?></h3>
<p>users accounts</p>
<a href="users_accounts.php" class="btn">see users</a>
</div>

<div class="box">
<?php
$select_admins = $conn->prepare("SELECT * FROM `admins`");
$select_admins->execute();
$numbers_of_admins = $select_admins->rowCount();
?>
<h3><?= $numbers_of_admins; ?></h3>
<p>admins</p>
<a href="admin_accounts.php" class="btn">see admins</a>
</div>

<div class="box">
<?php
$select_messages = $conn->prepare("SELECT * FROM `messages`");
$select_messages->execute();
$numbers_of_messages = $select_messages->rowCount();
?>
<h3><?= $numbers_of_messages; ?></h3>
<p>new messages</p>
<a href="messages.php" class="btn">see messages</a>
</div>

</section>

</body>
</html>