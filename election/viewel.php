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

if(isset($_GET['more'])){
  $query = "SELECT pic_url, name, description, id_cand, id_el, votes  FROM cands WHERE id_el = '".$_GET['more']."'";
  $res = mysqli_query($conn, $query);
}else{
header('Location:main.php');
}
$candidates = array();
    while($rows = mysqli_fetch_array($res)) {

       // Записать значение столбца FirstName (который является теперь массивом $row)
      
        array_push($candidates, $rows);

      } 
    $query1 = "SELECT email, name, student_id, id_voter, id_elect FROM voters WHERE id_elect = '".$_GET['more']."'";
  $res1 = mysqli_query($conn, $query1);
$voters = array();
    while($rows1 = mysqli_fetch_array($res1)) {

       // Записать значение столбца FirstName (который является теперь массивом $row)
      
        array_push($voters, $rows1);

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
    <div class="col-sm-12 cold-md-2 col-md-offset-5" style="text-align:centre">
      <h1 class = "col-lg-2 offset-lg-5"> Candidates </h1>
    </div>
  </div>

  <div class="row">
    <?php foreach ($candidates as $one){ ?>
    <div class="col-sm-6 col-md-4">
      <div class="thumbnail">
        <img class="card-img-top" src="<?=$one['pic_url']?>" alt="Card image cap" style = "width:300px; height:260px;">
        <div class="card-block" style="padding:10px;">
          <h4 class="card-title"><?=$one['name']?></h4>
          <p class="card-text">Description:<?=$one['description']?></p>
          <p class="card-text">Votes:<?=$one['votes']?></p>
        </div>
      </div>
    </div>
    <?php }?>
  </div>

  <div class="row">
    <table class="table">
      <thead>
        <tr>
          <th>Delete</th>
          <th>Email</th>
          <th>Name</th>
          <th>Student ID</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($voters as $one){ ?>
        <tr>
          <td><a href="addpersons.php?edit=<?=$one['id_elect']?>&delv=<?=$one['id_voter']?>" class="btn btn-danger btn-lg"><span class="glyphicon glyphicon-remove"></span></a></td>
          <td><?=$one['name']?></td>
          <td><?=$one['email']?></td>
          <td><?=$one['student_id']?></td>
        </tr>
        <?php }?>
      </tbody>
    </table>
  </div>
  <div class="row">
    <?php if(isset($_GET['more'])){?>
    <a href="archive.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Finish</a>
    <?php }else{ ?>
    <a href="index.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Finish</a>
    <?php } ?>
  </div>

</div>

</body>
</html>