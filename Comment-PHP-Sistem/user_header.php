<script src="https://kit.fontawesome.com/edc2caccf4.js" crossorigin="anonymous" defer></script>
<style>
*{
padding:0;
margin:0;
box-sizing:border-box;
}

body{
overflow-x:hidden;
}



.icons{
position:absolute;
right:30px;
top:20px;
font-size:30px;
color:black;
}

nav{
display:none;
position:absolute;
top:10%;
right:30px;
border:1px solid black;
width:200px;
line-height:1.5em;
align-items:center;
justify-content:center;
padding:20px;
}

nav a i{
transition:0.5s;
margin:0px 10px;
}


nav a:hover i{
margin:0px 0px;
font-size:23px;
}


nav a{
display:flex;
font-size:20px;
text-decoration:none;
color:black;
transition:0.5s;
}


.profile{
display:none;
position:absolute;
top:10%;
right:30px;
border:1px solid black;
width:200px;
line-height:1.5em;
align-items:center;
justify-content:center;
padding:20px;
}



.profile a{
display:flex;
font-size:20px;
text-decoration:none;
color:black;
transition:0.5s;
}

.profile p{
display:flex;
font-size:20px;
text-decoration:none;
color:black;
}

.profile a i{
transition:0.5s;
margin:0px 10px;
}


.profile a:hover i{
margin:0px 0px;
font-size:23px;
}

#search-btn{
display:none;
}


</style>
<header>

<section class="flex">

<div class="icons">
<div id="user-btn" class="fas fa-user"></div>

</div>

<a href="view_post.php">Comment</a>

<div class="profile" id="profile">
<?php
$select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$select_profile->execute([$user_id]);
if($select_profile->rowCount() > 0){
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
?>
<p><?= $fetch_profile['name']; ?></p>
<a href="user_logout.php" class="delete-btn" onclick="return confirm('logout from the web?')">logout</a>
<?php
}else{
?>
<div class="flex-btn">
<p>please login first</p>
<a href="login.php"><i class="fas fa-angle-right"></i><span>login</span></a>
<a href="register.php"><i class="fas fa-angle-right"></i><span>register</span></a>
</div>
<?php
}
?>
</div>

</section>
</header>


<script>
  document.getElementById('user-btn').addEventListener('click', function() {
  var menu = document.getElementById('profile');
  if (menu.style.display === 'block') {
    menu.style.display = 'none';
  } else {
    menu.style.display = 'block';
  }
});
</script>