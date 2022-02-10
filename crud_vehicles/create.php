<?php
session_start();
$centerid = $_SESSION['center'];
?>
<?php
// Include config file
$db = mysqli_connect('localhost', 'root', '', 'pickandgo');
 
// Define variables and initialize with empty values
$center = $emp = $vehicle = $regno ="";
$center_err = $emp_err = $vehicle_err = $regno_err ="";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
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
        // Prepare an insert statement
        $sql = "INSERT INTO vehicles (center_id, emp_id, vehicle_name, reg_no) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_center, $param_emp, $param_vehicle, $param_regno);
            
            // Set parameters
            $param_center = $center;
            $param_emp = $emp;
            $param_vehicle = $vehicle;
            $param_regno = $regno;
           
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
                    <p>Please fill this form and submit to add vehicle record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        
                        <div class="form-group">
                            <label>Center</label>
                            <select name="center_id" class="form-control" id="center_id">
                                <option></option>
                                <?php
                                $sql2="SELECT * FROM operational_centers WHERE center_id='{$centerid}'";
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
                                $sql2="SELECT * FROM employee WHERE user_type='DRIVER' && center_id='{$centerid}'";
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

                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>