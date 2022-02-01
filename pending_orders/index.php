<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pending Orders</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 0 auto;
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
                        <h2 class="pull-left">Pending Orders</h2>
                    </div>
                    
                    <?php
                    $name="";
                    if (isset($_POST['name'] )) 
                        {
                        $name = $_POST['name'];
                        $_SESSION['branchname']=$name;
                       
                        }
                        else{
                            $name=$_SESSION['branchname'];
                        }

                    // DB Connect
                    $db = mysqli_connect('localhost', 'root', '', 'pickandgo');

                    // Attempt select query execution
                    $sql = "SELECT * FROM pickup_orders WHERE nearest_center = '{$name}' && status='PENDING'";
                    if($result = mysqli_query($db, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Order_ID</th>";
                                        echo "<th>Cus_ID</th>";
                                        echo "<th>Order_Name</th>";
                                        echo "<th>Timestamp</th>";
                                        echo "<th>Pickup Address</th>";
                                        echo "<th>Availability</th>";
                                        echo "<th>Receiver Name</th>";
                                        echo "<th>Receiver Address</th>";
                                        echo "<th>Receiver Number</th>";
                                        echo "<th>Nearest Center</th>";
                                        echo "<th>Status</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['order_id'] ."</td>";
                                        echo "<td>" . $row['cus_id'] ."</td>";
                                        echo "<td>" . $row['order_name'] ."</td>";
                                        echo "<td>" . $row['date_time'] ."</td>";
                                        echo "<td>" . $row['pickup_address'] ."</td>";
                                        echo "<td>" . $row['availability'] . "</td>";
                                        echo "<td>" . $row['receiver_name'] . "</td>";
                                        echo "<td>" . $row['receiver_address'] . "</td>";
                                        echo "<td>" . $row['receiver_contactno'] . "</td>";
                                        echo "<td>" . $row['nearest_center'] . "</td>";
                                        echo "<td>" . $row['status'] . "</td>";
                                        echo "<td>";
                                            echo '<a href="read.php?order_id='. $row['order_id'] .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update.php?order_id='. $row['order_id'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete.php?order_id='. $row['order_id'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
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
                </center>
                </div>
                   <p><a href="confirm.php" class="btn btn-secondary ml-2">Back</a></p>
                </div>
                </center>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>