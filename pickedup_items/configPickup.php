<?php
session_start();
$centerid = $_SESSION['cname'];

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
  
        $sql = "INSERT INTO pickedup_items(picked_id, order_id, center_id, weight, type, size, distance , price, status)
        VALUES ('$pickedId', '$orderId', '$center_id', '$weight', '$typeName', '$sizeName', '$distanceType', '$totalPrice', '$status')";
  
        if ($conn->query($sql) === TRUE) {
            
            echo '<script>alert("Package has been successfully picked up!")</script>';

        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
  
    echo "<script> 
            window.location.href='index.php';
            </script>";
  }

//Tracking table Update
if(isset($_POST['Pick'])){
  $pickedId = $_POST['pickedId'];
  $status = "PICKED";

      $sql = "INSERT INTO tracking(picked_id, status, location)
      VALUES ('$pickedId', '$status', '$centerid')";

      if ($conn->query($sql) === TRUE) {
          
          echo '<script>alert("Package has been successfully picked up!")</script>';

      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
}


//send mail to customer
if(isset($_POST['Pick'])){
  $picked_Id = $_POST['pickedId'];
  $order_Id = $_POST['orderId'];
    

      $selectcusId = mysqli_query ($conn,"SELECT * from pickup_orders INNER JOIN customer ON pickup_orders.cus_id = customer.cus_id WHERE pickup_orders.order_id = '{$order_Id}'");
        while ($row = mysqli_fetch_array($selectcusId)) 
      {
          $customer_mail = $row['email'];
      }

    date_default_timezone_set('Etc/UTC');
    require("/PHPMailer-master/src/PHPMailer.php");
    require("/PHPMailer-master/src/SMTP.php");
    require("/PHPMailer-master/src/Exception.php");
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->CharSet =  "utf-8";
    $mail->IsSMTP();
    // enable SMTP authentication
    $mail->SMTPAuth = true;                  
    // GMAIL username
    $mail->Username = "amazingspidy99@gmail.com";
    // GMAIL password
    $mail->Password = "Spiderman1999@";
    $mail->SMTPSecure = "tls";  
    // sets GMAIL as the SMTP server
    $mail->Host = ('smtp.gmail.com');
    // set the SMTP port for the GMAIL server
    $mail->Port = "587";
    $mail->From='amazingspidy99@gmail.com';
    $mail->FromName='PicknGo';
    $mail->AddAddress($customer_mail, 'reciever_name');
    $mail->Subject  =  'Tracking Code';
    $mail->IsHTML(true);
    $mail->Body    = ''.$picked_Id.' is your Tracking code for your order and the order ID is '.$order_Id.'';
    if($mail->Send())
    {
      echo "<script> 
            alert('Record Inserted successfully!');
            window.location.href='index.php';
            </script>";
    }
    else
    {
      header("location: error.php");
    }
           

}

?>