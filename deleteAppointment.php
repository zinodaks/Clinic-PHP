<?php 
session_start();

if(isset($_SESSION['username'])) {
$u = $_SESSION['username']; 
$cancelDate = $_POST['cancelAppointment'];
}
elseif(isset($_SESSION['adminUsername'])) {
    if(strlen($_POST['cancelAppointment']) != 0)
     $cancelDate = $_POST['cancelAppointment'];
    else {
        $cancelDate = $_POST['consult'];
    }
$cancelDate = explode('|' , $cancelDate);
$u = $cancelDate[0];
$cancelDate = $cancelDate[1];
}
include "connect.php";
$query = "delete from appointments where patientUser='$u' and date='$cancelDate' ; " ;
$link->query($query) ;
header("Location:appointment.php");
