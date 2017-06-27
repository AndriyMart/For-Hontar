<?php
 

session_start();

include("database.php");
 //bd connection
$conn = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);
mysqli_set_charset($conn,"utf8_unicode_ci");
if(isset($_SESSION['errorvoter'])){
  $error = $_SESSION['errorvoter'];
}else{
$error= "";
}
if (isset($_POST['namevoter'])) {

$_SESSION['namevoter'] = $_POST['namevoter'];

$_SESSION['id_el'] = $_POST['id_el'];

$_SESSION['studentid'] = $_POST['studentid'];

$_SESSION['email'] = $_POST['email'];


if ( !$conn ) {//db connection checking
  die("Connection failed : " . mysqli_error());
}
//query
$namevoter = $_SESSION['namevoter'];
$id_el = $_SESSION['id_el'];
$studentid = $_SESSION['studentid'];
$email = $_SESSION['email'];
$query = "INSERT INTO voters (name, id_elect, email, student_id, status) VALUES ('$namevoter', '$id_el', '$email', '$studentid', 0)";
$res = mysqli_query($conn, $query);
if ($res) {
    unset($_SESSION['namevoter']);
    unset($_SESSION['id_el']);
    unset($_SESSION['studentid']);
    unset($_SESSION['email']);
    unset($_SESSION['errorvoter']);
    header("Location:addpersons.php");
}else{
    $error = "Sorry, there was an error.";
    $_SESSION['errorvoter'] = $error;
    header("Location:addvoter.php");
 }      
}
$name = $_SESSION['name'];
$query1 = "SELECT id_elect FROM els WHERE name = '$name'";
$res1 = mysqli_query($conn, $query1);

$ids = array();
    while($rows = mysqli_fetch_array($res1)) {

       // Записать значение столбца FirstName (который является теперь массивом $row)
      
        array_push($ids, $rows);

      
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

<?php foreach ($ids as $one){ ?>
<div class="container">
  <div class="row">
    <div class="col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
      <form action="addvoter.php" method="post" enctype="multipart/form-data" >
        <div class="form-group" style="visibility:hidden">
          <label for="id_el">Id_El</label>
          <input type="name" class="form-control" name = "id_el" id="id_el" value = "<?=$one['id_elect']?>">
        </div>
        <div class="form-group">
          <label for="namecand">Name</label>
          <input type="name" class="form-control" name = "namevoter" id="namevoter" placeholder="Name">
        </div>
        <div class="form-group">
          <label for="namecand">Email</label>
          <input type="name" class="form-control" name = "email" id="email" placeholder="Email">
        </div>
        <div class="form-group">
          <label for="textarea">Student_id</label>
          <input type="name" class="form-control" name = "studentid" id="studentid" placeholder="Student ID">
        </div>
        <button type="submit" name = "submit" class="btn btn-primary" style="background-color:#e6eeff; color:black; border-color:#80aaff;">Submit</button>
        <p class = "errormas text-center" style = "color:#ff9999;"><br><br><?php echo $error?></p>
        <?php }?>
      </form>
    </div>
  </div>
</div>
</body>
</html>
