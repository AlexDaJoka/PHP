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

   if(!empty($name)){
      $select_name = $conn->prepare("SELECT * FROM `users` WHERE name = ?");
      $select_name->execute([$name]);
      if($select_name->rowCount() > 0){
         $message[] = 'username already taken!';
      }else{
         $update_name = $conn->prepare("UPDATE `users` SET name = ? WHERE id = ?");
         $update_name->execute([$name, $user_id]);
      }
   }
      if(!empty($email)){
      $select_email = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
      $select_email->execute([$email]);
      if($select_email->rowCount() > 0){
         $message[] = 'email already taken!';
      }else{
         $update_email = $conn->prepare("UPDATE `users` SET email = ? WHERE id = ?");
         $update_email->execute([$email, $user_id]);
      }
   }

   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $select_old_pass = $conn->prepare("SELECT password FROM `users` WHERE id = ?");
   $select_old_pass->execute([$user_id]);
   $fetch_prev_pass = $select_old_pass->fetch(PDO::FETCH_ASSOC);
   $prev_pass = $fetch_prev_pass['password'];
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   if($old_pass != $empty_pass){
      if($old_pass != $prev_pass){
         $message[] = 'old password not matched!';
      }elseif($new_pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         if($new_pass != $empty_pass){
            $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
            $update_pass->execute([$cpass, $user_id]);
            $message[] = 'password updated successfully!';
         }else{
            $message[] = 'please enter a new password!';
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
    <title>update profile</title>
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

.form-up{
 display:flex;
align-items:center;
justify-content:center;
flex-direction:column;
width:400px;
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

.form-up a{
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
<form action="" method="POST" class="form-up">
<h3>update profile</h3>

<input type="text" class="box" placeholder="<?= $fetch_profile['name']; ?>" maxlength="50"
name="name" oninput="this.value = this.value.replace(/\s/g, '')">

<input type="email" class="box" maxlength="50" placeholder="<?= $fetch_profile['email']; ?>"
name="email" oninput="this.value = this.value.replace(/\s/g, '')">

<input type="password"  class="box" placeholder="enter your old password" maxlength="50"
name="old_pass" oninput="this.value = this.value.replace(/\s/g, '')">

<input type="password" class="box" placeholder="enter new password" maxlength="50"
name="new_pass" oninput="this.value = this.value.replace(/\s/g, '')">

<input type="password" class="box" placeholder="confirm password" maxlength="50"
name="cpass" oninput="this.value = this.value.replace(/\s/g, '')">


<input type="submit" name="submit" class="btn" value="update">

<a href="dashboard.php">Go back</a>

</form>


</section>

<?php include 'user_footer.php';?>

</body>
</html>