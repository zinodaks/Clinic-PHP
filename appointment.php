<?php
session_start();
if (isset($_COOKIE['loggedin']) && isset($_COOKIE['username'])) {
    $_SESSION['loggedin'] = $_COOKIE['loggedin'];
    $_SESSION['username'] = $_COOKIE['username'];
} elseif (isset($_COOKIE['admin'])) {
    $_SESSION['adminUsername'] = $_COOKIE['admin'];
}
include "navbar.php";
if ((!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) && (!isset($_SESSION['adminUsername']))) {
    header('Location:index.php');
}
?>
<style>
    form {
        margin: 5em;
    }

    textarea {
        resize: none;
        padding: 1em;
        margin-bottom: 2em;
    }

    #label {
        vertical-align: top;
        padding: 1em;
    }

    #label2 {
        padding: 1.5em;
    }

    #label,
    #label2 {
        margin: 1em;
    }

    .appointmentContainer {
        width: 50%;
        margin: 0 auto;
    }

    form h2 {
        text-align: center;
        margin-bottom: 2em;
    }

    #appointSubmit {
        text-align: center;
        border: none;
        width: 100%;
        padding: 0.5em;
        margin-top: 4em;
        margin-bottom: 0.5em;
    }

    #appointSubmit:hover {
        background-color: gray;
        cursor: pointer;
    }

    select {
        border-left-width: 0;
        border-right-width: 0;
        border-top-width: 0;
        border-bottom: 1px solid gray;
        width: 15%;
        padding: 0.5em;
        margin-right: 0.5em;
    }

    hr {
        width: 80%;
    }

    .error {
        color: red;
    }

    #closeIcon,
    #appointmentIcon {
        display: none;
        cursor: pointer;
        float: right;
        padding-left: 1em;
    }

    .insideBox:hover #closeIcon {
        display: inline-block;
    }

    .insideBox {
        width: 40%;
        margin: 1em auto;
        background-color: rgb(245, 243, 248);
        padding: 0.5em;
    }

    .insideBox:nth-child(even),
    .m-insideBox:nth-child(even) {
        background-color: black;
    }

    .marker,
    .date {
        display: inline;
        vertical-align: top;
    }

    .marker,
    .date {
        margin-right: 5em;
    }

    .marker {
        background-color: rgb(255 , 32 , 0);
        padding: 0.1em 0.6em;
        margin-left: 1em;
    }


    .symptoms {
        width: 40%;
        display: inline-block;
    }

    .promptBox {
        padding: 1em;
        display: none;
        width: 20%;
        margin: 0 auto;
        position: fixed;
        top: 50%;
        left: 40%;
        z-index: 100;
        background-color: white;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    .promptButtons button {
        width: 45%;
        margin: 0.2em;
    }

    .m-appointmentContainer {
        width: 80%;
        margin: 0 auto;
    }

    .allAppointments {
        margin-top: 3em;
    }

    .allAppointments h1 {
        width: 35%;
        margin: 0 auto;
        padding: 1em;
    }

    .m-insideBox {
        width: 60%;
        margin: 1em auto;
        background-color: rgb(245, 243, 248);
        padding: 1em;
    }

    .m-symptoms {
        width: 25%;
    }

    .m-patientName,
    .m-date,
    .m-symptoms {
        display: inline-block;
        vertical-align: top;
        margin-right: 5em;
    }

    .m-insideBox:hover #closeIcon {
        display: inline-block;
    }

    .m-insideBox:hover #appointmentIcon {
        display: inline-block;
    }

    .consultation {
        display: none;
        margin: 0 auto;
        position: fixed;
        padding: 2em;
        top: 40%;
        left: 27.5%;
        z-index: 100;
        background-color: white;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    .consultation input {
        padding: 0.5em;
    }

    .consultation button {
        width: 49.5%;
        margin-top: 2em;
        padding: 0.5em;
    }

    .dd-list {
        width: 33%;
    }

    #ls-list {
        list-style-type: none;
        text-indent: -2em;
    }

    #ls-list li {
        color: grey;
    }
</style>

<?php
$description = "";
$appointmentErr = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $description = $_POST['symptoms'];
    $year = $_POST['year'];
    $month = $_POST['month'];
    $day = $_POST['day'];
    $date = $year . "-" . $month . "-" . "$day";
    $isFirstVisit = "";

    include "connect.php";

    $query = "select * from appointments where patientUser='$username' ";
    if ($result = $link->query($query)) {
        if ($result->num_rows > 0) {
            $isFirstVisit = false;
        } else {
            $isFirstVisit = true;
        }
    }
    $query = "select * from appointments where patientUser='$username' and date='$date' ";
    if ($result = $link->query($query)) {
        if ($result->num_rows > 0) {
            $appointmentErr = "You have already scheduled an appointment on that day";
        }
    }
    if (strtotime(date("Y-m-d")) >= strtotime($date)) {
        $appointmentErr = "The appointment date you requested is in the past ";
    } elseif ($month == 2 && $day > 29) {
        $appointmentErr = "Invalid date";
    } elseif ($description == "") {
        $appointmentErr = "Please tell us about your symptoms";
    }
    if ($appointmentErr == "") {
        $query = "insert into appointments values('$username','$date' ,'$description' , '$isFirstVisit')";
        if ($result = $link->query($query))
            $description = "";
        unset($day);
        unset($month);
        unset($year);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Document</title>
</head>

<body>
    <script>
        window.onload = function(load) {
            const appointmentContainer = document.getElementById('appointments');
            const promptBox = document.getElementsByClassName('promptBox');
            const yesButton = promptBox[0].querySelectorAll('.promptButtons button')[0];
           
            var fileButton = "";
            var value;
            const consultationBox = document.getElementsByClassName('consultation');
            appointmentContainer.addEventListener('click', function(e) {
                if (e.target.className == "fa fa-times" || e.target.className == "fa fa-file") {
                    fileButton = ((e.target.parentElement).children)[5];
                    if (fileButton != null) {
                        value = fileButton.getAttribute('value') + '|' + (((e.target.parentElement).children)[4]).getAttribute('value');
                        if (e.target.className == "fa fa-file") {
                            const consultButton = document.getElementsByClassName('c-b')[0];
                            consultButton.setAttribute('value' , value);
                            consultationBox[0].style.display = "block";
                        }
                    } else
                        value = e.target.getAttribute('value');
                    if (e.target.className == "fa fa-times") {
                        yesButton.setAttribute('value', value);
                        promptBox[0].style.display = "block";
                    }

                }
            });
            promptBox[0].addEventListener('click', function(a) {
                if (a.target.className == "no") {
                    promptBox[0].style.display = "none";
                }
            });
            consultationBox[0].addEventListener('click', function(e) {
                if (e.target.className == "cancel") {
                    consultationBox[0].style.display = "none";
                } 
            });



        };

        function showResult(str) {
            if (str.length == 0) {
                document.getElementById("ls-list").innerHTML = "";
                document.getElementById("ls-list").style.display = "none";
                return;
            }

            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            }
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("ls-list").innerHTML = this.responseText;
                    document.getElementById("ls-list").style.display = "block";
                }
            }
            xmlhttp.open("GET", "livesearch.php?q=" + str, true);
            xmlhttp.send();
        }
    </script>
    <form class="promptBox" action="deleteAppointment.php" method="post">
        <p>Are you sure you want to cancel your appointment? </p>
        <div class="promptButtons">
            <button type="submit" name="cancelAppointment" value="">Yes</button>
            <button type="button" class="no">No</button>
        </div>
    </form>

    <form class="consultation" action="addConsultation.php" method="POST">
        <h3>Consult patient</h3>
        <div class="consultationFields">
            <?php if($_POST)if(strlen($inputError) != 0) echo "<span class=\"error\">".$inputError."</span> ";?>
            <input type="text" placeholder="Medicine" name="medicine" onkeyup="showResult(this.value)">
            <input type="number" placeholder="Price" name="price">
            <input type="text" placeholder="Usage Description" name="usageDesc">
            <br>
            <div class="dd-list">
                <ul id="ls-list">
                </ul>
            </div>
            <button class="c-b" name="consult" type="submit">Consult</button>
            <button class="cancel" type="button">Cancel</button>
        </div>
    </form>
    <div id="appointments">
        <?php if (isset($_SESSION['username'])) {
            echo "
            <div class=\"appointmentContainer\">
        <form id=\"appointment\" action=\"appointment.php\" method=\"POST\">
            <h2>Take an appointment</h2>
            <label id=\"label\" for=\"symptoms\">What are you feeling ?</label>
            <textarea rows=\"5\" cols=\"30\" name=\"symptoms\" placeholder=\"Description\">";
            echo $description;
            echo "</textarea>
            <br>
            <label id=\"label2\" for=\"day\">Appointment Date : </label>
            <select name=\"day\">
                <option selected=\"selected\" value=\"\">Day</option>";

            $i;
            for ($i = 1; $i <= 31; $i++) {
                echo "<option ";
                if (isset($day) && $day == $i) echo "selected ";
                echo "value=\"$i\">$i</option>\n";
            }
            echo "
            </select>
            <select name=\"month\">
                <option selected=\"selected\" value=\"\">Month</option>\n<option ";
            if (isset($month) && $month == "1") echo "selected ";
            echo "value=\"1\">January</option>\n<option ";
            if (isset($month) && $month == "2") echo "selected ";
            echo "value=\"2\">February</option>\n<option ";
            if (isset($month) && $month == "3") echo "selected ";
            echo "value=\"3\">March</option>\n<option ";
            if (isset($month) && $month == "4") echo "selected ";
            echo "value=\"4\">April</option>\n<option ";
            if (isset($month) && $month == "5") echo "selected ";
            echo "value=\"5\">May</option>\n<option ";
            if (isset($month) && $month == "6") echo "selected ";
            echo "value=\"6\">June</option>\n<option ";
            if (isset($month) && $month == "7") echo "selected ";
            echo "value=\"7\">July</option>\n<option ";
            if (isset($month) && $month == "8") echo "selected ";
            echo "value=\"8\">August</option>\n<option ";
            if (isset($month) && $month == "9") echo "selected ";
            echo "value=\"9\">September</option>\n<option ";
            if (isset($month) && $month == "10") echo "selected ";
            echo "value=\"10\">October</option>\n<option ";
            if (isset($month) && $month == "11") echo "selected ";
            echo "value=\"11\">November</option>\n<option ";
            if (isset($month) && $month == "12") echo "selected ";
            echo "value=\"12\">December</option>
            </select>
            <select name=\"year\">
                <option selected=\"selected\" value=\"\">Year</option> <option ";
            if (isset($year) && $year == "2021") echo "selected ";
            echo "value=\"2021\">2021</option> <option ";
            if (isset($year) && $year == "2020") echo "selected ";
            echo "value=\"2020\">2020</option> <option ";
            if (isset($year) && $year == "2019") echo "selected ";
            echo "value=\"2019\">2019</option>
            </select>
            <br>
            <input id=\"appointSubmit\" type=\"submit\" value=\"Take Appointment\">";
            if ($appointmentErr != "") echo "<span class=\"error\"> *  $appointmentErr </span><br>";
            echo "</form>";
        } elseif (isset($_SESSION['adminUsername'])) {
            echo " 
        <div class=\"m-appointmentContainer\">

         <div class=\"allAppointments\">
         <h1> Manage All Appointments </h1>

         </div>
         </div>
        ";
            $query = "select * from appointments";
            include "connect.php";

            if ($result = $link->query($query)) {
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "
                        
            <div class=\"m-appointmentView\">
             <div class=\"m-insideBox\">
              <div class=\"marker\"></div>
              <div class=\"m-patientName\">$row[patientUser]</div>
              <div class=\"m-date\">$row[date]</div>
              <div class=\"m-symptoms\">$row[symptomsDescription]</div>
              <i id=\"closeIcon\" class=\"fa fa-times\"  value=\"$row[date]\"></i>
              <i id=\"appointmentIcon\" class=\"fa fa-file\" value=\"$row[patientUser]\"></i>
             </div>
            </div>
            ";
                    }
                }
            }
        } ?>
    </div>

    <hr>

    <?php
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $zeroAppoints = "";
        $query = "select * from appointments where patientuser='$username'";
        include "connect.php";
        if ($result = $link->query($query)) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "
                        <div id=\"appointments\">
            <div class=\"appointmentView\">
             <div class=\"insideBox\">
              <div class=\"marker\"></div>
              <div class=\"date\">$row[date]</div>
              <div class=\"symptoms\">$row[symptomsDescription]</div>
              <i id=\"closeIcon\"class=\"fa fa-times\"  value=\"$row[date]\"></i>
             </div>
            </div>
            </div>
            ";
                }
            }
        }
    }
    ?>

    <?php include "footer.php"; ?>
</body>

</html>