<?php
session_start();
error_reporting(0);
if(!isset($_SESSION["auser"])){
	header("Location: ../global/login.php");
	die();
}

?>