<?php
session_start();
$centerid = $_SESSION['cname'];
$branch = $_SESSION['center'];
?>
<?php
// Include config file
$db = mysqli_connect('localhost', 'root', '', 'pickandgo');
 
// Define variables and initialize with empty values
$stcenter = $stcity = $dstcenter = $dstcity ="";
$stcenter_err = $stcity_err = $dstcenter_err = $dstcity_err ="";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Validate center
    $input_stcenter = trim($_POST["start_center"]);
    if(empty($input_stcenter)){
        $stcenter_err = "Please enter a valid center.";
    } else{
        $stcenter = $input_stcenter;
    }

    $input_stcity = trim($_POST["start_city"]);
    if(empty($input_stcity)){
        $stcity_err = "Please enter a valid center.";
    } else{
        $stcity = $input_stcity;
    }


    // Validate center
    $input_dstcenter = trim($_POST["destination_center"]);
    if(empty($input_dstcenter)){
        $dstcenter_err = "Please enter a valid center.";
    } else{
        $dstcenter = $input_dstcenter;
    }

    // Validate center
    $input_dstcity = trim($_POST["destination_city"]);
    if(empty($input_dstcity)){
        $dstcity_err = "Please enter a valid center.";
    } else{
        $dstcity = $input_dstcity;
    }
    
   
    
    // Check input errors before inserting in database
    if(empty($stcenter_err) && empty($stcity_err) && empty($dstcenter_err) && empty($dstcity_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO routes (start_center, start_city, destination_center, destination_city) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_stcenter, $param_stcity, $param_dstcenter, $param_dstcity);
            
            // Set parameters
            $param_stcenter = $stcenter;
            $param_stcity = $stcity;
            $param_dstcenter = $dstcenter;
            $param_dstcity = $dstcity;
           
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
                    <p>Please fill this form and submit to add route record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        
                        <div class="form-group">
                            <label>Start Center</label>
                            <select name="start_center" class="form-control" id="start_center">
                                <option></option>
                                <?php
                                $sql2="SELECT * FROM operational_centers WHERE name = '{$centerid}'";
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
                                $sql2="SELECT * FROM cities WHERE center_id = '{$branch}'";
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
                                $sql2="SELECT * FROM cities";
                                   $res=$db->query($sql2);
                                    while($row=$res->fetch_assoc()){
                                    echo "<option value='".$row['city_name']."'>".$row['city_name']."</option>";
                                    }
                                ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $dstcity_err;?></span>
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