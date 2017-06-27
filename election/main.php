<?php
session_start();
unset($_SESSION['errorel']);
define('DBHOST', 'localhost');
 define('DBUSER', 'root');
 define('DBPASS', '');
 define('DBNAME', 'election');
 //bd connection
$conn = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);

if ( !$conn ) {
  die("Connection failed : " . mysqli_error());
}
$emailvoter = $_SESSION['emailvoter'];
$res=mysqli_query($conn,"SELECT * FROM els WHERE id_elect IN (SELECT id_elect FROM voters WHERE email = '$emailvoter' ) AND status < 1");

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
          <img src="<?=$one['pic_url']?>" alt="...">
          <div class="caption">
            <h3><?=$one['name']?></h3>
            <p>Organisation:<?=$one['organisation']?></p>
            <p>Description:<?=$one['description']?></p>
            <p>End date:<?=$one['finishdate']?></p>
            <p>
            <?php 
        $id_elec = $one['id_elect'];
        $emailvoter = $_SESSION['emailvoter'];
        $res=mysqli_query($conn,"SELECT * FROM voters WHERE id_elect = '$id_elec' AND email = '$emailvoter'");
      $vote = array();
        while($rows = mysqli_fetch_array($res)) {

           // Записать значение столбца FirstName (который является теперь массивом $row)
          
            array_push($vote, $rows);

          }
        foreach ($vote as $one1){
          $ifvote = $one1['status'];
        }
        if($ifvote == 0){
         ?>
            <a href="vote.php?vote=<?=$one['id_elect']?>" class="btn btn-primary" role="button">Vote</a>
            <?php }?>
            </p>
          </div>
        </div>
      </div>
    <?php }?>
  </div>
</div>

</body>
</html>