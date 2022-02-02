<?php
// Include config file
$db = mysqli_connect('localhost', 'root', '', 'pickandgo');
 
// Define variables and initialize with empty values
$time = $status = $emp="";
$time_err = $status_err = $emp_err="";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate datetime
    $input_time = trim($_POST["pickup_time"]);
    if(empty($input_time)){
        $time_err = "please select correct time";
    } else{
        $time = $input_time;
    }

    // Validate status
    $input_status = trim($_POST["status"]);
    if(empty($input_status)){
        $status_err = "Please select correct status.";     
    } else{
        $status= $input_status;
    }

    // Validate EMP ID
    $input_emp = trim($_POST["emp_id"]);
    if(empty($input_emp)){
        $emp_err = "Please select correct emp id.";     
    } else{
        $emp= $input_emp;
    }
    
    // Check input errors before inserting in database
    if(empty($time_err) && empty($status_err) && empty($emp_err)){
        // Prepare an update statement
        $sql = "UPDATE pickup_orders SET status=?, pickup_time=?, emp_id=? WHERE order_id=?";
         
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssi", $param_status, $param_time, $param_empid, $param_id);
            
            // Set parameters
            $param_id = $id;
            $param_status= $status;
            $param_time = $time;
            $param_empid = $emp;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        
        }
        // Close statement
        mysqli_stmt_close($stmt);

         
        
    }
    
    // Close connection
    mysqli_close($db);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["order_id"]) && !empty(trim($_GET["order_id"]))){
        // Get URL parameter
        $id =  trim($_GET["order_id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM pickup_orders WHERE order_id = ?";
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $param_status = $status;
                    $param_time = $time;
                    $param_empid = $emp;
                } else{
                    // URL doesn't contain valid id. Redirect to error page
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
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the PENDING orders record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Status</label>
                            
                            <select name="status" class="form-control" id="status">
                                <option></option>
                                <option>APPROVED</option>
                            </select>
                            <span class="invalid-feedback"><?php echo $center_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Date & Time</label>
                            <input type="datetime-local" id="pickup_time" name="pickup_time">
                            <span class="invalid-feedback"><?php echo $time_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Employee</label>
                            
                            <select name="emp_id" class="form-control" id="emp_id">
                                <option></option>
                                <?php
                                $db = mysqli_connect('localhost', 'root', '', 'pickandgo');
                                $sql2="SELECT * FROM employee WHERE user_type='DRIVER'";
                                   $res=$db->query($sql2);
                                    while($row=$res->fetch_assoc()){
                                    echo "<option value='".$row['emp_id']."'>".$row['emp_name']."</option>";
                                    }
                                ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $emp_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>