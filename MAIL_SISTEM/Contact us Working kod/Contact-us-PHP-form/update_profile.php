<?php

include 'connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['submit'])){

    $update_profile_name = $_POST['name'];
    $update_profile_name = filter_var($name, FILTER_SANITIZE_STRING);
 
    $name = $conn->prepare("UPDATE `admins` SET name = ? WHERE id = ?");
    $name->execute([$name, $admin_id]);
 
    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    $prev_pass = $_POST['prev_pass'];
    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $confirm_pass = sha1($_POST['confirm_pass']);
    $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);
 
    if($old_pass == $empty_pass){
       $message[] = 'please enter old password!';
    }elseif($old_pass != $prev_pass){
       $message[] = 'old password not matched!';
    }elseif($new_pass != $confirm_pass){
       $message[] = 'confirm password not matched!';
    }else{
       if($new_pass != $empty_pass){
          $update_admin_pass = $conn->prepare("UPDATE `admins` SET password = ? WHERE id = ?");
          $update_admin_pass->execute([$confirm_pass, $admin_id]);
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
    <title>profile update</title>
    <script src="/js/app.js"></script>
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


html{
overflow-x:hidden;
}

body{

}
.form-container{
display:flex;
align-items:center;
justify-content:center;
position:absolute;
top:50px;
left:40vw;
}


.form-container form{
background:white;
height:600px;
border:1px solid black;
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

form a{
text-decoration:none;
display:flex;
align-items:center;
justify-content:center;
color:black;
}
</style>
<body>
<?php include 'admin_header.php'?>
<section class="form-container">


    <form action="" method="post" >
        <h3>Update profile</h3>
        <input type="hidden" name="prev_pass" value="<?= $fetch_profile['password']; ?>">

        <input type="text" name="name" 
        required placeholder="enter your username" maxlength="20" value="<?= $fetch_profile['name']; ?>"
        class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        
                <input type="password" name="old_pass" maxlength="20"
                placeholder="enter your old password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">

               <input type="password" name="new_pass" maxlength="20"
                placeholder="enter your new password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">

               <input type="password" name="confirm_pass" maxlength="20"
                placeholder="confirm your new password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">

<input type="submit" value="update now" name="submit" class="btn">
<a href="dashboard.php">Back</a>
    </form>
    
</section>
</body>
</html>