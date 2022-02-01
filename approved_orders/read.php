<?php
// start the session
session_start();
?>
<?php
// Check existence of id parameter before processing further
if(isset($_GET["order_id"]) && !empty(trim($_GET["order_id"]))){
    // Include config file
    $db = mysqli_connect('localhost', 'root', '', 'pickandgo');
    
    // Prepare a select statement
    $sql = "SELECT * FROM pickup_orders WHERE order_id = ?";
    
    if($stmt = mysqli_prepare($db, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["order_id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $id = $row["order_id"];
                $cus = $row["cus_id"];
                $name = $row["order_name"];
                $time = $row["date_time"];
                $padd = $row["pickup_address"];
                $avail = $row["availability"];
                $rname = $row["receiver_name"];
                $radd = $row["receiver_address"];
                $contact= $row["receiver_contactno"];
                $center = $row["nearest_center"];
                $pickuptime = $row['pickup_time'];
                $emp = $row["emp_id"];
                $statu = $row["status"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($db);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
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
                        <p><b><?php echo $row["order_id"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Customer_ID</label>
                        <p><b><?php echo $row["cus_id"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Order Name</label>
                        <p><b><?php echo $row["order_name"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Order Date & time</label>
                        <p><b><?php echo $row["date_time"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Pickup Address</label>
                        <p><b><?php echo $row["pickup_address"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Availability</label>
                        <p><b><?php echo $row["availability"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Receiver Name</label>
                        <p><b><?php echo $row["receiver_name"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Receiver Address</label>
                        <p><b><?php echo $row["receiver_address"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Contact No</label>
                        <p><b><?php echo $row["receiver_contactno"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Nearest Center</label>
                        <p><b><?php echo $row["nearest_center"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Pick up Time</label>
                        <p><b><?php echo $row["pickup_time"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Employee ID</label>
                        <p><b><?php echo $row["emp_id"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <p><b><?php echo $row["status"]; ?></b></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>