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

header{
background:black;
color:white;
display:flex;
align-items:center;
justify-content:center;
width:100vw;
}

.flex{
padding:20px;
}
.flex .logo{
position:absolute;
left:20px;
font-size:30px;
letter-spacing:3.5px;
color:white;
text-decoration:none;
transition:1s;
width:20vw;
}
.flex .logo:hover{
transform:rotateY(360deg);
}

.search-form{
position:relative;
left:12px;
}

.search-form input{
width:40vw;
height:25px;
font-size:18px;
}


.search-form button{
font-size:20px;
height:26px;
width:50px;
background:white;
transition:0.5s;
border:1px solid black;
box-shadow:0 0 0 0 white;
}

.search-form button:hover{
box-shadow:0 0 10px 0 white;
}

.icons{
position:absolute;
right:30px;
top:20px;
font-size:30px;
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

<a href="home.php" class="logo">Blogging Web</a>

<form action="search.php" class="search-form" method="POST">

<input type="text" name="search_box" placeholder="search posts" maxlength="100" required>
<button type="submit" class="fas fa-search" name="search_btn"></button>

</form>

<div class="icons">

<div id="menu-btn" class="fas fa-bars"></div>
<div id="search-btn" class="fas fa-search"></div>
<div id="user-btn" class="fas fa-user"></div>

</div>

<nav id="menu">

<a href="home.php"><i class="fas fa-angle-right"></i><span>Home</span></a>
<a href="posts.php"><i class="fas fa-angle-right"></i><span>Posts</span></a>
<a href="all_category.php"><i class="fas fa-angle-right"></i><span>Categories</span></a>
<a href="authors.php"><i class="fas fa-angle-right"></i><span>authors</span></a>

</nav>

<div class="profile" id="profile">
<?php
$select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$select_profile->execute([$user_id]);
if($select_profile->rowCount() > 0){
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
?>
<p><?= $fetch_profile['name']; ?></p>
<a href="update.php">update profile</a>
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
  document.getElementById('menu-btn').addEventListener('click', function() {
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
  var menu = document.getElementById('profile');
  if (menu.style.display === 'block') {
    menu.style.display = 'none';
  } else {
    menu.style.display = 'block';
  }
});
</script>