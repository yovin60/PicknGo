<?php
// Include config file
$db = mysqli_connect('localhost', 'root', '', 'pickandgo');
 
// Define variables and initialize with empty values
$name = $address = $email = $contact_no = $pass ="";
$name_err = $address_err = $email_err = $contact_no_err = $pass_err ="";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Validate customer name
    $input_name = trim($_POST["cus_name"]);
    if(empty($input_name)){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter a address.";     
    } else{
        $address = $input_address;
    }
    
    // Validate email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter a valid email.";     
    }  else{
        $email = $input_email;
    }

    // Validate contact
    $input_contact_no = trim($_POST["contact_no"]);
    if(empty($input_contact_no)){
        $contact_no_err = "Please enter a valid number.";     
    }  else{
        $contact_no = $input_contact_no;
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
    if(empty($name_err) && empty($address_err) && empty($email_err) && empty($contact_no_err) && empty($pass_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO customer (cus_name, address, email, contact_no,password) VALUES (?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_name, $param_address, $param_email, $param_contact_no, $param_pass);
            
            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_email = $email;
            $param_contact_no = $contact_no;
            $param_pass = $hashed;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
            {
                // Records created successfully. Redirect to landing page
                header("location: ../login/login.php");
                exit();
            } 
            else

            {
                echo '<script language="javascript">';
                echo 'alert("Please Check your Detials and try again!")';
                echo'</script>';        
                echo "<script> location.href='reg_cus.php';</script>";
                exit;

            }
        
         
        // Close statement
        mysqli_stmt_close($stmt);
        }
}
    
    // Close connection
    mysqli_close($db);
}

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Register</title>
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
                    <h2 class="mt-5">Registration</h2>
                    <p>Please fill this form and submit to register a customer record.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="cus_name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea type="text" name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>email</label>
                            <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>contact</label>
                            <input type="text" name="contact_no" class="form-control <?php echo (!empty($contact_no_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $contact_no; ?>">
                            <span class="invalid-feedback"><?php echo $contact_no_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" name="password" class="form-control <?php echo (!empty($pass_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $pass; ?>">
                            <span class="invalid-feedback"><?php echo $pass_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="../index.html" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>