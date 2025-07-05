<?php

include 'connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
header('location:admin_login.php');
}

if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];
    $delete_messages = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
    $delete_messages->execute([$delete_id]);
    header('location:messages.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>messages</title>
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

body h1{
    display:flex;
    align-items:center;
    justify-content:center;
    position:absolute;
    top:0;
    left:50%;
}

.messages{
    display:flex;
    align-items:center;
    justify-content:center;
    position:absolute;
    top:60px;
    left:20vw;
}

.box-container{
    display:flex;
    align-items:center;
    justify-content:center;
    flex-wrap:wrap;

}
.box{
    margin:20px 0px;
    border:1px solid black;
    width:600px;
    border-radius:20px;
    flex-wrap:wrap;
    font-size:25px;
    word-wrap:break-word;
}

.delete{
    text-decoration:none;
    color:black;
    border:1px solid black;
    width:100px;
    height:20px;
    transition:0.5s;
    border-radius:20px;
box-shadow:0 0px 10px 0 black;
}
.delete:hover{
    box-shadow:0 0px 5px 0 black;

}


</style>
<body>

<?php
include 'admin_header.php'
?>

<h1>new messages</h1>

<section class="messages">

<div class="box-container">

<?php

$select_messages = $conn->prepare("SELECT * FROM `messages`");
$select_messages->execute();
if($select_messages->rowCount() > 0){
while($fetch_messages = $select_messages->fetch(PDO::FETCH_ASSOC)){

?>
<div class="box">

<p> user id : <span><?= $fetch_messages['user_id']; ?></span></p>
<p> name : <span><?= $fetch_messages['name']; ?></span></p>
<p> number : <span><?= $fetch_messages['number']; ?></span></p>
<p> email : <span><?= $fetch_messages['email']; ?></span></p>
<p> message : <span><?= $fetch_messages['message']; ?></span></p>
<a href="messages.php?delete=<?=$fetch_messages['id']; ?>" onclick="return confirm('delete this message');" class="delete">delete</a>

</div>
<?php

}
}else{
echo '<p class="empty">you have no messages</p>';
}

?>

</div>

</section>

</body>
</html>