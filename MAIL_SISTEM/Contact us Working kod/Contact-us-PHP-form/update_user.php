<?php

include 'connect.php';

session_start();

if(isset($_SESSION['user_id'])){
$user_id = $_SESSION['user_id'];
}else{
$user_id = '';
header('location:home.php;');
}

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    $update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ? WHERE id = ?");
    $update_profile->execute([$name, $email, $user_id]);

    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    $old_pass = $_POST['old_pass'];
    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $confirm_pass = sha1($_POST['confirm_pass']);
    $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

    if($old_pass == $empty_pass){
       $message[] = 'please enter old password!';
    }elseif($old_pass != $old_pass){
       $message[] = 'old password not matched!';
    }elseif($new_pass != $confirm_pass){
       $message[] = 'confirm password not matched!';
    }else{
       if($new_pass != $empty_pass){
          $update_admin_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
          $update_admin_pass->execute([$confirm_pass, $user_id]);
          $message[] = 'password updated successfully!';
       }else{
          $message[] = 'please enter a new password!';
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
    <title>update</title>
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
    height:700px;
    width:500px;
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
<h2>update</h2>
<h3>Name</h3>
<input type="text" required maxlength="20" name="name"
placeholder="enter your name" class="box" oninput="this.value = this.value.replace(/\s/g, '')"
value="<?= $fetch_profile['name'];?>">
<h3>Email</h3>
<input type="email" required maxlength="50" name="email"
placeholder="enter your email" class="box" oninput="this.value = this.value.replace(/\s/g, '')"
value="<?= $fetch_profile['email'];?>">
<h3>Old password</h3>
<input type="password" required maxlength="20" name="old_pass"
placeholder="enter your old password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
<h3>New password</h3>
<input type="password" maxlength="20" name="new_pass"
placeholder="enter your new password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
<h3>Confirm new password</h3>
<input type="password" maxlength="20" name="confirm_pass"
placeholder="confirm your new password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">


<input type="submit" value="update now" class="btn" name="submit">

</form>

</section>



</body>
</html>