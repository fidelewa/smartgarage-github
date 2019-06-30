<?php
ob_start();
session_start();
session_unset();
session_destroy();
// header('Location: admin.php');
header('Location: my_sign_pointage.php');
?>