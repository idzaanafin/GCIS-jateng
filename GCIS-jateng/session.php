<?php
include('config.php');
session_start();
session_set_cookie_params(0, '/');
$user_check=$_SESSION['login_user'];
$ses_sql = mysqli_query($conn,"SELECT username FROM users WHERE username='$user_check'");
$row = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC);
$login_session = $row['username'];
if(!isset($_SESSION['login_user'])){
	header('location:loginpage.php');
	exit;
}

?>