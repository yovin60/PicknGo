<?php
// Check existence of id parameter before processing further

    $db = mysqli_connect('localhost', 'root', '', 'pickandgo');
 
      $search= true;
      $orderid=$_GET['order_id'];
     
     $sql = "SELECT * FROM pickup_orders WHERE order_id='$orderid'";
     $result =$db->query($sql) ; 
     if($result->num_rows . 0){
     while($row = $result->fetch_array())
    {
           
         
         @$cusid = $row['cus_id'];
         @$ordername = $row['order_name'];
         @$datetime= $row['date_time'];
         @$pickupaddress = $row['pickup_address'];
         @$availability = $row['availability'];
         @$receivername = $row['receiver_name'];
         @$receiveraddress = $row['receiver_address'];
         @$receivercontactno = $row['receiver_contactno'];
         @$nearestcenter = $row['nearest_center'];
         @$status = $row['status'];
         
    }
}
    // Close connection
   $db->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>Order_ID</label>
                        <p><b><?php if ($search==true ) {echo @$orderid;} else{echo "";}?></b></p>
                    </div>
                    <div class="form-group">
                        <label>order_name</label>
                        <p><b><?php if ($search==true ) {echo @$ordername;} else{echo "";}?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Date and Time</label>
                        <p><b><?php if ($search==true ) {echo @$datetime;} else{echo "";}?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Availability</label>
                        <p><b><?php if ($search==true ) {echo @$availability;} else{echo "";}?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Receiver_Name</label>
                        <p><b><?php if ($search==true ) {echo @$receivername;} else{echo "";}?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Receiver_Address</label>
                        <p><b><?php if ($search==true ) {echo @$receiveraddress;} else{echo "";}?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Receiver_Contactno</label>
                        <p><b><?php if ($search==true ) {echo @$receivercontactno;} else{echo "";}?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Nearest_Center</label>
                        <p><b><?php if ($search==true ) {echo @$nearestcenter;} else{echo "";}?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <p><b><?php if ($search==true ) {echo @$status;} else{echo "";}?></b></p>
                    </div>
                  
                    <p><a href="javascript:history.back(1)" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>