<?php 

$searchQuery = $_GET['q'];

if(strlen($searchQuery) > 0 ) {
    include "connect.php";
    $query = "select medicineName from medicine where medicineName like '%$searchQuery%'";
    if($result = $link->query($query)) { 
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc())
          echo "<li>".$row['medicineName']."</li>";  
        } else {
          echo "No resuts found";
        }
    } 
}
