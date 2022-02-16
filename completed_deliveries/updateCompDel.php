<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update</title>
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
        <div class="">
            <div class="row">
                <div class="col-md-12">
                    <center><h2 class="mt-5 mb-3">Update Images</h2></center>
                        <form action="configComDel.php" method="post">
                                    <?php
                                        if($_GET['picked_id']){
                                            $conn = mysqli_connect("localhost", "root", "", "pickandgo");
                                            // Client requesting image, so retrieve it from DB
                                            $id = $_GET['picked_id'];
                                            $select = "SELECT * FROM completed_deliveries WHERE picked_id ='$id'";

                                            $run = mysqli_query($conn, $select);
                                            while ($row = mysqli_fetch_array($run)) {
                                                $signature = $row['signature_url'];
                                                $photo = $row['photo_url'];
                                        }
                                    ?>
                                <center>
                                    <div class="col-md-10 mt3">
                                        <div class="card" style="">
                                            <img class="card-img-top" src="../image_upload/<?php echo $signature;?>" alt="Card image cap">
                                                <div class="card-body">
                                                    <input type="file" class="form-control" name="signatureURL" id="signatureURL"/>
                                                </div>
                                        </div>


                                        <div class="card" style="">
                                            <img class="card-img-top" src="../image_upload/<?php echo $photo;?>" alt="Card image cap">
                                                <div class="card-body">
                                                    <input type="file" class="form-control" name="photo" id="photo"/>
                                                </div>
                                        </div>
                                    </div>

                                    <?php } ?>

                                    <div class="mb-5">
                                
                                    <div class="mt-3">
                                        <input type="Submit" class="btn btn-primary" name="updateImages" value="Update">
                                        <a href="compOrdrTable.php" class="btn btn-secondary ml-2">Cancel</a>
                                    </div>
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