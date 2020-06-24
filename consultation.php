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
    .appointContainer {
        width: 80%;
        margin: 0 auto;
        padding-top: 5em;
    }

    .appointContainer h1 {
        width: 30%;
        margin: 0 auto;
        padding-bottom: 2em;
    }

    .appointContainer hr {
        margin-bottom: 3em;
    }

    .insideBox {
        width: 70%;
        margin: 1em auto;
        background-color: rgb(245, 243, 248);
        padding: 1em;
    }

    .insideBox:nth-child(even),
    .m-insideBox:nth-child(even) {
        background-color: black;
    }

    .marker,
    .date,
    .medicineName,
    .usageDesc {
        display: inline;
        vertical-align: top;
    }

    .marker,
    .date,
    .medicineName {
        margin-right: 5em;
    }

    .marker {
        background-color: rgb(89 , 255 , 89);
        padding: 0.1em 0.6em;
        margin-left: 1em;
    }

    .usageDesc {
        width: 40%;
        display: inline-block;
    }
</style>
<div class="appointContainer">
    <h1>View all consultations</h1>
    <hr>
    <?php
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $query = "select * from consultations where patientUsername='$username'";
        include "connect.php";
        if ($result = $link->query($query)) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $consultDate = $row['date'];
                    echo "
                        <div id=\"appointments\">
            <div class=\"appointmentView\">
             <div class=\"insideBox\">
              <div class=\"marker\"></div>
              <div class=\"date\">$row[date]</div> ";
                    $q = "select consultationID from consultations where patientUsername='$username' AND date='$consultDate';";
                    $consultationID = (($link->query($q))->fetch_assoc())['consultationID'];
                    $q = "select prescriptionID from prescription where consultationID ='$consultationID';";
                    $prescriptionID = (($link->query($q))->fetch_assoc())['prescriptionID'];
                    $q = "select usageDesc from prescription where prescriptionID ='$prescriptionID';";
                    $usageDesc = (($link->query($q))->fetch_assoc())['usageDesc'];
                    $q = "select medicineID from prescription where prescriptionID = '$prescriptionID';";
                    $medicineID = (($link->query($q))->fetch_assoc())['medicineID'];
                    $q = "select medicineName from medicine where medicineID='$medicineID';";
                    $medicineName = (($link->query($q))->fetch_assoc())['medicineName'];
                    echo "<div class=\"medicineName\">$medicineName</div>
              <div class=\"usageDesc\">$usageDesc</div>
             </div>
            </div>
            </div>
            ";
                }
            }
        }
    }
    ?>
</div>
<?php include "footer.php";?>