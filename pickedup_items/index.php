<?php
session_start();
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
                        <h2 class="pull-left">Pickup Orders</h2>
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> New Pickup</a>
                    </div>
                    <?php
                    $name="";
                    if (isset($_POST['center_id'] )) 
                        {
                        $name = $_POST['center_id'];
                        $_SESSION['center_id']=$name;
                       
                        }
                        else{
                            $name=$_SESSION['center_id'];
                        }
                    // DB connect
                    $db = mysqli_connect('localhost', 'root', '', 'pickandgo');
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM pickedup_items INNER JOIN operational_centers ON pickedup_items.center_id = operational_centers.center_id WHERE name = '{$name}'";
                    if($result = mysqli_query($db, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Picked ID</th>";
                                        echo "<th>Order ID</th>";
                                        echo "<th>Center</th>";
                                        echo "<th>Weight (Kg)</th>";
                                        echo "<th>Type</th>";
                                        echo "<th>Size</th>";
                                        echo "<th>Distance (Km)</th>";
                                        echo "<th>Price (Rs)</th>";
                                        echo "<th>Status</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['picked_id'] ."</td>";
                                        echo "<td>" . $row['order_id'] ."</td>";
                                        echo "<td>" . $row['name'] ."</td>";
                                        echo "<td>" . $row['weight'] ."</td>";
                                        echo "<td>" . $row['type'] ."</td>";
                                        echo "<td>" . $row['size'] ."</td>";
                                        echo "<td>" . $row['distance'] ."</td>";
                                        echo "<td>" . $row['price'] ."</td>";
                                        echo "<td>" . $row['status'] ."</td>";
                                        
                                        echo "<td>";
                                            echo '<a href="read.php?picked_id='. $row['picked_id'] .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update.php?picked_id='. $row['picked_id'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
        
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
                    <p><a href="../pickedup_items/confirm.php" class="btn btn-primary">Back</a></p>
                </div>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>