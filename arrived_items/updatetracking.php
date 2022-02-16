<?php
session_start();
$centerid=$_SESSION['center'];
$cname = $_SESSION['cname'];
?>

<?php
    if(isset($_GET["picked_id"]) && !empty(trim($_GET["picked_id"]))){
        // Get URL parameter
        $id =  trim($_GET["picked_id"]);
        $status = 'ARRIVED';

        $db = mysqli_connect('localhost', 'root', '', 'pickandgo');
        $sql = "UPDATE tracking SET status='{$status}', location='{$cname}' WHERE picked_id='{$id}'";
  
        if (mysqli_query($db,$sql)) {
            
            echo "<script> 
            alert('Tracking Updated Successfully!');
            window.location.href='index.php';
            </script>";

        } 

        else 

        {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

?>
        
        