<?php
session_start();
$centerid = $_SESSION['center'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vehicles</title>
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
                        <h2 class="pull-left">Vehicles</h2>
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Vehicle</a>
                    </div>
                    <?php
                    // DB connect
                    $db = mysqli_connect('localhost', 'root', '', 'pickandgo');
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM ((vehicles INNER JOIN operational_centers ON vehicles.center_id = operational_centers.center_id) INNER JOIN employee ON vehicles.emp_id = employee.emp_id) WHERE vehicles.center_id = '{$centerid}' ";
                    if($result = mysqli_query($db, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Vehicle ID</th>";
                                        echo "<th>Center</th>";
                                        echo "<th>Driver</th>";
                                        echo "<th>Vehicle Model</th>";
                                        echo "<th>Registration No</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['vehicle_id'] ."</td>";
                                        echo "<td>" . $row['name'] ."</td>";
                                        echo "<td>" . $row['emp_name'] ."</td>";
                                        echo "<td>" . $row['vehicle_name'] ."</td>";
                                        echo "<td>" . $row['reg_no'] ."</td>";
                                        
                                        echo "<td>";
                                            echo '<a href="read.php?vehicle_id='. $row['vehicle_id'] .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update.php?vehicle_id='. $row['vehicle_id'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete.php?vehicle_id='. $row['vehicle_id'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
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
                    <p><a href="../manager/manager.php" class="btn btn-primary ml-3">Back</a></p>
                </div>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>