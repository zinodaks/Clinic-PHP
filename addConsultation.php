<?php
$user_Date = $_POST['consult'];
$user_Date = explode("|" , $user_Date);
$patient = $user_Date[0];
$date = $user_Date[1];
$inputError = "" ;
include "connect.php" ;

$medicineName = $_POST['medicine'];
if(strlen($medicineName) != 0) {
$query = "select medicineName from medicine where medicineName='$medicineName';";
if(!(($link->query($query))->num_rows > 0)){
    header("Location:appointment.php");
    die();
}
} else {
    header("Location:appointment.php");
    die();
}
$price = $_POST['price'];
if(strlen($price) == 0) {
    header("Location:appointment.php");
    die();
} else {
if($price < 0 ) {
    header("Location:appointment.php");
    die();
}
}
$usageDesc = $_POST['usageDesc'];
if(strlen($usageDesc) == 0) {
    header("Location:appointment.php");
    die();
}
    $query = "insert into consultations values(NULL ,'$patient' , '$date' , '$price');";
if($link->query($query)) { 
    include "deleteAppointment.php";
    $query = "select consultationID from consultations where patientUsername='$patient' AND date='$date';";
    $consultationID = (($link->query($query))->fetch_assoc())['consultationID'];
    $query = "select medicineID from medicine where medicineName='$medicineName';";
    $medicineID = (($link->query($query))->fetch_assoc())['medicineID'];
    $query = "insert into prescription values(NULL , '$consultationID' ,'$medicineID','$usageDesc');";
    if($link->query($query))
    header("Location:appointment.php");
} 

?>
