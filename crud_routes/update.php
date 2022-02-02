<?php
// Include config file
$db = mysqli_connect('localhost', 'root', '', 'pickandgo');
 
// Define variables and initialize with empty values
$stcenter = $stcity = $dstcenter = $dstcity ="";
$stcenter_err = $stcity_err = $dstcenter_err = $dstcity_err ="";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate center
     $input_stcenter = trim($_POST["start_center"]);
    if(empty($input_stcenter)){
        $stcenter_err = "Please enter a valid center.";
    } else{
        $stcenter = $input_stcenter;
    }

    // Validate emp id
    $input_stcity = trim($_POST["start_city"]);
    if(empty($input_stcity)){
        $stcity_err = "Please enter a valid center.";
    } else{
        $stcity = $input_stcity;
    }

    // Validate vehicle
    $input_dstcenter = trim($_POST["destination_center"]);
    if(empty($input_dstcenter)){
        $dstcenter_err = "Please enter a valid center.";
    } else{
        $dstcenter = $input_dstcenter;
    }

    // Validate Reg No
    $input_dstcity = trim($_POST["destination_city"]);
    if(empty($input_dstcity)){
        $dstcity_err = "Please enter a valid center.";
    } else{
        $dstcity = $input_dstcity;
    }
    
    
    // Check input errors before inserting in database
    if(empty($stcenter_err) && empty($stcity_err) && empty($dstcenter_err) && empty($dstcity_err)){
        // Prepare an update statement
        $sql = "UPDATE routes SET start_center=?, start_city=?, destination_center=?, destination_city=? WHERE route_id=?";
         
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssi", $param_stcenter, $param_stcity, $param_dstcenter, $param_dstcity, $param_id);
            
            // Set parameters
            $param_id =$id;
            $param_stcenter = $stcenter;
            $param_stcity = $stcity;
            $param_dstcenter = $dstcenter;
            $param_dstcity = $dstcity;

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
    if(isset($_GET["route_id"]) && !empty(trim($_GET["route_id"]))){
        // Get URL parameter
        $id =  trim($_GET["route_id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM routes WHERE route_id = ?";
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
                     
                       $param_stcenter = $stcenter;
                       $param_stcity = $stcity;
                       $param_dstcenter = $dstcenter;
                       $param_dstcity = $dstcity;
                    
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
                    <p>Please edit the input values and submit to update the routes record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Start Center</label>
                            <select name="start_center" class="form-control" id="start_center">
                                <option></option>
                                <?php
                                $db = mysqli_connect('localhost', 'root', '', 'pickandgo');
                                $sql2="SELECT * FROM operational_centers";
                                   $res=$db->query($sql2);
                                    while($row=$res->fetch_assoc()){
                                    echo "<option value='".$row['name']."'>".$row['name']."</option>";
                                    }
                                ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $stcenter_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Start City</label>
                            <select name="start_city" class="form-control" id="start_city">
                                <option></option>
                                <?php
                                $db = mysqli_connect('localhost', 'root', '', 'pickandgo');
                                $sql2="SELECT * FROM cities";
                                   $res=$db->query($sql2);
                                    while($row=$res->fetch_assoc()){
                                    echo "<option value='".$row['city_name']."'>".$row['city_name']."</option>";
                                    }
                                ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $stcity_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Destination Center</label>
                            <select name="destination_center" class="form-control" id="destination_center">
                                <option></option>
                                <?php
                                $db = mysqli_connect('localhost', 'root', '', 'pickandgo');
                                $sql2="SELECT * FROM operational_centers";
                                   $res=$db->query($sql2);
                                    while($row=$res->fetch_assoc()){
                                    echo "<option value='".$row['name']."'>".$row['name']."</option>";
                                    }
                                ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $dstcenter_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Destination City</label>
                            <select name="destination_city" class="form-control" id="destination_city">
                                <option></option>
                                <?php
                                $db = mysqli_connect('localhost', 'root', '', 'pickandgo');
                                $sql2="SELECT * FROM cities";
                                   $res=$db->query($sql2);
                                    while($row=$res->fetch_assoc()){
                                    echo "<option value='".$row['city_name']."'>".$row['city_name']."</option>";
                                    }
                                ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $dstcity_err;?></span>
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