<?php

include 'connect.php';

session_start();

if (isset($_POST['submit'])){

$name = $_POST['name'];
$name = filter_var($name, FILTER_SANITIZE_STRING);

$pass = sha1($_POST['pass']);
$pass = filter_var($pass, FILTER_SANITIZE_STRING);

$select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ? AND password = ?");
$select_admin->execute([$name, $pass]);

if($select_admin->rowCount() > 0){
$fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
$_SESSION['admin_id'] = $fetch_admin_id['id'];
header('location:messages.php');
}else{
$message[] = 'incorrect username or password';
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

:root{
--index: calc(1vw + 1vh);
}

*::selection{
color:black;
background-color:#00b3ff;
}

::-webkit-scrollbar{
width:1rem;
height:.5rem;
}

::-webkit-scrollbar-track{
background-color:none;
}

::-webkit-scrollbar-thumb{
background-color:#00b3ff;
}

html{
font-size:calc(var(--index)*1.2);
overflow-x:hidden;
}

body{
height:100vh;
background:#ab66ff;
display:flex;
align-items:center;
justify-content:center;
}
section{
max-width:1200px;
margin:0 auto;
padding:2em;
}

.form-container form{
background:white;
height:400px;
border-radius:30px;
box-shadow:0px 20px 20px 0px black;
padding:2rem;
text-align:center;
}

.form-container form h3{
text-transform:uppercase;
}
.form-container form p{
line-height:2em;
color:grey;
}
.form-container form p span{
color:black;
}

.form-container form .box{
display:flex;
align-items:center;
justify-content:center;
width:450px;
height:60px;
margin:2em 0;
font-size:0.8em;
border:1px solid black;
border-radius:20px;
}

.btn{
position:relative;
top:-20px;
cursor:pointer;
height:50px;
width:200px;
border-radius:20px;
border:1px solid black;
transition:0.6s;
box-shadow:0 0 10px 0 black;
}

.btn:hover{
background:green;
box-shadow:0 0 0 0 black;
}

.flex-btn{
display:flex;
gap:1em;
}
.message{
position:sticky;
top:0;
max-width:1200px;
margin:0 auto;
background-color:white;
padding:2em;
display:flex;
align-items:center;
justify-content:space-between;
gap:1em;
}
.message span{
font-size:2em;
color:black;
}
.message i{
font-size:2.5em;
color:red;
cursor:pointer;
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

    <form action="" method="POST" >
        <h3>Login</h3>
        <p>default username = <span>admin</span> & password = <span>222</span></p>
        <input type="text" name="name" maxlength="20"
               required placeholder="enter your username" class="box" oninput="this.value = this.value.replace(/\s/g, '')">

                <input type="password" name="pass" maxlength="20"
               required placeholder="enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">

<input type="submit" value="login now" name="submit" class="btn">
    </form>

</section>
</body>
</html>