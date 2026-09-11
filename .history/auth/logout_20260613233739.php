<?php
require_once '../config/config.php';
$_SESSION = [];
session_unset();
session_destroy();
header("Location: " . BASEURL . "auth/login.php");
exit;
?>