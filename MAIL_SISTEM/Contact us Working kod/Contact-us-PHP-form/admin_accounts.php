<?php

include 'connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
header('location:admin_login.php');
}

if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];
    $delete_account = $conn->prepare("DELETE FROM `admins` WHERE id = ?");
    $delete_account->execute([$delete_id]);
    header('location:admin_accounts.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>admin accounts</title>
    <script src="https://kit.fontawesome.com/edc2caccf4.js" crossorigin="anonymous" defer></script>
    <script src="/js/app.js"></script>
</head>
<style>
*{
padding:0;
margin:0;
box-sizing:border-box;
}

html{
overflow-x:hidden;
}


body h1{
    display:flex;
    align-items:center;
    justify-content:center;
    position:absolute;
    top:0;
    left:50%;
}

.accounts{
    display:flex;
    align-items:center;
    justify-content:center;
    position:absolute;
    top:60px;
    left:20vw;
}

.box-container{
    display:flex;
    align-items:center;
    justify-content:center;
    flex-wrap:wrap;

}
.box{
    margin:0px 20px;
    text-align:center;
    border:1px solid black;
    width:200px;
    height:200px;
    border-radius:20px;
    font-size:25px;
}

.delete{
    position:relative;
    top:10px;
    text-decoration:none;
    color:black;
    border:1px solid black;
    width:100px;
    height:20px;
    transition:0.5s;
    border-radius:20px;
box-shadow:0 0px 10px 0 black;
}
.delete:hover{
    box-shadow:0 0px 5px 0 black;

}
</style>
<body>
<?php include 'admin_header.php' ?>

<h1>admin accounts</h1>

<section class="accounts">

<div class="box-container">

<div class="box">


<?php

$select_account = $conn->prepare("SELECT * FROM `admins`");
$select_account->execute();
if($select_account->rowCount() > 0){
while($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)){
?>
<div class="box">
<p>admin id : <?= $fetch_accounts['id']; ?></p>
<p>admin name : <?= $fetch_accounts['name']; ?></p>
<div class="flex-btn">

<a href="admin_accounts.php?delete=<?=$fetch_accounts['id']; ?>" onclick="return confirm('delete this accounts');" class="delete">delete</a>

<?php

if($fetch_accounts['id'] == $admin_id){

echo '<a href="update_profile.php" class="option-btn">update</a>';

}

?>
</div>
</div>
<?php
}
}else{
echo '<p class="empty">no accounts available</p>';
}

?>

</div>

</section>

</body>
</html>