<?php

include 'connect.php';

session_start();

if(isset($_SESSION['user_id'])){
$user_id = $_SESSION['user_id'];
}else{
$user_id = '';
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<script src="https://kit.fontawesome.com/edc2caccf4.js" crossorigin="anonymous" defer></script>
    <title>all category</title>
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

.categories{
height:100vh;
}

.categories h1{
display:flex;
align-items:center;
justify-content:center;
}

.box-container{
padding:50px;
line-height:2em;
}

.box{
font-size:25px;
transition:0.5s;
box-shadow:0 0 0 0 black;
}

.box:hover{
box-shadow:0 2px 0 0 black;
}

.box a{
color:black;
text-decoration:none;
}

</style>
<body>

<?php include 'user_header.php'; ?>


<section class="categories">
<h1>all categories</h1>
<div class="box-container">


<div class="box"><span>1</span><a href="category.php?category=nature">nature</a></div>

<div class="box"><span>2</span><a href="category.php?category=music">music</a></div>

<div class="box"><span>3</span><a href="category.php?category=news">news</a></div>

<div class="box"><span>4</span><a href="category.php?category=travel">travel</a></div>

<div class="box"><span>5</span><a href="category.php?category=food">food</a></div>

<div class="box"><span>6</span><a href="category.php?category=comedy">comedy</a></div>

<div class="box"><span>7</span><a href="category.php?category=animals">animals</a></div>

<div class="box"><span>8</span><a href="category.php?category=animation">animation</a></div>

<div class="box"><span>9</span><a href="category.php?category=cars">cars</a></div>

<div class="box"><span>10</span><a href="category.php?category=sport">sport</a></div>


</div>

</section>


<?php include 'user_footer.php';?>
</body>
</html>