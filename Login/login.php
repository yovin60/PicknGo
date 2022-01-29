<?php
 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login Page</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="post">
					

					<span class="login100-form-title p-b-34 p-t-27">
						Log in
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Enter email">
						<input class="input100" type="text" name="email" placeholder="email">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>

					

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit" name="login">
							Login
						</button>
					</div>

					<div class="text-center p-t-90">
						<a class="txt1" href="../admin_password_reset/email_input.php" >
							Reset admin password ||
						</a>
						<a class="txt1" href="#" >
							Reset user password ||
						</a>
						<a class="txt1" href="../employee_password_reset/email_input.php" >
							Reset employee password
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>
    
<?php 

if(isset($_POST['login']))

{
	$db = mysqli_connect('localhost', 'root', '', 'pickandgo');

    $eml=$_POST['email'];
	$pw=$_POST['password'];

    $_SESSION['mail']=$_POST['email'];
    $session=$_SESSION['mail'];
    $result = mysqli_query($db, "SELECT * FROM admin where email='{$eml}'");
    while($row = mysqli_fetch_array($result))
    
    {
        $id=$row['password'];
        $mail=$row['email'];

        if (password_verify($pw, $row['password']) && $eml=($mail)) 

        {
		
		        echo '<script language="javascript">';
		        echo 'alert("Login Successfull!")';
		        echo'</script>';		
		        echo "<script> location.href='../admin/admin.php';</script>";
		        exit;
		}
                                                 	

	}
}

else 

    {
        
        if(isset($_POST['login']))
    {

        echo '<script language="javascript">';
		echo 'alert("Please Check your Details")';
		echo'</script>';
	}

	}


if(isset($_POST['login']))

{

	$db = mysqli_connect('localhost', 'root', '', 'pickandgo');

    $eml=$_POST['email'];
	$pw=$_POST['password'];
	$user="MANAGER";

        $_SESSION['mail']=$_POST['email'];
        $session=$_SESSION['mail'];
        

        $result = mysqli_query($db, "SELECT * FROM employee where email='{$eml}'");
        while($row = mysqli_fetch_array($result))
        {

         $id=$row['password'];
         $mail=$row['email'];
         $type=$row['user_type'];


            if (password_verify($pw, $row['password']) && $eml=($mail) && $user=($type)) 
                {
		 
		        echo '<script language="javascript">';
		        echo 'alert("Login Successfull!")';
		        echo'</script>';		
		        echo "<script> location.href='../manager/manager.php';</script>";
		        exit;
                }   

            else 

               {
           
                 if(isset($_POST['login']))
                  
                  {
                    echo '<script language="javascript">';
		            echo 'alert("Please Check your Details")';
		            echo'</script>';
	              }
	           }                     	
        }   
}
else 

    {
        
        if(isset($_POST['login']))
    {

        echo '<script language="javascript">';
		echo 'alert("Please Check your Details")';
		echo'</script>';
	}

	}


?>
</body>
</html>