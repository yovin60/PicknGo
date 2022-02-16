<?php
if(isset($_POST['continue']) && $_POST['email'])
{
  mysql_connect('localhost','root','');
  mysql_select_db('pickandgo');
  $eml=$_POST['email'];
  $select=mysql_query("select email,password from customer where email='{$eml}'");
  if(mysql_num_rows($select)==1)
  {
    while($row=mysql_fetch_array($select))
    {
      $email=$row['email'];

      $pass=$row['password'];
    }
    $link="<a href='http://localhost/PicknGo/customer_password_reset/reset_pass.php?key=".$email."&reset=".$pass."'>Click To Reset password</a>";
    date_default_timezone_set('Etc/UTC');
    require("/PHPMailer-master/src/PHPMailer.php");
    require("/PHPMailer-master/src/SMTP.php");
    require("/PHPMailer-master/src/Exception.php");
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->CharSet =  "utf-8";
    $mail->IsSMTP();
    // enable SMTP authentication
    $mail->SMTPAuth = true;                  
    // GMAIL username
    $mail->Username = "amazingspidy99@gmail.com";
    // GMAIL password
    $mail->Password = "Spiderman1999@";
    $mail->SMTPSecure = "tls";  
    // sets GMAIL as the SMTP server
    $mail->Host = ('smtp.gmail.com');
    // set the SMTP port for the GMAIL server
    $mail->Port = "587";
    $mail->From='amazingspidy99@gmail.com';
    $mail->FromName='PicknGo';
    $mail->AddAddress($_POST['email'], 'reciever_name');
    $mail->Subject  =  'Reset Password';
    $mail->IsHTML(true);
    $mail->Body    = 'Click On This Link to Reset Password '.$link.'';
    if($mail->Send())
    {
      echo "Check Your Email and Click on the link sent to your email";
    }
    else
    {
      echo "Mail Error - >".$mail->ErrorInfo;
    }
  }	
}
?>