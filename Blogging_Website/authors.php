<?php

include 'connect.php';

session_start();

if(isset($_SESSION['user_id'])){
$user_id = $_SESSION['user_id'];
}else{
$user_id = '';
}

if(isset($_GET['author'])){
   $author = $_GET['author'];
}else{
   $author = '';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<script src="https://kit.fontawesome.com/edc2caccf4.js" crossorigin="anonymous" defer></script>
    <title>author posts</title>
</head>
<style>
*{
padding:0;
margin:0;
box-sizing:border-box;
}

body{
overflow-x:hidden;
}

.authors{
height:100vh;
}

.box-container{
display:flex;
align-items:center;
justify-content:center;
flex-wrap:wrap;
}

.box{
display:flex;
align-items:center;
justify-content:center;
flex-direction:column;
margin:20px;
border:2px solid black;
border-radius:20px;
width:250px;
}

</style>
<body>

<?php include 'user_header.php'; ?>

<section class="authors">

<h1>authors</h1>

<div class="box-container">

   <?php
      $select_author = $conn->prepare("SELECT * FROM `admin`");
      $select_author->execute();
      if($select_author->rowCount() > 0){
         while($fetch_authors = $select_author->fetch(PDO::FETCH_ASSOC)){

            $count_admin_posts = $conn->prepare("SELECT * FROM `posts` WHERE admin_id = ? AND status = ?");
            $count_admin_posts->execute([$fetch_authors['id'], 'active']);
            $total_admin_posts = $count_admin_posts->rowCount();

            $count_admin_likes = $conn->prepare("SELECT * FROM `likes` WHERE admin_id = ?");
            $count_admin_likes->execute([$fetch_authors['id']]);
            $total_admin_likes = $count_admin_likes->rowCount();

            $count_admin_comments = $conn->prepare("SELECT * FROM `comments` WHERE admin_id = ?");
            $count_admin_comments->execute([$fetch_authors['id']]);
            $total_admin_comments = $count_admin_comments->rowCount();
   ?>
<div class="box">
<p>author : <span><?= $fetch_authors['name']; ?></span></p>
<p>total posts : <span><?= $total_admin_posts; ?></span></p>
<p>total likes : <span><?= $total_admin_likes; ?></span></p>
<p>total comments : <span><?= $total_admin_comments; ?></span></p>
<a href="author_posts.php?author=<?= $fetch_authors['name']; ?>" class="btn">view posts</a>
</div>
<?php
}
}else{
echo '<p class="empty">no result</p>';
}
?>
</div>

</section>



<?php include 'user_footer.php';?>

</body>
</html>