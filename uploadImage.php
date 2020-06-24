<?php
session_start();
$target_directory = "uploads/" . $_SESSION['username'] . "/";
$temp = explode(".", $_FILES["profilePicture"]["name"]);
$newFileName = $_SESSION['username'] . '.' . end($temp);
$target_file = $target_directory . $newFileName;
$uploadErr = "";
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg") {
    $check = getimagesize($_FILES['profilePicture']["tmp_name"]);
    if ($check !== false) {
        if ($_FILES["profilePicture"]["size"] > 2000000) {
            $uploadErr = "Your file is too large";
        } else {
            $files = glob('uploads/' . $_SESSION['username'] . '/*');
            foreach ($files as $file) {
                if (is_file($file))
                    unlink($file);
            }
        }
    }
} else {
    $uploadErr = "Invalid file type";
}
if ($uploadErr == "") {
    move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $target_file);
} 
header("Location:index.php");
?>
