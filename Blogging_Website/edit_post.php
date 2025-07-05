<?php

include 'connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
header('location:admin_login.php');
}

if(!isset($_GET['post_id'])){
header('location:view_posts.php');
}else{
$get_id = $_GET['post_id'];
}

if(isset($_POST['save'])){

$post_id = $get_id;
$title = $_POST['title'];
$title = filter_var($title, FILTER_SANITIZE_STRING);
$content = $_POST['content'];
$content = filter_var($content, FILTER_SANITIZE_STRING);
$category = $_POST['category'];
$category = filter_var($category, FILTER_SANITIZE_STRING);
$status = $_POST['status'];
$status = filter_var($status, FILTER_SANITIZE_STRING);

$update_post = $conn->prepare("UPDATE `posts` SET title = ?, content = ?, category = ?, status = ? WHERE id = ?");
$update_post->execute([$title, $content, $category, $status, $get_id]);

$message[] = 'post updated';

$old_image = $_POST['old_image'];
$old_image = filter_var($old_image, FILTER_SANITIZE_STRING);
$image = $_FILES['image']['name'];
$image = filter_var($image, FILTER_SANITIZE_STRING);
$image_size = $_FILES['image']['size'];
$image_tmp_name = $_FILES['image']['tmp_name'];
$image_folder = 'uploaded_img/'.$image;

$select_image = $conn->prepare("SELECT * FROM `posts` WHERE image = ? AND admin_id = ?");
$select_image->execute([$image, $admin_id]);

if(!empty($image)){
if($select_image->rowCount() > 0 AND $image != ''){
$message[] = 'image name repeated';
}elseif($image_size > 2000000){
$message[] = 'please rename image';
}else{
$update_image = $conn->prepare("UPDATE `posts` SET image = ? WHERE id = ?");
$update_image->execute([$image, $post_id]);
move_uploaded_file($image_tmp_name, $image_folder);
$message[] = 'image updated';
if($old_image != $image AND $old_image != ''){
unlink('../uploaded_img'.$old_image);
}
}
}else{
$image = '';
}

}


if(isset($_POST['delete'])){

   $post_id = $_POST['post_id'];
   $post_id = filter_var($post_id, FILTER_SANITIZE_STRING);
   $delete_image = $conn->prepare("SELECT * FROM `posts` WHERE id = ?");
   $delete_image->execute([$post_id]);
   $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);
   if($fetch_delete_image['image'] != ''){
      unlink('../uploaded_img/'.$fetch_delete_image['image']);
   }
   $delete_post = $conn->prepare("DELETE FROM `posts` WHERE id = ?");
   $delete_post->execute([$post_id]);
   $delete_comments = $conn->prepare("DELETE FROM `comments` WHERE post_id = ?");
   $delete_comments->execute([$post_id]);
header('location:view_posts.php');

}

if(isset($_POST['delete_image'])){

   $empty_image = '';
   $post_id = $_POST['post_id'];
   $post_id = filter_var($post_id, FILTER_SANITIZE_STRING);
   $delete_image = $conn->prepare("SELECT * FROM `posts` WHERE id = ?");
   $delete_image->execute([$post_id]);
   $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);
   if($fetch_delete_image['image'] != ''){
      unlink('../uploaded_img/'.$fetch_delete_image['image']);
   }
   $unset_image = $conn->prepare("UPDATE `posts` SET image = ? WHERE id = ?");
   $unset_image->execute([$empty_image, $post_id]);
   $message[] = 'image deleted successfully!';

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<script src="https://kit.fontawesome.com/edc2caccf4.js" crossorigin="anonymous" defer></script>
    <title>edit post</title>
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

.delete-btn{
cursor:pointer;
width:200px;
height:20px;
font-size:20px;
border:1px solid black;
text-decoration:none;
color:black;
}

.delete{
width:150px;
height:25px;
border:0px solid grey;
transition:0.5s;
box-shadow:0 5px 0 0 grey;
}

.delete:hover{
box-shadow:0 0px 0 0 grey;
border:1px solid grey;
}

.image{
width:100%;
height:300px;
}

.btn{
color:black;
text-decoration:none;
}

</style>
<body>

<?php include 'admin_header.php'?>

<section class="post-editor">

<h1>edit post</h1>
<?php
$select_posts = $conn->prepare("SELECT * FROM `posts` WHERE admin_id = ?
AND id = ?");
$select_posts->execute([$admin_id, $get_id]);
if($select_posts->rowCount() > 0){
while($fetch_post = $select_posts->fetch(PDO::FETCH_ASSOC)){
?>
<form action="" method="POST" enctype="multipart/form-data">

<input type="hidden" name="post_id" value="<?= $fetch_post['id'];?>">
<input type="hidden" name="old_image" value="<?= $fetch_post['image'];?>">
<input type="hidden" name="name" value="<?= $fetch_profile['name'];?>">
<p>post status</p>

<select name="status" id="" class="box" required >
<option value="<?= $fetch_post['status']; ?>" selected><?= $fetch_post['status'];?></option>
<option value="active">active</option>
<option value="deactive">deactive</option>
</select>

<p>post title<span>*</span></p>
<input type="text" class="box" name="title" required placeholder="add post title" maxlength="100" value="<?= $fetch_post['title'];?>">
<p>post content<span>*</span></p>
<textarea name="content" required maxlength="10000" placeholder="enter post content" cols="30" rows="10"><?= $fetch_post['content'];?></textarea>
<p>post category<span>*</span></p>
<select name="category" class="box" required>

<option value="<?= $fetch_post['category'];?>"><?= $fetch_post['category'];?></option>
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
<?php

if($fetch_post['image'] != ''){

?>
<img src="../uploaded_img/<?= $fetch_post['image'];?>" class="image">
<input type="submit" value="delete_image" name="delete_image" class="delete-btn">
<?php
}
?>
<div class="flex-btn">
<input type="submit" value="save post" name="save" class="pbtn">
<a href="view_posts.php" class="btn">go back</a>
<button type="submit" value="delete" name="delete" onclick="return confirm('delete this post');"
class="delete">delete</button>
</div>

</form>
<?php
}
}else{
echo '<p class="empty">no posts added</p>';
}
?>
</section>


</body>
</html>