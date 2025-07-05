<?php

include 'connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
header('location:admin_login.php');
}

if(isset($_POST['submit'])){

$name = $_POST['name'];
$name = filter_var($name, FILTER_SANITIZE_STRING);
$pass = sha1($_POST['pass']);
$pass = filter_var($pass, FILTER_SANITIZE_STRING);
$cpass = sha1($_POST['cpass']);
$cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

$select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ?");
$select_admin->execute([$name]);


if($select_admin->rowCount() > 0){
$message[] = 'username already exist';
}else{
if($pass != $cpass){
$message[] = 'confirm password not matched';
}else{
$insert_admin = $conn->prepare("INSERT INTO `admin` (name, password) VALUES(?,?)");
$insert_admin->execute([$name, $cpass]);
$message[] = 'new admin added';
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
    <title>register</title>
</head>
<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    overflow-x:hidden;
    height:100vh;
        display:flex;
align-items:center;
justify-content:center;
background:#9dff00;
}

.form-container{
    display:flex;
align-items:center;
justify-content:center;
flex-direction:column;
}

form{
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

.box{
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

form a{
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



<section class="form-container">
<form action="" method="POST">
<h3>register</h3>

<input type="text" required class="box" placeholder="enter username" maxlength="20"
name="name" oninput="this.value = this.value.replace(/\s/g, '')">

<input type="password" required class="box" placeholder="enter password" maxlength="20"
name="pass" oninput="this.value = this.value.replace(/\s/g, '')">

<input type="password" required class="box" placeholder="confirm password" maxlength="20"
name="cpass" oninput="this.value = this.value.replace(/\s/g, '')">


<input type="submit" name="submit" class="btn" value="register">

<a href="dashboard.php">Go back</a>

</form>

</section>

</body>
</html>