<?php

session_start();

define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBNAME', 'election');
 //bd connection
$conn = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);
mysqli_set_charset($conn,"utf8_unicode_ci");
$error = ' Problem with connection to db';

if(isset($_GET['dovote'])){
  $query = "SELECT votes  FROM cands WHERE id_cand = '".$_GET['dovote']."'";
  $res = mysqli_query($conn, $query);
  $row=mysqli_fetch_array($res);
  $votes=($row['votes'] + 1);
  $query = "UPDATE cands SET votes = '$votes' WHERE id_cand = '".$_GET['dovote']."' ";
  $res1 = mysqli_query($conn, $query);
  if($res1){
  	$message = "Thank you for your vote.";
  } else{
  	$message = "Something is wrong. Try again later.";
  }
}else{
header('Location:main.php');
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
    <!-- Bootstrap -->
    
    <!-- CSS -->
    <link rel="stylesheet" type="text/css"  href="css/index.css">
    <script src="js/jquery.js"></script>
    <script src="js/tether.js"></script>
    <script src="js/bootstrap.js"></script>
</head>
<body>

<?php include("navbar.php");?>

<div class="container">
  <div class="row">
    <div class="col-sm-12 cold-md-4 col-md-offset-4" style="text-align:centre">
      <h1><?php echo $message ?></h1>
    </div>
  </div>
</div>
</body>
</html>