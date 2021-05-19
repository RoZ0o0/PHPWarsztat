<?php
session_start();

require_once "connect.php";

$polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');


if (!$polaczenie) {
    die("Connection failed: " . oci_error());
} else {
    $id = $_POST['id_kl'];
    $model = $_POST['model'];
    $marka = $_POST['marka'];
    $rocznik = $_POST['rocznik'];

    $stid = oci_parse($polaczenie, "BEGIN pojazdy_crud.pojazdy_add('$id', '$model', '$marka', $rocznik); END;");

    if (oci_execute($stid) == TRUE) {
        $_SESSION['komunikat'] = "dodany";
        header('Location: pojazdy.php');
    }else{
        $_SESSION['komunikat']="istnieje";
        header('Location: pojazdy.php');
    }
    oci_close($polaczenie);
}
