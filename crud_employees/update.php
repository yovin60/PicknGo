<?php
// Include config file
$db = mysqli_connect('localhost', 'root', '', 'pickandgo');
 
// Define variables and initialize with empty values
$center = $name = $email = $contact = $type = $pass ="";
$center_err = $name_err = $email_err = $contact_err = $type_err = $pass_err ="";
 
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

    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";     
    } else{
        $name = $input_name;
    }
    
    // Validate email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter a valid email.";     
    }  else{
        $email = $input_email;
    }

    // Validate contact
    $input_contact = trim($_POST["contact_no"]);
    if(empty($input_contact)){
        $contact_err = "Please enter a valid number.";     
    }  else{
        $contact = $input_contact;
    }

    // Validate user type
    $input_type = trim($_POST["user_type"]);
    if(empty($input_type)){
        $type_err = "Please enter a valid user type.";     
    }  else{
        $type = $input_type;
    }

    // Validate password
    $input_pass = trim($_POST["password"]);
    if(empty($input_pass)){
        $pass_err = "Please enter a valid password.";     
    }  else{
        $pass = $input_pass;
        $hashed = password_hash($pass, PASSWORD_DEFAULT);
    }

    
    // Check input errors before inserting in database
    if(empty($center_err) && empty($name_err) && empty($email_err) && empty($contact_err) && empty($type_err) && empty($pass_err)){
        // Prepare an update statement
        $sql = "UPDATE employee SET center_id=?, name=?, email=?, contact_no=?, user_type=?, password=? WHERE emp_id=?";
         
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssi", $param_center, $param_name, $param_email, $param_contact, $param_type, $param_pass, $param_id);
            
            // Set parameters
            $param_id = $id;
            $param_center = $center;
            $param_name = $name;
            $param_email = $email;
            $param_contact = $contact;
            $param_type = $type;
            $param_pass = $hashed;

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
    if(isset($_GET["emp_id"]) && !empty(trim($_GET["emp_id"]))){
        // Get URL parameter
        $id =  trim($_GET["emp_id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM employee WHERE emp_id = ?";
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
                    $param_center = $center;
                    $param_name = $name;
                    $param_email = $email;
                    $param_contact = $contact;
                    $param_type = $type;
                    $param_pass = $pass;
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
                    <p>Please edit the input values and submit to update the employee record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Center ID</label>
                            
                            <select name="center_id" class="form-control" id="center_id">
                                <option></option>
                                <?php
                                $db = mysqli_connect('localhost', 'root', '', 'pickandgo');
                                $sql2="SELECT center_id FROM operational_centers";
                                   $res=$db->query($sql2);
                                    while($row=$res->fetch_assoc()){
                                    echo "<option value='".$row['center_id']."'>".$row['center_id']."</option>";
                                    }
                                ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $center_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <textarea name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>"><?php echo $name; ?></textarea>
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>email</label>
                            <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>contact_no</label>
                            <input type="text" name="contact_no" class="form-control <?php echo (!empty($contact_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $contact; ?>">
                            <span class="invalid-feedback"><?php echo $contact_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>User_Type</label>
                            <select name="user_type" class="form-control" id="center_id">
                                <option></option>
                                <option>MANAGER</option>
                                <option>DRIVER</option>
                            </select>
                            <span class="invalid-feedback"><?php echo $type_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" name="password" class="form-control <?php echo (!empty($pass_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $pass; ?>">
                            <span class="invalid-feedback"><?php echo $pass_err;?></span>
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