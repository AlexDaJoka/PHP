<?php

include 'connect.php';

session_start();

if(isset($_SESSION['user_id'])){
$user_id = $_SESSION['user_id'];
}else{
$user_id = '';
};

if(isset($_POST['send'])){

$name = $_POST['name'];
$name = filter_var($name, FILTER_SANITIZE_STRING);
$email = $_POST['email'];
$email = filter_var($email, FILTER_SANITIZE_STRING);
$number = $_POST['number'];
$number = filter_var($number, FILTER_SANITIZE_STRING);
$msg = $_POST['msg'];
$msg = filter_var($msg, FILTER_SANITIZE_STRING);

$select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");

$select_message->execute([$name, $email, $number, $msg]);

if($select_message->rowCount() > 0){
$message[] = 'message sent already';
}else{
    $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
    $insert_message->execute([$user_id, $name, $email, $number, $msg]);

    $message[] = 'sent message successfully!';
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>contact</title>
</head>
<style>
*{
    padding:0;
    margin:0;
    box-sizing:border-box;
}

.form-container{
padding:50px;
    display:flex;
    align-items:center;
    justify-content:center;
    flex-direction:column;
}

.form-container form{
    width:500px;
    border:1px solid black;
        display:flex;
    align-items:center;
    justify-content:center;
    flex-direction:column;
}

.form-container form input{
    font-size:20px;
    width:400px;
    margin:10px 0px;
    height:50px;
}

textarea{
    resize:none;
    min-width:400px;
    font-size:20px;
}

.btn{
    width:200px;
    height:50px;
    border:1px solid black;
    box-shadow:0 0 0 0 black;
    transition:0.5s;
}
.btn:hover{
    box-shadow:0 0 10px 0 black;

}
</style>
<body>

<?php
include 'user_header.php';
?>

<section class="form-container">
<h1>contact us</h1>
<form method="post" action="" class="box">


<input type="text" name="name" required placeholder="enter your name" maxlength="20" class="box" >

<input type="number" name="number" required placeholder="enter your number"
maxlength="99999999999" min="0" class="box" onkeypress="if(this.value.length == 10) return false;">

<input type="email" name="email" required placeholder="enter your email" maxlength="50" class="box" >
<textarea name="msg" cols="30" rows="10" required class="box" placeholder="enter your massage"></textarea>

<input type="submit" value="send message" class="btn" name="send">

</form>

</section>



</body>
</html>