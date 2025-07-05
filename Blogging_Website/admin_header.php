<script src="https://kit.fontawesome.com/edc2caccf4.js" crossorigin="anonymous" defer></script>
<style>
*{
padding:0;
margin:0;
box-sizing:border-box;
}

header{
background:#9dff00;
border:1px solid black;
width:220px;
height:740px;
}

.logo{
font-size:40px;
text-decoration:none;
color:black;
}

.navbar{
      display:flex;
      flex-direction:column;
      line-height:2em;
font-size:22px;
}

.navbar a {
      text-decoration:none;   
      color:black; 
      transition:0.5s;
      font-size:18px;
}
.navbar a:hover {
      font-size:23px;
}


.navbar a i{
      padding:0px 20px;
      color:#c2c24a;
}

.profile{
padding:0px 10px;
}

.profile a{
display:flex;
align-items:center;
justify-content:center;
text-decoration:none;
color:black;
width:200px;
height:30px;
background:#c2c24a;
border:1px solid black;
font-size:20px;
transition:0.6s;
}
.profile a:hover{
      font-size:25px;
}
</style>
<header>
      
<a href="dashboard.php" class="logo">Admin<span>Panel</span></a>

<div class="profile">
      
<?php
         $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
         $select_profile->execute([$admin_id]);
         $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
      ?>

<p><?= $fetch_profile['name'];?></p>
<a href="admin_login.php" class="option-btn">login</a>
<a href="register_admin.php" class="option-btn">register</a>
<a href="update_profile.php" class="btn">update profile</a>
</div>

<nav class="navbar">
<a href="dashboard.php"><i class="fas fa-home"></i>Home</a>
<a href="add_posts.php"><i class="fas fa-pen"></i>add post</a>
<a href="view_posts.php"><i class="fas fa-eye"></i>view posts</a>
<a href="admin_accounts.php"><i class="fas fa-user"></i>accounts</a>
<a href="admin_logout.php" onclick="return confirm('logout from the website?');"><i class="fas fa-right-from-bracket"></i>logout</a>
</nav>


</header>