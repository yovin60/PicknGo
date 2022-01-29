<?php
session_start()
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Account info</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
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
<body style="background-color: #999999;">
	
	<div class="limiter">
		<div class="container-login100">
			<div class="login100-more" style="background-image: url('images/4thimg.jpg');"></div>       
              
    <?php
     

	$db = mysqli_connect('localhost', 'root', '', 'pickandgo');

     $update= true;
	
	$query = mysqli_query($db, "SELECT * FROM admin WHERE email='{$_POST['email']}'");

     while($row = mysqli_fetch_array($query))
   {
          
	    $id=$row['admin_id'];
	    $name = $row['name'];
		$mail= $row['email'];
		$contact = $row['contact_no'];
		
   }

	if (isset($_POST['update'])) 
	{

		
		$id = $_POST['id'];
	    $name = $_POST['name'];
		$mail= $_POST['mail'];
		$contact = $_POST['contact'];
		

	mysqli_query($db, "UPDATE admin SET name ='$name',email ='$mail',contact_no ='$contact' WHERE admin_id='{$id}' ");

	    $eml=$_POST['mail'];
		echo '<script language="javascript">';
		echo 'alert("Confirm your email to check results!")';
		echo'</script>';			
		echo "<script> location.href='confirmuser.php';</script>";
		exit; 			
		
  	}


  ?>


			<div class="wrap-login100 p-l-50 p-r-50 p-t-72 p-b-50">
				<form class="login100-form validate-form"  method="post">
					<span class="login100-form-title p-b-59">
						Edit Details
					</span>
                 

					<div class="wrap-input100 validate-input" data-validate="Name is required">
						<span class="label-input100">Admin_ID</span>
						<input class="input100" type="text" name="user_id" placeholder="Name..." onFocus="this.value=''" value="<?php if ($update==true ) {echo $id;} else{echo "";}?>" disabled>
						<span class="focus-input100"></span>
					</div>
					<input type="hidden" name="id" value="<?php echo $id; ?>"/>
					<div class="wrap-input100 validate-input" data-validate="Name is required">
						<span class="label-input100">Name</span>
						<input class="input100" type="text" name="name" placeholder="Name..." onFocus="this.value=''" value="<?php if ($update==true ) {echo $name;} else{echo "";}?>">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<span class="label-input100">Email</span>
						<input class="input100" type="text" name="mail" placeholder="Email addess..." onFocus="this.value=''" value="<?php if ($update==true ) {echo $mail;} else{echo "";}?>">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Phone contact number is required">
						<span class="label-input100">Contact no</span>
						<input class="input100" type="text" name="contact" placeholder="Number..."onFocus="this.value=''" value="<?php if ($update==true ) {echo $contact;} else{echo "";}?>">
						<span class="focus-input100"></span>
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" name="update">
								update
							</button>
						</div>
                       
                       						
					</div>
				</form>
			</div>
		</div>
	</div>
	
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
  

</body>
</html>