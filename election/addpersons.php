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

if(isset($_GET['del'])){
  mysqli_query($conn, "DELETE FROM cands WHERE id_cand ='".$_GET['del']."'");
  $edit = $_GET['edit'];
  header('Location:addpersons.php?edit='.$edit.'');
  die();

}

if(isset($_GET['delv'])){
  mysqli_query($conn, "DELETE FROM voters WHERE id_voter ='".$_GET['delv']."'");
  $edit = $_GET['edit'];
  header('Location:addpersons.php?edit='.$edit.'');
  die();

}

if (isset($_POST['description'])) {

$_SESSION['name'] = $_POST['name'];

$_SESSION['organisation'] = $_POST['organisation'];

$_SESSION['enddate'] = $_POST['enddate'];

$_SESSION['description'] = $_POST['description'];

$_SESSION['pic'] = $_FILES["fileToUpload"];

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

$_SESSION['target_file'] = $target_file;//for posting directory of file to db

$uploadOk = 1;



$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $error = "File is not an image.";
        $_SESSION['errorel'] = $error;
        header("Location:newelection.php");
        $uploadOk = 0;
    }

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    $error = "Sorry, your file is too large.";
    $_SESSION['errorel'] = $error;
    header("Location:newelection.php");
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $_SESSION['errorel'] = $error;
    header("Location:newelection.php");
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {

// if everything is ok, try to upload file

} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    $error = '1';
    }else{
    $error = "Sorry, there was an error uploading your file.";
    $_SESSION['errorel'] = $error;
    header("Location:newelection.php");
        }
    }  
if ( !$conn ) {//db connection checking
  die("Connection failed : " . mysqli_error());
}
//query
$name = $_SESSION['name'];
$organisation = $_SESSION['organisation'];
$description = $_SESSION['description'];
$tf = $_SESSION['target_file'];
$enddate = $_SESSION['enddate'];
$query = "INSERT INTO els (name, organisation, description, pic_url, status, finishdate) VALUES ('$name', '$organisation', '$description', '$tf', 0, '$enddate')";
$res = mysqli_query($conn, $query);

if ($res) {
    unset($_SESSION['organisation']);
    unset($_SESSION['description']);
    unset($_SESSION['target_file']);
    unset($_SESSION['enddate']);
}else{
    $error = "Sorry, there was an error uploading your file.";
    $_SESSION['errorel'] = $error;
    header("Location:newelection.php");
 }      
}
if(isset($_GET['edit'])){
  $id_elect = $_GET['edit'];
  $res=mysqli_query($conn,"SELECT name FROM els WHERE id_elect='$id_elect'");
  $row=mysqli_fetch_array($res);
  $_SESSION['name'] = $row['name'];
  $query = "SELECT pic_url, name, description, id_cand, id_el  FROM cands WHERE id_el = '".$_GET['edit']."'";
  $res = mysqli_query($conn, $query);
}else{
$name = $_SESSION['name'];
$query = "SELECT  pic_url, name, description, id_cand, id_el FROM cands WHERE id_el IN (SELECT id_elect FROM els WHERE name = '$name')";
$res = mysqli_query($conn, $query);
}
$candidates = array();
    while($rows = mysqli_fetch_array($res)) {

       // Записать значение столбца FirstName (который является теперь массивом $row)
      
        array_push($candidates, $rows);

      }
if(isset($_GET['edit'])){  
    $query1 = "SELECT email, name, student_id, id_voter, id_elect FROM voters WHERE id_elect = '".$_GET['edit']."'";
  $res1 = mysqli_query($conn, $query1);
}else{
$query1 = "SELECT email, name, student_id, id_voter, id_elect FROM voters WHERE id_elect IN (SELECT id_elect FROM els WHERE name = '$name')";
$res1 = mysqli_query($conn, $query1);
}
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
        <div style="padding: 10px;">
          <h4 class="card-title"><?=$one['name']?></h4>
          <p class="card-text">Description:<?=$one['description']?></p>
          <a href="addpersons.php?edit=<?=$one['id_el']?>&del=<?=$one['id_cand']?>" class="btn btn-primary">Delete</a>
        </div>
      </div>
    </div>
    <?php }?>
  </div>
  <br>
  <div class="row">
    <a href="addcandidate.php" class="btn btn-primary" role="button">Add new candidate</a>
    <a href="addvoter.php" class="btn btn-primary" role="button">Add voter</a>
  </div>
  <br>
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
          <td scope="row"><a href = "addpersons.php?edit=<?=$one['id_elect']?>&delv=<?=$one['id_voter']?>"class="btn btn-danger btn-lg"><span class="glyphicon glyphicon-remove"></span></a></td>
          <td><?=$one['name']?></td>
          <td><?=$one['email']?></td>
          <td><?=$one['student_id']?></td>
        </tr>
        <?php }?>
      </tbody>
    </table>
  </div>

  <div class="row">
    <a href="adminpanel.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Finish</a>
  </div>

</div>

</body>
</html>