<?php
include("connect_db.php");
$user = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$_COOKIE[userid]'"));
if($user['ban'] == "1"){
	header("location:index.php");
	die();
} else {

setcookie('username');
setcookie('password');
setcookie('userid');
setcookie('sesija');

header("location:index.php");
}
?>