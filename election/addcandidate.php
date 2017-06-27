<?php

session_start();


include("database.php");
 //bd connection
$conn = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);
mysqli_set_charset($conn,"utf8_unicode_ci");

if(isset($_SESSION['errorcand'])){
  $error= $_SESSION['errorcand'];}else{
    $error = '';
  }
  
  $name = $_SESSION['name'];
$query1 = "SELECT id_elect FROM els WHERE name = '$name'";
$res1 = mysqli_query($conn, $query1);
$row=mysqli_fetch_array($res1);



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
    <div class="col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
    <form action="test.php" method="post" enctype="multipart/form-data" >
      <div class="form-group" style="visibility:hidden">
        <label for="id_el">ID els</label>
        <input type="name" class="form-control" name = "id_el" id="id_el" value = "<?=$row['id_elect']?>">
      </div>
      <div class="form-group">
        <label for="namecand">Name</label>
        <input type="name" class="form-control" name = "namecand" id="namecand" placeholder="Name">
      </div>
      <div class="form-group">
        <label for="textarea">Description</label>
        <textarea class="form-control" name = "descand" id="descand" rows="3"></textarea>
      </div>
      <div class="form-group">
        <label for="inputfile">Logo input</label>
        <input type="file" class="form-control-file" name="fileToUpload" id="fileToUpload" aria-describedby="fileHelp">
        <small id="fileHelp" class="form-text text-muted">The selected picture must be a JPG / GIF / PNG format.</small>
      </div>
      <button type="submit" name = "submit" class="btn btn-primary" style="background-color:#e6eeff; color:black; border-color:#80aaff;">Submit</button>
      <p class = "errormas text-center" style = "color:#ff9999"><br><br><?php echo $error; ?></p>
    </form>
    </div>
  </div>
</div>
</body>
</html>