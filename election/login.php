<?php

session_start();

 $error = ' ';

if(isset($_POST["submit"])){//works only after submiting form

include("database.php");
 //bd connection
$conn = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);

if ( !$conn ) {
  die("Connection failed : " . mysqli_error());
}

$email = $_POST['email'];
$password = $_POST['studentid'];


if($email == null){

$_SESSION['errorel'] = "Incorrect Credentials, Try again...";
header("Location:index.php");

}else{
//$password = hash('sha256', $pass); 
// password hashing using SHA256 
//safety first)
//query
$res=mysqli_query($conn,"SELECT * FROM voters WHERE email='$email'");
$row=mysqli_fetch_array($res);

if($row['student_id']==$password ) {
    $_SESSION['isvoter'] = '1';
    $_SESSION['emailvoter'] = $row['email'];
    header("Location:viewel.php");
    $_SESSION['errorel'] = "Done";
   } else {
   	header("Location:index.php");
    $_SESSION['errorel'] = "Incorrect Credentials, Try again...";
   }
 }
}
?>