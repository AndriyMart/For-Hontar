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

$res=mysqli_query($conn,"SELECT * FROM els WHERE status = 1");

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

<div class="container">
  <div class="row">
    <?php foreach ($els as $one){ ?>
      <div class="col-sm-6 col-md-4">
        <div class="thumbnail">
          <img src="<?=$one['pic_url']?>" alt="Card image cap" style = "width:260px; height:260px;">
            <div class="caption center-block">
              <h3><?=$one['name']?></h3>
              <p>Organisation:<?=$one['organisation']?></p>
              <p>Description:<?=$one['description']?></p>
              <p>End date:<?=$one['finishdate']?></p>
              <?php if(isset($_SESSION['isadmin'])){ ?>
                <p><a href="archive.php?delete=<?=$one['id_elect']?>" class="btn btn-primary" role="button">Delete</a> <a href="viewel.php?more=<?=$one['id_elect']?>" class="btn btn-default" role="button">More</a></p>
              <?php } ?>
            </div>
        </div>
      </div>
    <?php }?>
  </div>
</div>

<!--<div class="card-group">
<?php foreach ($els as $one){ ?>
<div class="card" style="width: 32px;">
  <img class="card-img-top" src="<?=$one['pic_url']?>" alt="Card image cap" style = "width:300px; height:260px;">
  <div class="card-block">
    <h4 class="card-title"><?=$one['name']?></h4>
    <p class="card-text">Organisation:<?=$one['organisation']?></p>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">Description:<?=$one['description']?></li>
  </ul>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">End date:<?=$one['finishdate']?></li>
  </ul>
  <?php if(isset($_SESSION['isadmin'])){ ?>
  <div class="card-block">
    <a href="archive.php?delete=<?=$one['id_elect']?>" class="card-link">Delete</a>
    <a href="viewel.php?more=<?=$one['id_elect']?>" class="card-link">More</a>
  </div>
  <?php } ?>
</div>
<?php }?>
</div>//-->
</body>
</html>