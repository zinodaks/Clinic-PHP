<?php session_start();
if (isset($_COOKIE['loggedin']) && isset($_COOKIE['username'])) {
    $_SESSION['loggedin'] = $_COOKIE['loggedin'];
    $_SESSION['username'] = $_COOKIE['username'];
}
?>
<style>
    html,
    body {
        margin: 0;
    }

    nav {
        background-color: #42a5f5;
        width: 100%;
        height: 4em;
        overflow: hidden;
        position: fixed;
        z-index: 999;
        top: 0;
        margin: 0;
    }

    .cont {
        width: 90%;
        margin: 0 auto;
        padding: 0;
    }

    .logo {
        display: inline-block;
        padding: 20px;
    }

    .logotext {
        font-size: 20pt;
        color: white;
        font-style: italic;
    }

    .orang {
        color: orange;

    }

    .nav-item {
        list-style-type: none;
        display: inline;
        padding: 20px 20px;
        font-size: 16pt;
        cursor: pointer;
    }

    a {
        text-decoration: none;
        color: white;
    }

    .nav-item:hover {
        border-bottom: 5px solid rgb(254, 72, 15);
        ;
    }

    .navbar {
        float: right;
        align-content: center;
    }
</style>
<nav>
    <div class="cont">
        <div class="container">
            <div class="logo">
                <div class="logotext">
                    Infinity <span class="orang">Center</span>
                </div>
            </div>
            <ul class="navbar">
                <a href="index.php">
                    <li class="nav-item">Home</li>
                </a>
                <?php
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true || isset($_SESSION['adminUsername'])) {
                    echo " <a href=\"appointment.php\">
                <li class=\"nav-item\">Appointment</li>
            </a>  ";
            if(isset($_SESSION['loggedin']))
            echo "
            <a href=\"consultation.php\">
            <li class=\"nav-item\">Consultations</li>
            </a> "; echo"
            <a href=\"logout.php\">
            <li class=\"nav-item\">Logout</li>
        </a> ";
                 } else
                    echo " <a href=\"login.php\">
                      <li class=\"nav-item\">Login</li>
                  </a>
                  <a href=\"register.php\">
                      <li class=\"nav-item\">Register</li>
                  </a>";
                ?>
            </ul>
        </div>
    </div>
</nav>