<?php

$conn = mysqli_connect("localhost", "root","","pickandgo");
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
// Insert completed deliveries
if(isset($_POST['Complete'])){
    $orderIdtxt = $_POST['orderIdtxt'];
    $arriverId = $_POST['arriverId'];
    $pickedId = $_POST['pickedId'];
    $loadId = $_POST['loadId'];
    $routId = $_POST['routId'];
    $centreID = $_POST['centreID'];
    $empId = $_POST['empId'];
    $signatureURL = $_POST['signatureURL'];
    $photo = $_POST['photo'];
    $status = "COMPLETED";
    
    $sql = "INSERT INTO completed_deliveries(arrived_id, order_id, picked_id, load_id, route_id, emp_id, signature_url, photo_url , status)
    VALUES ('$arriverId', '$orderIdtxt', '$pickedId', '$loadId', '$routId', '$empId', '$signatureURL', '$photo', '$status')";

  
        if ($conn->query($sql) === TRUE) {
    
            header("location: indexCompl.php"); //return to        
            echo '<script>alert("successful!")</script>';

        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
  
  }

//Update images
if(isset($_POST['updateImages'])){

  $signature= $_POST['signatureURL'];
  $photo = $_POST['photo'];

      $tsql = "UPDATE completed_deliveries SET signature_url='$signature', photo_url='$photo'";

      if ($conn->query($tsql) === TRUE) {

        $_SESSION['message'] = "Record has been Updated succesfully!";
        $_SESSION['msg_type'] = "success";

      } else {
        echo "Error: " . $tsql . "<br>" . $conn->error;
      }

  header("location: compOrdrTable.php"); //return to
}

?>