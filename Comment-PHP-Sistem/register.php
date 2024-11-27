<?php

include 'connect.php';

session_start();

if(isset($_SESSION['user_id'])){
$user_id = $_SESSION['user_id'];
}else{
$user_id = '';
}

if(isset($_POST['submit'])){

$name = $_POST['name'];
$name = filter_var($name, FILTER_SANITIZE_STRING);
$email = $_POST['email'];
$email = filter_var($email, FILTER_SANITIZE_STRING);
$pass = sha1($_POST['pass']);
$pass = filter_var($pass, FILTER_SANITIZE_STRING);
$cpass = sha1($_POST['cpass']);
$cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

$select_users = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
$select_users->execute([$email]);

if($select_users->rowCount() > 0){
$message[] = 'email already taken';
}else{
if($pass != $cpass){
$message[] = 'confirm password not matched';
}else{
$insert_user = $conn->prepare("INSERT INTO `users` (name, email, password) VALUES(?,?,?)");
$insert_user->execute([$name, $email, $cpass]);
$select_users = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
$select_users->execute([$email, $pass]);
$row = $select_users->fetch(PDO::FETCH_ASSOC);
if($select_users->rowCount() > 0){
$_SESSION['user_id'] = $row['id'];
}
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

.form-container{
    height:100vh;
    display:flex;
align-items:center;
justify-content:center;
flex-direction:column;
}

.form-reg{
 display:flex;
align-items:center;
justify-content:center;
flex-direction:column;
width:400px;
height:400px;
border:2px solid black;
border-radius:30px;
line-height:2em;
background:white;
}

.box-input{
    width:250px;
height:25px;
font-size:20px;
margin:20px 0px;
}

.btn{
width:250px;
height:25px;
margin:10px 0px;
transition:0.5s;
box-shadow:0px 5px 0px 0 grey;
border:1px solid grey;
}

.btn:hover{
box-shadow:0px 0px 0px 0px grey;
border:1px solid black;
}

.form-reg a{
color:black;
text-decoration:none;
}


</style>
<body>

<?php

if(isset($message)){
foreach($message as $message){
echo '
<div class="message">
    <span>'.$message.'</span>
    <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
</div>
      ';
}
}

?>

<?php include 'user_header.php'; ?>

<section class="form-container">
<form action="" method="POST" class="form-reg">
<h3>register</h3>

<input type="text" required class="box-input" placeholder="enter name" maxlength="50"
name="name" oninput="this.value = this.value.replace(/\s/g, '')">

<input type="email" required class="box-input" placeholder="enter email" maxlength="50"
name="email" oninput="this.value = this.value.replace(/\s/g, '')">

<input type="password" required class="box-input" placeholder="enter password" maxlength="50"
name="pass" oninput="this.value = this.value.replace(/\s/g, '')">

<input type="password" required class="box-input" placeholder="confirm password" maxlength="50"
name="cpass" oninput="this.value = this.value.replace(/\s/g, '')">

<input type="submit" name="submit" class="btn" value="register">

<a href="dashboard.php">Go back</a>

</form>

</section>

<?php include 'user_footer.php';?>
</body>
</html>