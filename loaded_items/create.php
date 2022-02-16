<?php
session_start();
$centerid = $_SESSION['center'];
$branch = $_SESSION['cname'];
?>
<?php
// Include config file
$db = mysqli_connect('localhost', 'root', '', 'pickandgo');
 
// Define variables and initialize with empty values
$picked = $order = $center = $emp = $route = $status ="";
$picked_err = $order_err = $center_err = $emp_err = $route_err = $status_err ="";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Validate pick id
    $input_picked = trim($_POST["picked_id"]);
    if(empty($input_picked)){
        $picked_err = "Please enter a valid ID.";
    } else{
        $picked = $input_picked;
    }
    
    // Validate order id
    $input_order = trim($_POST["order_id"]);
    if(empty($input_order)){
        $order_err = "Please enter a valid order.";     
    } else{
        $order = $input_order;
    }

    // Validate center
    $input_center = trim($_POST["destination_center_id"]);
    if(empty($input_center)){
        $center_err = "Please enter a valid center.";     
    } else{
        $center = $input_center;
    }

    // Validate employee
    $input_emp = trim($_POST["emp_id"]);
    if(empty($input_emp)){
        $emp_err = "Please enter a valid employee id.";     
    } else{
        $emp = $input_emp;
    }

    // Validate route
    $input_route = trim($_POST["route_id"]);
    if(empty($input_route)){
        $route_err = "Please enter a valid route id.";     
    } else{
        $route = $input_route;
    }

    // Validate status
    $input_status = trim($_POST["status"]);
    if(empty($input_status)){
        $status_err = "Please enter a status.";     
    } else{
        $status = $input_status;
    }

    
    // Check input errors before inserting in database
    if(empty($picked_err) && empty($order_err) && empty($center_err) && empty($emp_err) && empty($route_err) && empty($status_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO loaded_items (picked_id, order_id, destination_center_id, emp_id, route_id, status) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_picked, $param_order, $param_center, $param_emp, $param_route, $param_status);
            
            // Set parameters
            $param_picked = $picked;
            $param_order = $order;
            $param_center = $center;
            $param_emp = $emp;
            $param_route = $route;
            $param_status = $status;
           
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
            {
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } 
            else

            {
                echo '<script language="javascript">';
                echo 'alert("Please Check your Detials and try again!")';
                echo'</script>';        
                echo "<script> location.href='create.php';</script>";
                exit;

            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($db);
}

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add loaded record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Picked ID</label>
                            <select name="picked_id" class="form-control" id="picked_id">
                                <option></option>
                                <?php
                                $sql2="SELECT * FROM pickedup_items INNER JOIN pickup_orders ON pickedup_items.order_id = pickup_orders.order_id WHERE center_id = '{$centerid}'";
                                   $res=$db->query($sql2);
                                    while($row=$res->fetch_assoc()){
                                    echo "<option value='".$row['picked_id']."'>".$row['picked_id'].' - '.$row['receiver_name']."</option>";
                                    }
                                ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $picked_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Order ID</label>
                            <select name="order_id" class="form-control" id="order_id">
                                <option></option>
                                <?php
                                $sql2="SELECT * FROM pickedup_items INNER JOIN pickup_orders ON pickedup_items.order_id = pickup_orders.order_id WHERE center_id = '{$centerid}'";
                                   $res=$db->query($sql2);
                                    while($row=$res->fetch_assoc()){
                                    echo "<option value='".$row['order_id']."'>".$row['order_id'].' - '.$row['receiver_name']."</option>";
                                    }
                                ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $order_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Destination Center</label>
                            <select name="destination_center_id" class="form-control" id="destination_center_id">
                                <option></option>
                                <?php
                                $sql2="SELECT * FROM operational_centers";
                                   $res=$db->query($sql2);
                                    while($row=$res->fetch_assoc()){
                                    echo "<option value='".$row['center_id']."'>".$row['name']."</option>";
                                    }
                                ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $center_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Driver</label>
                            <select name="emp_id" class="form-control" id="emp_id">
                                <option></option>
                                <?php
                                $sql2="SELECT * FROM employee WHERE user_type='DRIVER' && center_id = '{$centerid}'";
                                   $res=$db->query($sql2);
                                    while($row=$res->fetch_assoc()){
                                    echo "<option value='".$row['emp_id']."'>".$row['emp_name']."</option>";
                                    }
                                ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $emp_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Route</label>
                            <select name="route_id" class="form-control" id="route_id">
                                <option></option>
                                <?php
                                $sql2="SELECT * FROM routes WHERE start_center = '{$branch}'";
                                   $res=$db->query($sql2);
                                    while($row=$res->fetch_assoc()){
                                    echo "<option value='".$row['route_id']."'>" .'From ' .$row['start_center'].' to ' .$row['destination_center']."</option>";
                                    }
                                ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $route_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control" id="status">
                                <option></option>
                                <option>LOADED</option>
                            </select>
                            <span class="invalid-feedback"><?php echo $status_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>