<?php

include 'connect.php';

session_start();

if(isset($_SESSION['user_id'])){
$user_id = $_SESSION['user_id'];
}else{
$user_id = '';
}

if(isset($_POST['submit'])){

$email = $_POST['email'];
$email = filter_var($email, FILTER_SANITIZE_STRING);
$pass = sha1($_POST['pass']);
$pass = filter_var($pass, FILTER_SANITIZE_STRING);

$select_users = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
$select_users->execute([$email, $pass]);


if($select_users->rowCount() > 0){
$fetch_user_id = $select_users->fetch(PDO::FETCH_ASSOC);
$_SESSION['user_id'] = $fetch_user_id['id'];
header('location:home.php');
}else{
$message[] = 'incorrect email or password';
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
    <title>login</title>
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

.form-container{
    height:100vh;
    display:flex;
align-items:center;
justify-content:center;
flex-direction:column;
}

.form-log{
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

.box-l{
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
<form action="" method="POST" class="form-log">
<h3>login</h3>


<input type="text" required class="box-l" placeholder="enter your email" maxlength="50"
name="email" oninput="this.value = this.value.replace(/\s/g, '')">

<input type="password" required class="box-l" placeholder="enter your password" maxlength="50"
name="pass" oninput="this.value = this.value.replace(/\s/g, '')">

<input type="submit" name="submit" class="btn" value="login">

</form>

</section>

<?php include 'user_footer.php';?>

</body>
</html>