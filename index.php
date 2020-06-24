<?php
session_start();
if (isset($_COOKIE['loggedin']) && isset($_COOKIE['username'])) {
    $_SESSION['loggedin'] = $_COOKIE['loggedin'];
    $_SESSION['username'] = $_COOKIE['username'];
}
include "navbar.php";
?>
<style>
    .banner {
        width: 80%;
        margin: 6em auto;
    }

    .imageCont {
        background: url(calendar.png) no-repeat center center;
        background-size: cover;
        height: 100%;
        text-align: center;
    }

    .background {
        background: rgba(3, 121, 113, 0.6);
        padding-top: 2em;
    }

    .text {
        font-size: 28pt;
        color: white;
        padding: 1em;
    }

    .profileImageContainer {
        position: relative;
        width: 10%;
        margin: 0 auto;
    }

    .profileImage {
        width: 100px;
        height: 100px;
        border-radius: 50%;
    }

    .aboveImage {
        position: absolute;
        top: 40%;
        bottom: 50%;
        left: 0;
        right: 0;
        font-size: 12pt;
        color: black;
        background-color: rgba(0, 119, 204, 0.5);
        height: 20%;
        visibility: hidden;
        opacity: 0;
        margin: 0 auto;
        cursor: pointer;
        transition: opacity .2s, visibility .2s;
    }

    .profileImageContainer:hover .aboveImage {
        visibility: visible;
        opacity: 1;
    }

    .smallCont {
        margin-top: 2em;
        font-size: 20pt;
    }

    .buttons {
        margin-top: 2em;
    }

    .buttons a {
        display: inline-block;
        background-color: #FE5D26;
        width: 20em;
        padding: 1em;
        margin: 0.5em 0em;
        font-size: 14pt;
        cursor: pointer;
    }

    .buttons a:hover {
        background-color: rgb(254, 72, 15);
    }

    .promptBox {
        padding: 1em;
        width: 20%;
        margin: 0 auto;
        display: none;
        position: fixed;
        top: 50%;
        left: 40%;
        z-index: 100;
        background-color: white;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    form p {
        text-align: center;
        font-size: 14pt;
    }

    form input {
        margin: 0.5em;
    }

    .no {
        color: black;
        float: right;
        text-decoration: underline;
        cursor: pointer;
    }

    .stop-scrolling {
        height: 100%;
        overflow: hidden;
    }
</style>
<script>
    window.onload = function(load) {
        const promptBox = document.getElementsByClassName('promptBox');
        const cancelButton = document.getElementsByClassName('no');
        const changeButton = document.getElementsByClassName('aboveImage');

        if (changeButton[0] != null) {
            changeButton[0].addEventListener('click', function(e) {
                promptBox[0].style.display = "block";
            });
        }

        promptBox[0].addEventListener('click', function(a) {
            if (a.target.className == "no") {
                promptBox[0].style.display = "none";
            }
        });


    };
</script>
<div class="promptBox">
    <form action="uploadImage.php" method="post" enctype="multipart/form-data">
        <p> Select image to upload: </p>
        <input type="file" name="profilePicture" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit"><br>
        <a class="no">Cancel</a>
    </form>
</div>
<div class="banner">
    <div class="imageCont">
        <div class="background">
            <div class="text">
                <?php
                if (isset($_SESSION['adminUsername'])) {
                    echo " Welcome Dr. " . $_SESSION['adminUsername'] . " !" .
                        " <div class=\"smallCont\">
                  Manage your medical appointments to Infinity Center with complete ease !<br> Thank you for using us in order to book your appointments from the comfort of your seats and at the touch of your fingers.
                  </div> 
                  <div class=\"buttons\">
            <a href=\"/Project_1/appointment.php\">
                View appointments
            </a> </div> </div> ";
                } elseif (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                    echo " 
            <div class=\"profileImageContainer\">
            <img class=\"profileImage\" src=\"";
                    $files = glob('uploads/' . $_SESSION['username'] . '/*');
                    echo $files[0];
                    echo "\">
            <a class=\"aboveImage\">Change picture</a>
            </div> 
                Welcome " . $_SESSION['username'] . " !" .
                        " <div class=\"smallCont\">
                  Book your medical appointments to Infinity Center with complete ease !<br> Thank you for registering with us in order to book your appointments from the comfort of your seats and at the touch of your fingers.
                  </div> 
                  <div class=\"buttons\">
            <a href=\"/Project_1/appointment.php\" id=\"logIn\">
                Take an appointment
            </a> </div> </div> ";
                } else echo "
            Punctuality is the politeness of kings.
            <div class=\"smallCont\">
                Book your medical appointments to Infinity Center with complete ease !<br> Register with us in order to book your appointments from the comfort of your seats and at the touch of your fingers.
            </div>
        </div>
        <div class=\"buttons\">
            <a href=\"/login.php\" id=\"logIn\">
                Log in
            </a>
            <br>
            <a id=\"register\">
                Register
            </a>
        </div>
        "; ?>
            </div>
        </div>
    </div>
    <?php include "footer.php" ?>