<?php
// Include config file
$db = mysqli_connect('localhost', 'root', '', 'pickandgo');
 
// Define variables and initialize with empty values
$center = $emp = $vehicle = $regno ="";
$center_err = $emp_err = $vehicle_err = $regno_err ="";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate center
    $input_center = trim($_POST["center_id"]);
    if(empty($input_center)){
        $center_err = "Please enter a valid center.";
    } else{
        $center = $input_center;
    }

    // Validate emp id
    $input_emp = trim($_POST["emp_id"]);
    if(empty($input_emp)){
        $emp_err = "Please enter a name.";     
    } else{
        $emp = $input_emp;
    }

    // Validate vehicle
    $input_vehicle = trim($_POST["vehicle_name"]);
    if(empty($input_vehicle)){
        $vehicle_err = "Please enter a name.";     
    } else{
        $vehicle = $input_vehicle;
    }

    // Validate Reg No
    $input_regno = trim($_POST["reg_no"]);
    if(empty($input_regno)){
        $regno_err = "Please enter a valid number.";     
    } else{
        $regno = $input_regno;
    }
    
    // Check input errors before inserting in database
    if(empty($center_err) && empty($emp_err) && empty($vehicle_err) && empty($regno_err)){
        // Prepare an update statement
        $sql = "UPDATE vehicles SET center_id=?, emp_id=?, vehicle_name=?, reg_no=? WHERE vehicle_id=?";
         
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssi", $param_center, $param_emp, $param_vehicle, $param_regno, $param_id);
            
            // Set parameters
            $param_id =$id;
            $param_center =$center;
            $param_emp = $emp;
            $param_vehicle =$vehicle;
            $param_regno =$regno;

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
    if(isset($_GET["vehicle_id"]) && !empty(trim($_GET["vehicle_id"]))){
        // Get URL parameter
        $id =  trim($_GET["vehicle_id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM vehicles WHERE vehicle_id = ?";
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
                     
                       $param_center =$center;
                       $param_emp = $emp;
                       $param_vehicle =$vehicle;
                       $param_regno =$regno;
                    
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
                    <p>Please edit the input values and submit to update the vehicle record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Center</label>
                            
                            <select name="center_id" class="form-control" id="center_id">
                                <option></option>
                                <?php
                                $db = mysqli_connect('localhost', 'root', '', 'pickandgo');
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
                                $sql2="SELECT * FROM employee WHERE user_type='DRIVER'";
                                   $res=$db->query($sql2);
                                    while($row=$res->fetch_assoc()){
                                    echo "<option value='".$row['emp_id']."'>".$row['emp_name']."</option>";
                                    }
                                ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $emp_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Vehicle Model</label>
                            <textarea name="vehicle_name" class="form-control <?php echo (!empty($vehicle_err)) ? 'is-invalid' : ''; ?>"><?php echo $vehicle; ?></textarea>
                            <span class="invalid-feedback"><?php echo $vehicle_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Registration No</label>
                            <textarea name="reg_no" class="form-control <?php echo (!empty($regno_err)) ? 'is-invalid' : ''; ?>"><?php echo $regno; ?></textarea>
                            <span class="invalid-feedback"><?php echo $regno_err;?></span>
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