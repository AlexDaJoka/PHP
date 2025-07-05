<?php

include 'connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
header('location:admin_login.php');
}

if(isset($_POST['publish'])){

$name = $_POST['name'];
$name = filter_var($name, FILTER_SANITIZE_STRING);
$title = $_POST['title'];
$title = filter_var($title, FILTER_SANITIZE_STRING);
$content = $_POST['content'];
$content = filter_var($content, FILTER_SANITIZE_STRING);
$category = $_POST['category'];
$category = filter_var($category, FILTER_SANITIZE_STRING);
$status = 'active';

$image = $_FILES['image']['name'];
$image = filter_var($image, FILTER_SANITIZE_STRING);
$image_size = $_FILES['image']['size'];
$image_tmp_name = $_FILES['image']['tmp_name'];
$image_folder = 'uploaded_img/'.$image;

$select_image = $conn->prepare("SELECT * FROM `posts` WHERE image = ? AND admin_id = ?");
$select_image->execute([$image, $admin_id]);

if(isset($image)){
if($select_image->rowCount() > 0 AND $image != ''){
$message[] = 'image name repeated';
}elseif($image_size > 2000000){
$message[] = 'image is too large';
}else{
move_uploaded_file($image_tmp_name, $image_folder);
}
}else{
$image = '';
}

if($select_image->rowCount() > 0 AND $image != ''){
$message[] = 'please rename your image';
}else{
$insert_post = $conn->prepare("INSERT INTO `posts`(admin_id, name, title, content, category,
 image, status) VALUES(?,?,?,?,?,?,?)");
$insert_post->execute([$admin_id, $name, $title, $content, $category, $image, $status]);
$message[] = 'post published';
}

}

if(isset($_POST['draft'])){

$name = $_POST['name'];
$name = filter_var($name, FILTER_SANITIZE_STRING);
$title = $_POST['title'];
$title = filter_var($title, FILTER_SANITIZE_STRING);
$content = $_POST['content'];
$content = filter_var($content, FILTER_SANITIZE_STRING);
$category = $_POST['category'];
$category = filter_var($category, FILTER_SANITIZE_STRING);
$status = 'deactive';

$image = $_FILES['image']['name'];
$image = filter_var($image, FILTER_SANITIZE_STRING);
$image_size = $_FILES['image']['size'];
$image_tmp_name = $_FILES['image']['tmp_name'];
$image_folder = 'uploaded_img/'.$image;

$select_image = $conn->prepare("SELECT * FROM `posts` WHERE image = ? AND admin_id = ?");
$select_image->execute([$image, $admin_id]);

if(isset($image)){
if($select_image->rowCount() > 0 AND $image != ''){
$message[] = 'image name repeated';
}elseif($image_size > 2000000){
$message[] = 'image is too large';
}else{
move_uploaded_file($image_tmp_name, $image_folder);
}
}else{
$image = '';
}

if($select_image->rowCount() > 0 AND $image != ''){
$message[] = 'please rename your image';
}else{
$insert_post = $conn->prepare("INSERT INTO `posts`(admin_id, name, title, content, category,
 image, status) VALUES(?,?,?,?,?,?,?)");
$insert_post->execute([$admin_id, $name, $title, $content, $category, $image, $status]);
$message[] = 'draft saved';
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
    <title>add posts</title>
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

.post-editor{
display:flex;
align-items:center;
justify-content:center;
flex-direction:column;
position:absolute;
top:50px;
left:30vw;
}

form{
width:60vw;
border-radius:20px;
display:flex;
align-items:center;
justify-content:center;
flex-direction:column;
border:1px solid black;
line-height:2em;
font-size:22px;
}

.box{
width:250px;
height:25px;
font-size:20px;
}

textarea{
width:40vw;
height:50vh;
resize:vertical;
font-size:20px;
}

.pbtn{
width:150px;
height:25px;
border:0px solid grey;
transition:0.5s;
box-shadow:0 5px 0 0 grey;
}

.pbtn:hover{
box-shadow:0 0px 0 0 grey;
border:1px solid grey;
}

.option-btn{
width:150px;
height:25px;
border:0px solid grey;
transition:0.5s;
box-shadow:0 5px 0 0 grey;
}

.option-btn:hover{
box-shadow:0 0px 0 0 grey;
border:1px solid grey;
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

<?php include 'admin_header.php'?>

<section class="post-editor">

<h1>add post</h1>

<form action="" method="POST" enctype="multipart/form-data">

<input type="hidden" name="name" value="<?= $fetch_profile['name'];?>">
<p>post title<span>*</span></p>
<input type="text" class="box" name="title" required placeholder="add post title" maxlength="100">
<p>post content<span>*</span></p>
<textarea name="content" required maxlength="10000" placeholder="enter post content" cols="30" rows="10"></textarea>
<p>post category<span>*</span></p>
<select name="category" class="box" required>

<option value="" disabled selected>-- select post category</option>
<option value="nature">nature</option>
<option value="music">music</option>
<option value="news">news</option>
<option value="travel">travel</option>
<option value="food">food</option>
<option value="comedy">comedy</option>
<option value="animals">animals</option>
<option value="animation">animation</option>
<option value="cars">cars</option>
<option value="sport">sport</option>
</select>

<p>image</p>
<input type="file" name="image"
accept="image/jpg, image/jpeg, image/png, image/webp," class="box">

<div class="flex-btn">
<input type="submit" value="public post" name="publish" class="pbtn">
<input type="submit" value="save draft" name="draft" class="option-btn">
</div>

</form>

</section>



</body>
</html>