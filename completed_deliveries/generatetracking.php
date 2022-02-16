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
        $result = mysqli_query($db, "SELECT * FROM pickedup_items INNER JOIN pickup_orders ON pickedup_items.order_id = pickup_orders.order_id WHERE pickedup_items.picked_id='{$id}'");

        while($row = mysqli_fetch_array($result))
                {
                  $location= $row['receiver_address'];
                  
                }

        $sql = "UPDATE tracking SET status='DELIVERED', location='{$location}' WHERE picked_id='{$id}'";
  
        if (mysqli_query($db,$sql)) {
            
            echo "<script> 
            alert('Tracking Generated Successfully!');
            window.location.href='compOrdrTable.php';
            </script>";

        } 

        else 

        {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

?>
        
        