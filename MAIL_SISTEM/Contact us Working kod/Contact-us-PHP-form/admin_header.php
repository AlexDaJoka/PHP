<script src="https://kit.fontawesome.com/edc2caccf4.js" crossorigin="anonymous" defer></script>
<style>
*{
margin:0;
padding:0;
box-sizing:border-box;
}

:root{
--index: calc(1vw + 1vh);
}


header{
width:205px;
height:660px;
background:grey;
border:2px solid black;
}


.logo{
text-decoration:none;
color:black;
background:grey;
font-size:40px;
}

.flex .navbar a{
position:relative;
top:50px;
width:0px;
text-decoration:none;
color:black;
font-size:25px;
display:flex;
line-height:2em;
align-items:center;
justify-content:center;
border:1px solid grey;
transition:0.5s;
}

.flex .navbar a:hover{
border:1px solid black;
width:203px;
color:green;
}

.name{
color:black;
text-decoration:none;
position:relative;
left:60px;
top:-260px;
display:flex;
font-size:30px;
}

.profile{
border:1px solid black;
color:black;
position:relative;
left:220px;
top:-300px;
width:200px;
background:grey;
font-size:25px;
display:none;
}

.profile a{
text-decoration:none;
color:black;
display:flex;
align-items:center;
justify-content:center;
transition:0.5s;
}

.profile a:hover{
background:#333333;
}

.icons{

}


#menu-btn{
font-size:50px;
position:relative;
left:210px;
top:-340px;
transition:0.5s;
display:none;
}

#menu-btn:hover{
color:green;
}

#user-btn{
font-size:50px;
position:relative;
left:10px;
transition:0.5s;
top:-220px;
}

#user-btn:hover{
color:green;
}


</style>
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
<header>
  <section class="flex">

  <a href="dashboard.php" class="logo">Admin<span>Panel</span></a>

<nav class="navbar">
<a href="dashboard.php">home</a>
<a href="admin_accounts.php">admins</a>
<a href="users_accounts.php">users</a>
<a href="messages.php">messages</a>
</nav>

<div class="icons">
<div id="user-btn" class="fas fa-user"></div>
</div>

<div class="name">
          <?php
$select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
$select_profile->execute([$admin_id]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
?>
<p><?= $fetch_profile['name']; ?></p>
      </div>

<div class="profile" id="menu">
<a href="update_profile.php" class="update-btn">update profile</a>
<div class="flex-btn">
<a href="admin_login.php" class="option-btn">login</a>
<a href="register_admin.php" class="option-btn">register</a>
</div>
<a href="admin_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
</div>

  </section>
</header>
<script>
  document.getElementById('user-btn').addEventListener('click', function() {
  var menu = document.getElementById('menu');
  if (menu.style.display === 'block') {
    menu.style.display = 'none';
  } else {
    menu.style.display = 'block';
  }
});
</script>