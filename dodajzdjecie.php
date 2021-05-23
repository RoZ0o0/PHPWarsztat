<?php
   if(isset($_FILES['fileToUpload'])){
    $errors= array();
    $file_name = $_FILES['fileToUpload']['name'];
    $file_size =$_FILES['fileToUpload']['size'];
    $file_tmp =$_FILES['fileToUpload']['tmp_name'];
    $file_type=$_FILES['fileToUpload']['type'];
    $file_ext=strtolower(end(explode('.',$_FILES['fileToUpload']['name'])));
    
    $expensions= array("jpeg","jpg","png");
    
    if(in_array($file_ext,$expensions)=== false){
       $errors[]="extension not allowed, please choose a JPEG or PNG file.";
       $_SESSION['komunikat'] = "zlyformat";
       header('Location: galeria.php');
       exit();
    }
    
    if($file_size > 2097152){
       $errors[]='File size must be excately 2 MB';
       $_SESSION['komunikat'] = "zaduzy";
       header('Location: galeria.php');
       exit();
    }
    
    if(empty($errors)==true){
       move_uploaded_file($file_tmp,"gallery/".$file_name);
       echo "Success";
       $_SESSION['komunikat'] = "dodany";
       header('Location: galeria.php');
    }else{
       print_r($errors);
    }
 }

session_start();

require_once "connect.php";

$polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

if (!$polaczenie) {
    die("Connection failed: " . oci_error());
} else {
    $id_uslugi = $_POST['id_usl'];
    $in_zdjecie=$file_name;
    $in_komentarz= $_POST['komentarz'];
    
    if(isset($_POST['przed'])){
    $stan = 1;
    }
    else $stan=2;


    $stid = oci_parse($polaczenie, "BEGIN galeria_crud.galeria_add('$id_uslugi', '$in_zdjecie', '$stan', '$in_komentarz'); END;");
    if (oci_execute($stid) == TRUE) {
        $_SESSION['komunikat'] = "dodany";
        header('Location: galeria.php');
    }else{
        $_SESSION['komunikat']="blad";
        header('Location: galeria.php');
    }
    oci_close($polaczenie);
}
?>