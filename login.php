<?php
session_start();
if (isset($_COOKIE['loggedin']) && isset($_COOKIE['username'])) {
    $_SESSION['loggedin'] = $_COOKIE['loggedin'];
    $_SESSION['username'] = $_COOKIE['username'];
}elseif(isset($_COOKIE['admin'])) {
    $_SESSION['adminUsername'] = $_COOKIE['admin'];
}
if ((isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) || isset($_SESSION['adminUsername'])) {
    header("Location:index.php");
} ?>
<style>
    .login {
        padding: 5em;
        text-align: center;
        margin-bottom: 3.5em;
    }

    #blood {
        width: 15%;
        margin-top: 3em;
        margin-bottom: 2em;
    }

    .login form {
        width: 50%;
        margin: 0 auto;
        text-align: center;
    }

    .input {
        width: 50%;
        padding: 0.5em 1em;
        margin: 0.5em;
    }

    #submit {
        border: none;
        cursor: pointer;
        font-size: 12pt;
        color: white;
        background-color: rgb(3, 116, 135);
    }

    #submit:hover {
        background-color: rgb(3, 112, 130);
    }

    .required {
        color: red;
        font-size: 12pt;
    }
</style>
<?php include "navbar.php"; ?>
<?php

include "loginFunction.php";
?>

<div class="login">
    <img id="blood" src="blood.png">
    <form action="login.php" method="post">
        <?php if ($loginErr != "") echo "<span class=\"required\"> * " . $loginErr . "</span>" ?>
        <br>
        <input class="input" type="text" name="username" placeholder="Username"> <br>
        <input class="input" type="password" name="password" placeholder="Password"> <br>
        <input class="input" id="submit" type="submit" value="Login">
        <br>
        <label id="rememberme">
            <input type="checkbox" value="remember" name="rememberme"> Remember Me
        </label>
    </form>
</div>
<?php include "footer.php" ?>