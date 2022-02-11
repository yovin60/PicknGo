<?php
session_start();
$centerid = $_SESSION['cname'];
$cname = $_SESSION['center'];
?>
<?php
// // Include config file
// $db = mysqli_connect('localhost', 'root', '', 'pickandgo');
 
// // Define variables and initialize with empty values
// $center = $name ="";
// $center_err = $name_err ="";
 
// // Processing form data when form is submitted
// if($_SERVER["REQUEST_METHOD"] == "POST")
// {
//     // Validate center
//     $input_center = trim($_POST["center_id"]);
//     if(empty($input_center)){
//         $center_err = "Please enter a valid center.";
//     } else{
//         $center = $input_center;
//     }
    
//     // Validate name
//     $input_name = trim($_POST["city_name"]);
//     if(empty($input_name)){
//         $name_err = "Please enter a name.";     
//     } else{
//         $name = $input_name;
//     }

//     // Check input errors before inserting in database
//     if(empty($center_err) && empty($name_err)){
//         // Prepare an insert statement
//         $sql = "INSERT INTO cities (center_id, city_name) VALUES (?, ?)";
//         if($stmt = mysqli_prepare($db, $sql)){
//             // Bind variables to the prepared statement as parameters
//             mysqli_stmt_bind_param($stmt, "ss", $param_center, $param_name);
//             // Set parameters
//             $param_center = $center;
//             $param_name = $name;
//             // Attempt to execute the prepared statement
//             if(mysqli_stmt_execute($stmt))
//             {
//                 // Records created successfully. Redirect to landing page
//                 header("location: index.php");
//                 exit();
//             } 
//             else
//             {
//                 echo '<script language="javascript">';
//                 echo 'alert("Please Check your Detials and try again!")';
//                 echo'</script>';        
//                 echo "<script> location.href='create.php';</script>";
//                 exit;
//             }
//         }    
//         // Close statement
//         mysqli_stmt_close($stmt);
//     }
//     // Close connection
//     mysqli_close($db);
// }

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pickup</title>
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
                    <center><h2 class="mt-5 mb-3">Add a pickup</h2></center>
                    <!-- <p>Please fill this form and submit to add City record to the database.</p> -->
                    <form action="configPickup.php" method="post">

                        <div class="form-group">
                            <div class="form-group">
                                <label> Picked Id</label>
                                <input type="text" class="form-control" name="pickedId" value="<?php echo uniqid(); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label> Oreder Id</label>
                                <select name="orderId" class="form-control" id="orderId">
                                    <option> - select -</option>

                                    <?php
                                        $conn = mysqli_connect("localhost", "root", "", "pickandgo");
                                        $select = "SELECT * FROM pickup_orders INNER JOIN customer ON pickup_orders.cus_id = customer.cus_id WHERE status = 'APPROVED' && pickup_orders.nearest_center = '{$centerid}'";
                                        $run = mysqli_query($conn, $select);
                                        while ($row = mysqli_fetch_array($run)) {
                                            $center_id = $row['order_id'];
                                            $center_name = $row['cus_name'];
                                    ?>
                                        <option value="<?php echo $center_id;?>"><?php echo $center_id. ' - ' .$center_name; ?></option>


                                    
                                    <?php }
                                    ?>
                                </select>
                                    <span class="invalid-feedback"><?php echo $center_err;?></span>
                            </div>
                            <div class="form-group">
                                <label>Center</label>
                                
                                <select name="center_id" class="form-control" id="center_id">
                                    <option> - select -</option>
                                    <?php
                                    // $sql2="SELECT * FROM operational_centers";
                                    // $res=$db->query($sql2);
                                    //     while($row=$res->fetch_assoc()){
                                    //     echo "<option value='".$row['center_id']."'>".$row['name']."</option>";
                                    //     }
                                    ?>

                                    <?php
                                        $conn = mysqli_connect("localhost", "root", "", "pickandgo");
                                        $select = "SELECT * FROM operational_centers WHERE center_id = '{$cname}'";
                                        $run = mysqli_query($conn, $select);
                                        while ($row = mysqli_fetch_array($run)) {
                                            $center_id = $row['center_id'];
                                            $center_name = $row['name'];
                                    ?>
                                        <option value="<?php echo $center_id;?>"><?php echo $center_name; ?></option>


                                    
                                    <?php }
                                    ?>
                                </select>
                                    <span class="invalid-feedback"><?php echo $center_err;?></span>
                            </div
                            ><div class="form-group">
                                <label> Weight</label>
                                <input type="text" class="form-control" name="weight" id="weight" oninput="multiply(this.value);">
                                                                                        <input type="text" id="per1kg" name="per1kg" value="80" hidden>
                                                                                        <input type="text" id="kgPrice" name="kgPrice" hidden>


                            </div>
                            <div class="form-group">
                                <label> Type</label>
                                <select name="type" class="form-control" id="type" onchange="pakcageType()">
                                    <option> - select -</option>
                                    <option value="FRAGILE,100"> FRAGILE </option>
                                    <option value="NON FRAGILE, 0"> NON FRAGILE </option>
                                </select>
                                                                                        <input type="text" id="typeName" name="typeName" hidden>
                                                                                        <input type="text" id="typePrice" name="typePrice" hidden>

                            </div>
                            <div class="form-group">
                                <label> Size</label>
                                <select name="size" class="form-control" id="size" onchange="pakcageSize()">
                                    <option> - select -</option>
                                    <option value="LARGE,100"> LARGE </option>
                                    <option value="MEDIUM,80"> MEDIUM </option>
                                    <option value="SMALL,40"> SMALL </option>
                                </select>
                                                                                        <input type="text" id="sizeName" name="sizeName" hidden>
                                                                                        <input type="text" id="sizeprice" name="sizeprice" hidden>
                            </div>
                            <div class="form-group">
                                <label> Distance</label>
                                <select name="distance" class="form-control" id="distance" onchange="distancePriceX()">
                                    <option> - select -</option>
                                    <option value="20,0"> 0 - 20KM </option>
                                    <option value="20-30,200"> 20KM - 30KM </option>
                                    <option value="30-40,300"> 30KM - 40KM </option>
                                    <option value="40-50,400"> 40KM - 50KM </option>
                                    <option value="50 UP,800"> More than 50KM </option>


                                </select>
                                                                                        <input type="text" id="distanceType" name="distanceType" hidden>
                                                                                        <input type="text" id="distancePrice" name="distancePrice" hidden>

                            </div>
                            <div class="form-group">
                                <label> Total price</label>
                                <input type="text" class="form-control" name="totalPrice" id="totalPrice">
                            </div>
<!-- MDADD -->
                            <div class="mb-5">
                                <center>
                                    <input type="submit" class="btn btn-primary" name="Pick" value="Submit">
                                    <a href="javascript:history.back(1)" class="btn btn-secondary ml-2">Cancel</a>
                                </center>
                            </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 

<script>
    // Split ticket type values and disable each seat types once
 function pakcageType(){
        var value=document.getElementById("type").value;
        var valuesplitted=value.split(",");
        var typeName=valuesplitted[0];
        var typeprice=valuesplitted[1];

        document.getElementById("typeName").value=typeName;
        document.getElementById("typePrice").value=typeprice;
}

 function pakcageSize(){
        var value=document.getElementById("size").value;
        var valuesplitted=value.split(",");
        var sizetype=valuesplitted[0];
        var sizeprice=valuesplitted[1];
        
        document.getElementById("sizeName").value=sizetype;
        document.getElementById("sizeprice").value=sizeprice;
 }

// Calculate total price
 function distancePriceX(){
        var value=document.getElementById("distance").value;
        var valuesplitted=value.split(",");
        var distanceType=valuesplitted[0];
        var distancePrice=valuesplitted[1]; 

        document.getElementById("distanceType").value=distanceType;
        document.getElementById("distancePrice").value=distancePrice;

        // var textValue1 = document.getElementById('kgPrice').value;
        // var textValue2 = document.getElementById('typePrice').value;
        // var textValue3 = document.getElementById('sizeprice').value;
        // var textValue4 = document.getElementById('distancePrice').value;

        var textValue1 = parseInt(document.getElementById("kgPrice").value);
        var textValue2 = parseInt(document.getElementById("typePrice").value);
        var textValue3 = parseInt(document.getElementById("sizeprice").value);
        var textValue4 = parseInt(document.getElementById("distancePrice").value);



        document.getElementById('totalPrice').value = textValue1 + textValue2 + textValue3 + textValue4;

    }

// Multiply weights
 function multiply()
    {
    var textValue1 = document.getElementById('weight').value;
    var textValue2 = document.getElementById('per1kg').value;

    document.getElementById('kgPrice').value = textValue1 * textValue2;
    }

</script>

</body>


</html>