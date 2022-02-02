<?php
// Include config file
$db = mysqli_connect('localhost', 'root', '', 'pickandgo');
 
// Define variables and initialize with empty values
$center = $name = $email = $contact = $type = $pass ="";
$center_err = $name_err = $email_err = $contact_err = $type_err = $pass_err ="";
 
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
        // Prepare an insert statement
        $sql = "INSERT INTO employee (center_id, emp_name, email, contact_no, user_type, password) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_center, $param_name, $param_email, $param_contact, $param_type, $param_pass);
            
            // Set parameters
            $param_center = $center;
            $param_name = $name;
            $param_email = $email;
            $param_contact = $contact;
            $param_type = $type;
            $param_pass = $hashed;
            
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
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Center</label>
                            
                            <select name="center_id" class="form-control" id="center_id">
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
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>