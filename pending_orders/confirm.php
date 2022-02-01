<?php
// start the session
session_start();
if (isset($_POST['submit'] )) 
{
 $name = $_POST['name'];
 $_SESSION['name'] = $name;
}
?>

<?php
// Include config file
$db = mysqli_connect('localhost', 'root', '', 'pickandgo');
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirm Branch</title>
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
                    <h2 class="mt-5">Select Your Branch</h2>
                    <form action="index.php" method="post">
                        <div class="form-group">
                            <label>Branch Name</label>
                            <select name="name" class="form-control" id="name">
                                <option></option>
                                <?php
                                $sql2="SELECT name FROM operational_centers";
                                   $res=$db->query($sql2);
                                    while($row=$res->fetch_assoc()){
                                    echo "<option value='".$row['name']."'>".$row['name']."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                        <a href="../manager/manager.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>

                    
                </div>
            </div>        
        </div>
    </div>
</body>
</html>