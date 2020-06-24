<?php 
setcookie("loggedin" , true , time() - 3600 , "/" );
setcookie("username" , $user , time() - 3600 , "/");
setcookie("admin" , $user , time() - 3600 , "/");
session_start();
session_unset();
session_destroy();
header("Location:index.php");
