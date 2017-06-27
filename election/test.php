<?php

session_start();

include("database.php");
 //bd connection
$conn = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);
mysqli_set_charset($conn,"utf8_unicode_ci");

unset($_SESSION['errorcand']);

if(isset($_POST['namecand'])){
  $n = 'test';
  echo $n;

$_SESSION['namecand'] = $_POST['namecand'];

$_SESSION['id_el'] = $_POST['id_el'];

$_SESSION['descand'] = $_POST['descand'];

$_SESSION['pic'] = $_FILES["fileToUpload"];

echo $_POST['id_el'];

echo $_SESSION['namecand'];

echo $_SESSION['id_el'];

echo $_SESSION['descand'];

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
        $_SESSION['errorcand'] = $error;
        header("Location:addcandidate.php");
        $uploadOk = 0;
    }

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    $error = "Sorry, your file is too large.";
    $_SESSION['errorcand'] = $error;
    header("Location:addcandidate.php");
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $_SESSION['errorcand'] = $error;
    header("Location:addcandidate.php");
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
    $_SESSION['errorcand'] = $error;
    header("Location:addcandidate.php");
        }
    }  
if ( !$conn ) {//db connection checking
  die("Connection failed : " . mysqli_error());
}
//query

$namecand = $_SESSION['namecand'];
$id_el = $_SESSION['id_el'];
$descand = $_SESSION['descand'];
$tf = $_SESSION['target_file'];
echo $tf;

$query = "INSERT INTO cands (name, id_el, description, pic_url, votes) VALUES ('$namecand', '$id_el', '$descand', '$tf', 0)";
$res = mysqli_query($conn, $query);

if ($res) {
    unset($_SESSION['namecand']);
    unset($_SESSION['id_el']);
    unset($_SESSION['descand']);
    unset($_SESSION['target_file']);
    header("Location:addpersons.php");
}else{
    $error = "Sorry, there was an error uploading your file.";
    $_SESSION['errorcand'] = $error;
    header("Location:addcandidate.php");
 }      
}else{
  unset ($error);
}


?>