<?php
session_start();
$centerid = $_SESSION['cname'];
$cname = $_SESSION['center'];
$driver = $_SESSION['emp_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delivery</title>
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
                    <center><h2 class="mt-5 mb-3">Completed deliveries</h2></center>
                    <!-- <p>Please fill this form and submit to add City record to the database.</p> -->
                    <form action="configComDel.php" method="post">

                        <div class="form-group">
                          
                            <div class="form-group">
                                <label>Oreder Id</label>
                                <!-- <input type="text" class="form-control" name="orderId" id="orderId"> -->
                                <select class="form-control" name="orderId" id="orderId" onchange="loadIdX();">
                                    <option> - select - </option>
                                <?php
                                        $conn = mysqli_connect("localhost", "root", "", "pickandgo");
                                        $select = "SELECT * FROM arrived_items INNER JOIN pickup_orders ON arrived_items.order_id = pickup_orders.order_id WHERE arrived_items.driver_id = '{$driver}'";
                                        $run = mysqli_query($conn, $select);
                                        while ($row = mysqli_fetch_array($run)) {
                                            $order_id = $row['order_id'];
                                            $arrived_id = $row['arrived_id'];
                                            $picked_id = $row['picked_id'];
                                            $emp_id = $row['driver_id'];
                                            $load_id = $row['load_id'];
                                            $route_id = $row['route_id'];
                                            $center_id = $row['center_id'];
                                            $receiver = $row['receiver_name'];


                                    ?>
                                        <option value="<?php echo $order_id;?>,<?php echo $arrived_id;?>,<?php echo $picked_id;?>,<?php echo $emp_id;?>,<?php echo $load_id;?>,<?php echo $route_id;?>"><?php echo $order_id.'-'.$receiver; ?></option>

                                    <?php }
                                    ?>
                                </select>
                                                                                                                        <input type="text" name="orderIdtxt" id="orderIdtxt" hidden> <!-- input textbox-->

                            </div>

                            <div class="form-group">
                                <label> Arrived Id</label>
                                <input type="text" class="form-control" name="arriverId" id="arriverId" value="" readonly>
                            </div>
                            <div class="form-group">
                                <label> Picked Id</label>
                                <input type="text" class="form-control" name="pickedId" id="pickedId" value="" readonly>
                            </div>
                            <div class="form-group">
                                <label> Employee Id</label>
                                <input type="text" class="form-control" name="empId" id="empId" value="" readonly>
                            </div>
                            <div class="form-group">
                                <label> Load Id</label>
                                <input type="text" class="form-control" name="loadId" id="loadId" value="" readonly> 
                            </div>
                            <div class="form-group">
                                <label> Route Id</label>
                                <input type="text" class="form-control" name="routId" id="routId" value="" readonly> 
                            </div>
                            <div class="form-group col-md-8 mt-3">
                                <label> Signature URL</label>
                                <input type="file" class="form-control" name="signatureURL" id="signatureURL" required/>
                            </div>
                            <div class="form-group col-md-8 mt-3">
                                <label> Photo</label>
                                <input type="file" class="form-control" name="photo" id="photo" required/>
                            </div>


                            <div class="mb-5">
                                <center>
                                    <input type="submit" class="btn btn-primary" name="Complete" value="Submit">
                                    <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                                </center>
                            </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 

<script>

// Split Ids from dropdown
 function loadIdX(){
        var value=document.getElementById("orderId").value;
        var valuesplitted = value.split(",");
        var order_id = valuesplitted[0];
        var arrived_id = valuesplitted[1];
        var picked_id = valuesplitted[2];
        var emp_id = valuesplitted[3];
        var load_id = valuesplitted[4];
        var route_id = valuesplitted[5];

        document.getElementById("orderIdtxt").value = order_id;
        document.getElementById("arriverId").value = arrived_id;
        document.getElementById("pickedId").value = picked_id;
        document.getElementById("empId").value = emp_id;
        document.getElementById("loadId").value = load_id;
        document.getElementById("routId").value = route_id;

}

</script>

</body>


</html>