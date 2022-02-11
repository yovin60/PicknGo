<?php
// Check existence of id parameter before processing further
if(isset($_GET["picked_id"]) && !empty(trim($_GET["picked_id"]))){
    // Include config file
    $db = mysqli_connect('localhost', 'root', '', 'pickandgo');
    
    // Prepare a select statement
    $sql = "SELECT * FROM pickedup_items WHERE picked_id = ?";
    
    if($stmt = mysqli_prepare($db, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["picked_id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $id = $row["picked_id"];
                $order = $row["order_id"];
                $center = $row["center_id"];
                $weight = $row["weight"];
                $type = $row["type"];
                $size = $row["size"];
                $distance = $row["distance"];
                $price = $row["price"];
                $status = $row["status"];
                
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
                        <label>Picked_ID</label>
                        <p><b><?php echo $row["picked_id"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Order_ID</label>
                        <p><b><?php echo $row["order_id"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Center_ID</label>
                        <p><b><?php echo $row["center_id"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Weight (Kg)</label>
                        <p><b><?php echo $row["weight"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <p><b><?php echo $row["type"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Size</label>
                        <p><b><?php echo $row["size"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Distance (Km)</label>
                        <p><b><?php echo $row["distance"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Price (Rs)</label>
                        <p><b><?php echo $row["price"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <p><b><?php echo $row["status"]; ?></b></p>
                    </div>
                  
                    <p><a href="javascript:history.back(1)" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>