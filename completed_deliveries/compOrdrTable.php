<?php
session_start();
$centerid = $_SESSION['cname'];
$emp = $_SESSION['emp_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 0 autp;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 0 auto;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Completed Deliveries</h2>
                        <a href="indexCompl.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Complete next Delivery</a>
                    </div>
                    <?php
                    
                    // DB connect
                    $db = mysqli_connect('localhost', 'root', '', 'pickandgo');
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM ((completed_deliveries 
                        INNER JOIN pickup_orders ON completed_deliveries.order_id = pickup_orders.order_id) 
                        INNER JOIN employee ON completed_deliveries.emp_id = employee.emp_id) WHERE completed_deliveries.emp_id = '{$emp}'";
                    if($result = mysqli_query($db, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Delivered Id</th>";
                                        echo "<th>Picked ID</th>";
                                        echo "<th>Order Name</th>";
                                        echo "<th>Receiver Name</th>";
                                        echo "<th>Receiver Address</th>";
                                        echo "<th>Driver</th>";
                                        echo "<th>Delivered Time</th>";
                                        echo "<th>Signature</th>";
                                        echo "<th>Receiver's image</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['deliver_id'] ."</td>";
                                        echo "<td>" . $row['picked_id'] ."</td>";
                                        echo "<td>" . $row['order_name'] ."</td>";
                                        echo "<td>" . $row['receiver_name'] ."</td>";
                                        echo "<td>" . $row['receiver_address'] ."</td>";
                                        echo "<td>" . $row['emp_name'] ."</td>";
                                        echo "<td>" . $row['delivered_time'] ."</td>";
                                        echo "<td>" . $row['signature_url'] ."</td>";
                                        echo "<td>" . $row['photo_url'] ."</td>"; 
                                    

                                        
                                        echo "<td>";
                                            
                                            echo '<a href="updateCompDel.php?picked_id='. $row['picked_id'] .'" class="mr-3" title="View Images" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="generatetracking.php?picked_id='. $row['picked_id'] .'" class="mr-3" title="update tracking" data-toggle="tooltip"><span class="fa fa-spinner fa-pulse"></span></a>';
        
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
 
                    // Close connection
                    mysqli_close($db);
                    ?>
                </div>
                    <p><a href="../driver/driver.php" class="btn btn-primary ml-3">Back</a></p>
                </div>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>