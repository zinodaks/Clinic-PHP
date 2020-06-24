<?php
$user = $pass = "";
$loginErr = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    include "connect.php"; 
    $query = "select * from managers where username='$user'";
    if ($result = $link->query($query)) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($pass == $row['password']) {
                header("Location:index.php");
                $_SESSION['adminUsername'] = $user;
            } else  $loginErr = "Incorrect username/password";
        }
     }

    $query = "select * from patientlogin where patientuser='$user'";
    if ($result = $link->query($query)) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($pass == $row['password']) {
                header("Location:index.php");
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $user;
            } else  $loginErr = "Incorrect username/password";
        } else $loginErr = "Incorrect username/password";
    }
    if (isset($_POST['rememberme']) && isset($_SESSION['username'])) {
        setcookie("loggedin", true, time() + 60 * 60 * 24 * 30, '/');
        setcookie("username", $user, time() + 60 * 60 * 24 * 30, '/');
    } elseif (isset($_POST['rememberme']) && isset($_SESSION['adminUsername'])) {
        setcookie("admin", $user, time() + 60 * 60 * 24 * 30, '/');
    }
}
?>