<?php

$username = $_POST['username'];
$email  = $_POST['email'];
$password1= $_POST['password1'];
$repassword = $_POST['repassword'];




if (!empty($username) || !empty($email) || !empty($password1) || !empty($repassword) )
{

$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "register";



// Create connection
$conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);

if (mysqli_connect_error()){
  die('Connect Error ('. mysqli_connect_errno() .') '
    . mysqli_connect_error());
}
else{
  $SELECT = "SELECT email From registration Where email = ? Limit 1";
  $INSERT = "INSERT Into registration (username , email , password1 , repassword )values(?,?,?,?)";

//Prepare statement
     $stmt = $conn->prepare($SELECT);
     $stmt->bind_param("s", $email);
     $stmt->execute();
     $stmt->bind_result($email);
     $stmt->store_result();
     $rnum = $stmt->num_rows;

     //checking username
      if ($rnum==0) {
      $stmt->close();
      $stmt = $conn->prepare($INSERT);
      $stmt->bind_param("ssss", $username,$email,$password1,$repassword);
      $stmt->execute();
      echo "New record inserted sucessfully";
     } else {
      echo "Someone already register using this email";
     }
     $stmt->close();
     $conn->close();
    }
} else {
 echo "All field are required";
 die();
}
?>