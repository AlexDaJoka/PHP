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
    <title>user accounts</title>
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

.accounts{
display:flex;
align-items:center;
justify-content:center;
flex-direction:column;
position:absolute;
top:50px;
left:35vw;
}

.box-container{
display:flex;
align-items:center;
justify-content:center;
flex-wrap:wrap;
}

.box{
border:1px solid black;
border-radius:20px;
width:200px;
display:flex;
align-items:center;
justify-content:center;
flex-direction:column;
margin:0px 20px;
height:150px;
line-height:1.5em;
}

.box p{
color:#00c8ff;
}

.box p span{
color:black;
}

.delete-btn{
width:120px;
height:20px;
border:1px solid black;
box-shadow:0 5px 5px 0 black;
transition:0.5s;
}

.delete-btn:hover{
box-shadow:0 0px 0px 0 black;
}

</style>
<body>

<?php include 'admin_header.php'?>

<section class="accounts">

<h1>user accounts</h1>

<div class="box-container">

<?php
$select_account = $conn->prepare("SELECT * FROM `users`");
$select_account->execute();
if($select_account->rowCount() > 0){
while($fetch_account = $select_account->fetch(PDO::FETCH_ASSOC)){
?>
<div class="box">
<p>id : <span><?= $fetch_account['id']; ?></span></p>
<p>username : <span><?= $fetch_account['name']; ?></span></p>
<p>user email : <span><?= $fetch_account['email']; ?></span></p>
</div>
<?php
}
}else{
echo '<p class="empty">no accounts found</p>';
}
?>
</div>

</section>


</body>
</html>