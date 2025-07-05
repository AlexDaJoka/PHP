<?php

include 'connect.php';

session_start();

if(isset($_SESSION['user_id'])){
$user_id = $_SESSION['user_id'];
}else{
$user_id = '';
};

if(isset($_POST['submit'])){

$email = $_POST['email'];
$email = filter_var($email, FILTER_SANITIZE_STRING);
$pass = sha1($_POST['pass']);
$pass = filter_var($pass, FILTER_SANITIZE_STRING);

$select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
$select_user->execute([$email, $pass]);
$row = $select_user->fetch(PDO::FETCH_ASSOC);

if($select_user->rowCount() > 0){
$_SESSION['user_id'] = $row['id'];
header('location:user_login.php');
}else{
$message[] = 'login unsuccessful';
}

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>login</title>
</head>
<style>
*{
    padding:0;
    margin:0;
    box-sizing:border-box;
}

.form-container{
display:flex;
flex-direction:column;
align-items:center;
padding:50px;
}

.form-container form{
    display:flex;
    flex-direction:column;
align-items:center;
justify-content:center;
    border:2px solid black;
    height:400px;
    width:400px;
    border-radius:30px;
}

.form-container form h3{
    position:relative;
    top:20px;
}

.form-container form .box{
margin:30px 0px;
border:1px solid black;
font-size:20px;
width:300px;
height:30px;
border-radius:20px;
}

.form-container form .btn{
margin:30px 0px;
border:1px solid black;
font-size:20px;
height:25px;
width:100px;
border-radius:20px;
box-shadow:0 0 10px 0 black;
transition:0.5s;
}
.form-container form .btn:hover{
box-shadow:0 0 0px 0 black;
}


.form-container form p{

}
.form-container form a{
text-decoration:none;
color:orange;
}

</style>
<body>

<?php
include 'user_header.php';
?>

<section class="form-container">

<form action="" method="POST">
<h2>Login</h2>
<h3>Email</h3>
<input type="email" required maxlength="50" name="email"
required placeholder="enter your email" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
<h3>Password</h3>
<input type="password" required maxlength="20" name="pass"
required placeholder="enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">

<input type="submit" value="login now" class="btn" name="submit">

<p>dont have an account</p>

<a href="user_register.php" class="option-btn">register now</a>

</form>

</section>


</body>
</html>
