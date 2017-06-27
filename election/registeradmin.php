<?php
 session_start();


 if(isset($_SESSION['erroradm'])){
  $error = $_SESSION['erroradm'];
 }else{
 $error = '';}

include("database.php");
 
$conn = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);


 if ( !$conn ) {
  die("Connection failed : " . mysql_error());
 }
 
 if ( !$conn ) {
  die("Database Connection failed : " . mysql_error());
 }
if(isset($_POST['nameadm'])){
$pass = $_POST['passadm'];
$cpass = $_POST['cpassadm'];
$name = $_POST['nameadm'];
$email = $_POST['emailadm'];
if($pass != $cpass){
  $_SESSION['erroradm'] = 'Wrong password confirmation';
  header("Location: registeradmin.php");
}else{
require_once 'googleLib/GoogleAuthenticator.php';
$ga = new GoogleAuthenticator();
$secret = $ga->createSecret();

// password encrypt using SHA256();
  $password = hash('sha256', $pass);

$query = "INSERT INTO admins (name, email, password, google_auth) VALUES ('$name', '$email', '$password', '$secret')";
$res = mysqli_query($conn, $query);
if($res){
  unset($_SESSION['erroradm']);
   header("Location: registeradmin.php");
}
else{
  echo $secret;
  echo $name;
  echo $email;
  echo $password;
}
}
}
?>
<html>
<head>
    <!-- Basic Page Needs
    ================================================== -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <title>NaUKMA Eelection</title>
    <meta name="description" content="Sistem Pencalonan MPP ILP Ledang">
    <meta name="keywords" content="">
    <meta name="author" content="">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css"  href="css/index.css">
    <script src="js/jquery.js"></script>
    <script src="js/tether.js"></script>
    <script src="js/bootstrap.js"></script>
</head>
<body>
<?php include("navbar.php");?>
<div class="task col-lg-6 col-lg-offset-3" " style = "margin-top:50px;">
<form action="registeradmin.php" method="post" enctype="multipart/form-data" >
  <div class="form-group">
    <label for="nameadm">Name</label>
    <input type="name" class="form-control" name = "nameadm" id="nameadm" placeholder="Name">
  </div>
  <div class="form-group">
    <label for="emailadm">Email</label>
    <input type="email" class="form-control" name = "emailadm" id="emailadm" placeholder="Email">
  </div>
  <div class="form-group">
    <label for="passadm">Password</label>
    <input type="password" class="form-control" name = "passadm" id="passadm" placeholder="Password">
  </div>
  <div class="form-group">
    <label for="cpassadm">Confirm Password</label>
    <input type="password" class="form-control" name = "cpassadm" id="cpassadm" placeholder="Password">
  </div>
  <button type="submit" name = "submit" class="btn btn-primary" style="background-color:#e6eeff; color:black; border-color:#80aaff;">Submit</button>
  <p class = "errormas text-center" style = "color:#ff9999;"><br><br><?php echo $error?></p>


</form>
</div>
</body>
</html>