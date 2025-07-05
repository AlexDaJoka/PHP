<?php

include 'connect.php';

session_start();

if(isset($_SESSION['user_id'])){
$user_id = $_SESSION['user_id'];
}else{
$user_id = '';
};

if(isset($_POST['submit'])){

$name = $_POST['name'];
$name = filter_var($name, FILTER_SANITIZE_STRING);
$email = $_POST['email'];
$email = filter_var($email, FILTER_SANITIZE_STRING);
$pass = sha1($_POST['pass']);
$pass = filter_var($pass, FILTER_SANITIZE_STRING);
$cpass = sha1($_POST['cpass']);
$cpass = filter_var($cpass, FILTER_SANITIZE_STRING);


$select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
$select_user->execute([$email]);
$row = $select_user->fetch(PDO::FETCH_ASSOC);

if($select_user->rowCount() > 0){
$message[] = 'user already exist';
}else{

if($pass != $cpass){
$message[] = 'confirm password not matched';
}else{
$insert_user = $conn->prepare("INSERT INTO `users` (name, email, password) VALUES(?,?,?);");
$insert_user->execute([$name, $email, $cpass]);
$message[] = 'registered success';
}

}

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>register</title>
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
    height:600px;
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
<h2>register</h2>
<h3>Name</h3>
<input type="text" required maxlength="20" name="name"
placeholder="enter your name" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
<h3>Email</h3>
<input type="email" required maxlength="50" name="email"
placeholder="enter your email" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
<h3>Password</h3>
<input type="password" required maxlength="20" name="pass"
required placeholder="enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
<h3>Confirm password</h3>
<input type="password" required maxlength="20" name="cpass"
required placeholder="confirm your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">


<input type="submit" value="register now" class="btn" name="submit">

<p>already have an account</p>

<a href="user_login.php" class="option-btn">login now</a>

</form>

</section>


</body>
</html>