<?php

$conn = mysqli_connect("localhost", "root","","pickandgo");
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST['Pick'])){
    $pickedId = $_POST['pickedId'];
    $orderId = $_POST['orderId'];
    $center_id = $_POST['center_id'];
    $weight = $_POST['weight'];
    $typeName = $_POST['typeName'];
    $sizeName = $_POST['sizeName'];
    $distanceType = $_POST['distanceType'];
    $totalPrice = $_POST['totalPrice'];
    $status = "PICKED";
  
        $sql = "INSERT INTO pickedup_items(picked_id, order_id, center_id, weight, type, size, distance	, price, status)
        VALUES ('$pickedId', '$orderId', '$center_id', '$weight', '$typeName', '$sizeName', '$distanceType', '$totalPrice', '$status')";
  
        if ($conn->query($sql) === TRUE) {
            
            echo '<script>alert("Package has been successfully picked up!")</script>';

        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
  
    header("location: index.php"); //return to
  }

?>