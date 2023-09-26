<?php
include "config.php" ;
session_start();
if($_SERVER['REQUEST_METHOD']=='POST'){

// get the post records
$username = str_replace(["#", "-","'",".",",","&"," ",],"",$_POST["username"]);
$password = str_replace(["#", "-","'",".",",","&"," ",],"",$_POST["password"]);
$sql = "SELECT * FROM users WHERE username='$username' and password='$password'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
$active = $row["active"];
$count = mysqli_num_rows($result);

if($count==1){
//	session_register("username");
	$_SESSION["login_user"]=$username;
	header("location: /admin.php");
}
else{
	$error='Username atau Password Anda salah';
}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Geographical Criminal Information System</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="loginpage.css">
</head>
<body>
     <!-- header -->
  <header class="header">
    <div class="container">
      <div class="logo">
        <img src="krimsus.png" alt="Logo">
      </div>
    <div class="title">
        <h1>DIREKTORAT RESERSE KRIMINAL KHUSUS POLDA JAWA TENGAH </h1>
        </div>
      </div>
    </header>
  <!-- login page -->
  <div class="nama">
  <h2>LOGIN</h2>
  </div>

  <div class="login">
    <h2>Login</h2>
  <form name='login' action='' method='post'>
    <div class="input-container">
      <label for="username">Username</label>
      <div class="icon-container">
        <img src="user.png" alt="User Icon">
      </div>
      <input type="text" id="username" name="username" placeholder="Enter your username" required>
    </div>
    <div class="input-container">
      <label for="password">Password</label>
      <div class="icon-container">
        <img src="lock.png" alt="Lock Icon">
      </div>
      <input type="password" id="password" name="password" placeholder="Enter your password" required>
    </div>
    <button type="submit" class="login-button">Login</button>
  </form>
	<?php echo $error; ?>
</div>

  

  <!-- Footer -->
  <footer>
    <h4>&copy; Copyright 
      2023-Developed by intern SMKN 7 Semarang</h4>
</footer>
</body>
</html>
