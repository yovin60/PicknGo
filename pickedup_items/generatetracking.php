<?php
session_start();
$centerid=$_SESSION['center'];
$cname = $_SESSION['cname'];
?>

<?php
    if(isset($_GET["picked_id"]) && !empty(trim($_GET["picked_id"]))){
        // Get URL parameter
        $id =  trim($_GET["picked_id"]);
        $status = 'PICKED';

        $db = mysqli_connect('localhost', 'root', '', 'pickandgo');
        $sql = "INSERT INTO tracking(picked_id, status, location)
        VALUES ('$id', '$status', '$cname')";
  
        if ($db->query($sql) === TRUE) {
            
            echo "<script> 
            alert('Tracking Generated Successfully!');
            window.location.href='index.php';
            </script>";

        } 

        else 

        {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

?>
        
        