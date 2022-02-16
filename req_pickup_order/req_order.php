<?php
session_start();
$cus = $_SESSION['cus_id'];
?>
<?php
// Include config file
$db = mysqli_connect('localhost', 'root', '', 'pickandgo');
 
// Define variables and initialize with empty values
$cusid = $ordername = $pickupaddress = $availability = $receivername= $receiveraddress= $receivercontactno= $nearestcenter="";
$cusid_err= $ordername_err =$pickupaddress_err = $availability_err = $receivername_err= $receiveraddress_err= $receivercontactno_err= $nearestcenter_err="";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
     // Validate customer id
     $input_cusid = trim($_POST["customer_id"]);
     if(empty($input_cusid)){
         $cusid_err = "Please enter a valid customer id.";     
     } else{
         $cusid = $input_cusid;
     }
    
    // Validate order name
    $input_ordername = trim($_POST["order_name"]);
    if(empty($input_ordername)){
        $ordername_err = "Please enter a order name.";     
    } else{
        $ordername = $input_ordername;
    }
   

    // Validate pickup address
    @$input_pickupaddress = trim($_POST["pickup_address"]);
    if(empty($input_pickupaddress)){
        $pickupaddress_err = "Please enter a valid pickup address.";     
    }  else{
        $pickupaddress = $input_pickupaddress;
    }


    // Validate availability
    @$input_availability = trim($_POST["availability"]);
    if(empty($input_availability)){
        $availability_err = "Please enter a availability.";     
    }  else{
        $availability = $input_availability;
       
    }

      // Validate receiver name
      @$input_receivername = trim($_POST["receiver_name"]);
      if(empty($input_receivername)){
          $receivername_err = "Please enter a receiver name.";     
      }  else{
          $receivername = $input_receivername;
         
      }

      // Validate receiver address
      @$input_receiveraddress = trim($_POST["receiver_address"]);
      if(empty($input_receiveraddress)){
          $receiveraddress_err = "Please enter a receiver address.";     
      }  else{
          $receiveraddress = $input_receiveraddress;
         
      }

      // Validate receiver contactno
      @$input_receivercontactno = trim($_POST["receiver_contactno"]);
      if(empty($input_receivercontactno)){
          $receivercontactno_err = "Please enter a receiver contact no.";     
      }  else{
          $receivercontactno = $input_receivercontactno;
         
      }

      // Validate nearest center
      @$input_nearestcenter = trim($_POST["nearest_branch"]);
      if(empty($input_nearestcenter)){
          $nearestcenter_err = "Please enter a nearest center.";     
      }  else{
          $nearestcenter = $input_nearestcenter;
          $stat = 'PENDING';        
      }

     
    
    // Check input errors before inserting in database
        if(empty($cusid_err) && empty($ordername_err) && empty($pickupaddress_err) && empty($availability_err) && empty($receivername_err) && empty($receiveraddress_err) && empty($receivercontactno_err) && empty($nearestcenter_err) ){

        // Prepare an insert statement
         
        $sql = "INSERT INTO pickup_orders (cus_id, order_name, pickup_address, availability, receiver_name, receiver_address, receiver_contactno, nearest_center, status) VALUES (?,?,?,?,?,?,?,?,?)";
          
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
           mysqli_stmt_bind_param($stmt, "sssssssss", $param_cusid, $param_ordername, $param_pickupaddress, $param_availability,$param_receivername,  $param_receiveraddress, $param_receivercontactno, $param_nearestcenter, $param_stat);
            
            // Set parameters
            $param_cusid= $cusid;
            $param_ordername = $ordername;
            $param_stat =  $stat;
            $param_pickupaddress = $pickupaddress;
            $param_availability = $availability;
            $param_receivername = $receivername;
            $param_receiveraddress = $receiveraddress;
            $param_receivercontactno = $receivercontactno;
            $param_nearestcenter = $nearestcenter;
            
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
                echo 'alert("Please Check your Details and try again!")';
                echo'</script>';        
                echo "<script> location.href='req_order.php';</script>";
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
    <title>Request New Order</title>
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
                    <h2 class="mt-5">Request Order</h2>
                    <p>Please fill this form and submit to place a new order record.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                            <label>Customer Id</label>
                            <select name="customer_id" class="form-control" id="customer_id">
                                <option></option>
                                <?php
                                $sql2="SELECT * FROM customer WHERE cus_id = '{$cus}' ";
                                   $res=$db->query($sql2);
                                    while($row=$res->fetch_assoc()){
                                    echo "<option value='".$row['cus_id']."'>".$row['cus_name']."</option>";
                                    }
                                ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $ccus_err;?></span>
                        </div>  

                    <div class="form-group">
                            <label>Order Name</label>
                            <input type="text" name="order_name" class="form-control <?php echo (!empty($ordername_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $ordername; ?>">
                            <span class="invalid-feedback"><?php echo $ordername_err;?></span>
                    </div>
                        <div class="form-group">
                            <label> Pickup Address</label>
                            <textarea type="text" name="pickup_address" class="form-control <?php echo (!empty($pickupaddress_err)) ? 'is-invalid' : ''; ?>"><?php echo $pickupaddress; ?></textarea>
                            <span class="invalid-feedback"><?php echo $pickupaddress_err;?></span>
                    </div>

                        <div class="form-group">
                            <label>Your Availability</label>
                            <select name="availability" class="form-control" id="availability">
                                <option></option>
                                <option>YES</option>
                                <option>NO</option>
                            </select>
                            <span class="invalid-feedback"><?php echo $availability_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Receiver Name</label>
                            <input type="text" name="receiver_name" class="form-control <?php echo (!empty($receivername_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $receivername; ?>">
                            <span class="invalid-feedback"><?php echo $receivername_err;?></span>
                        </div>

                        <div class="form-group">
                            <label> Receiver Address</label>
                            <textarea type="text" name="receiver_address" class="form-control <?php echo (!empty($receiveraddress_err)) ? 'is-invalid' : ''; ?>"><?php echo $receiveraddress; ?></textarea>
                            <span class="invalid-feedback"><?php echo $receiveraddress_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Receiver Contact</label>
                            <input type="text" name="receiver_contactno" class="form-control <?php echo (!empty($receivercontactno_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $receivercontactno; ?>">
                            <span class="invalid-feedback"><?php echo $receivercontactno_err;?></span>
                        </div>

                        <div class="form-group">
                                <label>Select Your City</label>
                                <!-- <input type="text" class="form-control" name="orderId" id="orderId"> -->
                                <select class="form-control" name="city" id="city" onchange="loadIdX();">
                                    <option> - select - </option>
                                <?php
                                        $conn = mysqli_connect("localhost", "root", "", "pickandgo");
                                        $select = "SELECT * FROM cities INNER JOIN operational_centers ON cities.center_id = operational_centers.center_id";
                                        $run = mysqli_query($conn, $select);
                                        while ($row = mysqli_fetch_array($run)) {
                                            $center = $row['name'];
                                            $city = $row['city_name'];
                                            
  
                                    ?>
                                        <option value="<?php echo $center;?>"><?php echo $city; ?></option>

                                    <?php }
                                    ?>
                                </select>
                                <input type="text" name="orderIdtxt" id="orderIdtxt" hidden> <!-- input textbox-->

                            </div>

                            <div class="form-group">
                                <label> Nearest Center </label>
                                <input type="text" class="form-control" name="nearest_branch" id="nearest_branch" value="" readonly>
                            </div>
                        
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 

<script>

// Split Ids from dropdown
 function loadIdX(){
        var value=document.getElementById("city").value;
        var valuesplitted = value.split(",");
        var name = valuesplitted[0];
        var city_name = valuesplitted[1];
       

        document.getElementById("orderIdtxt").value = city_name;
        document.getElementById("nearest_branch").value = name;
        }


</script>
</body>
</html>