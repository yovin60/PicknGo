<?php
session_start();
$centerid=$_SESSION['center'];
$cname = $_SESSION['cname'];
?>

<?php
// Include config file
$db = mysqli_connect('localhost', 'root', '', 'pickandgo');
 
// Define variables and initialize with empty values
$picked = $order = $emp = $load = $route = $center = $status ="";
$picked_err = $order_err = $emp_err = $load_err = $route_err = $center_err = $status_err = "";
 
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

    // Validate employee
    $input_emp = trim($_POST["emp_id"]);
    if(empty($input_emp)){
        $emp_err = "Please enter a valid employee id.";     
    } else{
        $emp = $input_emp;
    }

    // Validate load
    $input_load = trim($_POST["load_id"]);
    if(empty($input_load)){
        $load_err = "Please enter a valid employee id.";     
    } else{
        $load = $input_load;
    }

    // Validate route
    $input_route = trim($_POST["route_id"]);
    if(empty($input_route)){
        $route_err = "Please enter a valid route id.";     
    } else{
        $route = $input_route;
    }

    // Validate center
    $input_center = trim($_POST["center_id"]);
    if(empty($input_center)){
        $center_err = "Please enter a valid route id.";     
    } else{
        $center = $input_center;
    }

    // Validate status
    $input_status = trim($_POST["status"]);
    if(empty($input_status)){
        $status_err = "Please enter a status.";     
    } else{
        $status = $input_status;
    }

    
    // Check input errors before inserting in database
    if(empty($picked_err) && empty($order_err) && empty($emp_err) && empty($load_err) && empty($route_err) && empty($center_err) && empty($status_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO arrived_items (picked_id, order_id, emp_id, load_id, route_id, center_id, status) VALUES (?, ?, ?, ?, ?, ?,?)";
         
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $param_picked, $param_order, $param_emp, $param_load, $param_route, $param_center, $param_status);
            
            // Set parameters
            $param_picked = $picked;
            $param_order = $order;
            $param_emp = $emp;
            $param_load = $load;
            $param_route = $route;
            $param_center = $center;
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
                    <p>Please fill this form and submit to add arrived item record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Picked ID</label>
                            <select name="picked_id" class="form-control" id="picked_id">
                                <option></option>
                                <?php
                                $sql2="SELECT * FROM loaded_items WHERE destination_center_id = '{$centerid}' ";
                                   $res=$db->query($sql2);
                                    while($row=$res->fetch_assoc()){
                                    echo "<option value='".$row['picked_id']."'>".$row['picked_id']."</option>";
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
                                $sql2="SELECT * FROM loaded_items WHERE destination_center_id = '{$centerid}'";
                                   $res=$db->query($sql2);
                                    while($row=$res->fetch_assoc()){
                                    echo "<option value='".$row['order_id']."'>".$row['order_id']."</option>";
                                    }
                                ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $order_err;?></span>
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
                            <label>Load ID</label>
                            <select name="load_id" class="form-control" id="load_id">
                                <option></option>
                                <?php
                                $sql2="SELECT * FROM loaded_items WHERE destination_center_id = '{$centerid}'";
                                   $res=$db->query($sql2);
                                    while($row=$res->fetch_assoc()){
                                    echo "<option value='".$row['load_id']."'>".$row['load_id']."</option>";
                                    }
                                ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $load_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Route ID</label>
                            <select name="route_id" class="form-control" id="route_id">
                                <option></option>
                                <?php
                                $sql2="SELECT * FROM routes WHERE start_center = '{$cname}'";
                                   $res=$db->query($sql2);
                                    while($row=$res->fetch_assoc()){
                                    echo "<option value='".$row['route_id']."'>".$row['route_id']."</option>";
                                    }
                                ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $route_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Center ID</label>
                            <select name="center_id" class="form-control" id="center_id">
                                <option></option>
                                <?php
                                $sql2="SELECT * FROM operational_centers WHERE center_id = '{$centerid}'";
                                   $res=$db->query($sql2);
                                    while($row=$res->fetch_assoc()){
                                    echo "<option value='".$row['center_id']."'>".$row['name']."</option>";
                                    }
                                ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $center_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control" id="status">
                                <option></option>
                                <option>ARRIVED</option>
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