<?php

session_start();
session_destroy();
unset($_SESSION['usuario']);
echo '<script>logout()</script>';
header("Location: login.php");
