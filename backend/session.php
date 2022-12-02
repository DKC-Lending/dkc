<?php
session_start();
error_reporting(0);
if(!isset($_SESSION["cuser"])){
	header("Location: ../global/login.php");
	die();
}

?>