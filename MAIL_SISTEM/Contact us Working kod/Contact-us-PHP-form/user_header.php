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
width:100vw;
height:100px;
border:2px solid black;
background:white;
}



.flex .navbar{
  align-items:center;
  justify-content:center;
  display:flex;
  position:relative;
}

.flex .navbar a{
text-decoration:none;
margin:0px 20px;
color:black;
font-size:25px;
transition:0.5s;
}

.flex .navbar a:hover{
color:green;
box-shadow:0 0px 10px 0px black;
}

.user_name{
color:black;
text-decoration:none;
font-size:30px;
position:absolute;
top:60px;
right:200px;
}


.icons{

}



#user-btn{
font-size:50px;
position:absolute;
transition:0.5s;
top:10px;
right:200px;
}

#user-btn:hover{
color:green;
}

.u_menu{
position:absolute;
right:100px;
top:40px;
display:none;
background:white;
border:1px solid black;
}

.u_menu p{
width:200px;
}

.u_menu a{
  text-decoration:none;
  display:flex;
  justify-content:center;
  align-items:center;
  color:black;
  transition:0.5s;
}

.u_menu a:hover{
  color:green;
box-shadow:0 0px 10px 0px black;
}





.fa-shopping-cart{
text-decoration:none;
position:absolute;
top:30px;
right:150px;
font-size:30px;
color:black;
}
.fa-shopping-cart span{
text-decoration:none;
font-size:20px;
}

.profile{
position:absolute;
right:100px;
width:200px;
top:40px;
display:none;
background:white;
border:1px solid black;
}


.profile a{
font-size:25px;
  text-decoration:none;
  display:flex;
  justify-content:center;
  align-items:center;
  color:black;
  transition:0.5s;
}

.profile a:hover{
  color:green;
box-shadow:0 0px 10px 0px black;
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


<div class="icons">
<div id="user-btn" class="fas fa-user"></div>
</div>

<nav class="navbar">
<a href="contact.php">contact</a>
</nav>


<div class="user_name">
          <?php
$select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$select_profile->execute([$user_id]);
if($select_profile->rowCount() > 0){
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

?>
<p><?= $fetch_profile['name']; ?></p>
      </div>

<div class="profile" id="user_menu">
<a href="update_user.php" class="update-btn">update profile</a>
<div class="flex-btn">
<a href="user_login.php" class="option-btn">login</a>
<a href="user_register.php" class="option-btn">register</a>
</div>
<a href="user_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
<?php

}else{

?>

<div class="u_menu"  id="menu">
<p>please login first</p>
<a href="user_login.php" class="option-btn">login</a>
<a href="user_register.php" class="option-btn">register</a>
</div>
<?php
}
?>
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
<script>
  document.getElementById('user-btn').addEventListener('click', function() {
  var menu = document.getElementById('user_menu');
  if (menu.style.display === 'block') {
    menu.style.display = 'none';
  } else {
    menu.style.display = 'block';
  }
  });
</script>
