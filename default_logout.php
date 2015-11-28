<?php
session_start();
require_once 'conn.php';

unset($_SESSION['username']);
unset($_SESSION['uid']);
unset($_SESSION['valid']);
echo "<meta http-equiv=refresh content=\"0;URL=./\">";exit;
?>