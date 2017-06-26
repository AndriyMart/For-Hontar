<?php
session_start();

define('DBHOST', 'localhost');
 define('DBUSER', 'root');
 define('DBPASS', '');
 define('DBNAME', 'election');
 //bd connection
$conn = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);

if ( !$conn ) {
  die("Connection failed : " . mysqli_error());
}
if(isset($_GET['delete'])){
  mysqli_query($conn, "DELETE FROM els WHERE id_elect ='".$_GET['delete']."'");
  header('Location:adminpanel.php');
  die();

}

$res=mysqli_query($conn,"SELECT * FROM els");

$els = array();
    while($rows = mysqli_fetch_array($res)) {

       // Записать значение столбца FirstName (который является теперь массивом $row)
      
        array_push($els, $rows);

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

<div class="row">
<?php foreach ($els as $one){ ?>
<div class="col-sm-4 col-md-3">
  <div class="thumbnail">
    <img src="<?=$one['pic_url']?>" alt="Card image cap" style = "width:300px; height:260px;" class="img-responsive center-block">
      <div class="caption center-block">
        <h3><?=$one['name']?></h3>
        <p>Organisation:<?=$one['organisation']?></p>
        <p>Description:<?=$one['description']?></p>
        <p>End date:<?=$one['finishdate']?></p>
        <p><a href="adminpanel.php?delete=<?=$one['id_elect']?>" class="btn btn-primary" role="button">Delete</a> <a href="addpersons.php?edit=<?=$one['id_elect']?>" class="btn btn-default" role="button">Edit</a></p>
      </div>
    </div>
  </div>
<?php }?>
</div>
</body>
</html>