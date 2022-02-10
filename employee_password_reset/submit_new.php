<?php
$db = mysqli_connect('localhost', 'root', '', 'pickandgo');
if(isset($_POST['continue']) && $_POST['email'] && $_POST['password'])
{
  $email=$_POST['email'];
  $pass=$_POST['password'];
                $hashed = password_hash($pass, PASSWORD_DEFAULT);
    
  mysqli_query($db, "UPDATE employee SET password='$hashed' WHERE `email`='{$email}' ");
  
  $_SESSION['message'] =  "$hashed";
    echo "Passowrd Reset Successfull! Please open the website in a new tab and login again!<br>";
    echo $_SESSION['message'];
    echo '<script language="javascript">';
    echo 'alert("Password updated successfully!!")';

    
  
  
}
?>