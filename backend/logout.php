<?php
session_start();
session_destroy();
header("Location: ../global/login.php");
die();
?>