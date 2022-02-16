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
            width: 1000px;
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
                        <h2 class="pull-left">Tracking Details</h2>
                        
                    </div>
                    
                    <?php

                    if(isset($_GET['continue']) && $_GET['picked_id'])
                    {
    
                    $id = $_GET['picked_id'];

                    // DB connect
                    $db = mysqli_connect('localhost', 'root', '', 'pickandgo');
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM tracking WHERE tracking.picked_id = '{$id}' ";

                    if($result = mysqli_query($db, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Tracking ID</th>";
                                        echo "<th>Current Location</th>";
                                        echo "<th>Status</th>";
                                        
                                        
                                        
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['picked_id'] ."</td>";
                                        echo "<td>" . $row['location'] ."</td>";
                                        echo "<td>" . $row['status'] ."</td>";
                                        
                                        
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

                }
 
                    // Close connection
                    mysqli_close($db);
                    
                    ?>
                </div>
                   <p> <a href="javascript:history.back(1)" class="btn btn-info ml-3">Back</a></p>
                </div>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>