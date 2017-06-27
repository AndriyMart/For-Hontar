<?php
session_start();

include("database.php");
 //bd connection
$conn = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);

if ( !$conn ) {
  die("Connection failed : " . mysqli_error());
}
if(isset($_GET['delete'])){
  mysqli_query($conn, "DELETE FROM admins WHERE id_admin ='".$_GET['delete']."'");
  header('Location:adminpanel.php');
  die();

}

$res=mysqli_query($conn,"SELECT * FROM admins");

$admins = array();
    while($rows = mysqli_fetch_array($res)) {

       // Записать значение столбца FirstName (который является теперь массивом $row)
      
        array_push($admins, $rows);

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
    <?php foreach ($admins as $one){ 
      require_once 'googleLib/GoogleAuthenticator.php';
      $ga = new GoogleAuthenticator();
      $secret = $one['google_auth'];
      $email = $one['email'];
      $qrCodeUrl = $ga->getQRCodeGoogleUrl($email, $secret,'VOTE KMA');
    ?>

    <div class="col-sm-6 col-md-4">
      <div class="thumbnail">
        <img class="card-img-top" src="<?=$qrCodeUrl?>" alt="Card image cap" style = "width:80%;">
        <div style="padding: 10px;">
          <h4 class="card-title"><?=$one['name']?></h4>
          <p class="card-text">Email:<?=$one['email']?></p>
          <a href="adminpanel.php?delete=<?=$one['id_admin']?>" class="btn btn-primary" role="button">Delete</a>
        </div>
      </div>
    </div>
    <?php }?>
  </div>
</div>

</body>
</html>