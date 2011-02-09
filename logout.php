<?
session_start();

if(isset($_SESSION['email'])){
	unset($_SESSION['email']);
}
header('Location: main_login.php');

//session_destroy();
//session_unset();
?>
