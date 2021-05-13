<?php
session_start();

require_once "connect.php";

$polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

if (!$polaczenie) {
    die("Connection failed: " . oci_error());
} else {
    $adres = $_POST['adres'];
    $miasto = $_POST['miasto'];

    $stid = oci_parse($polaczenie, "BEGIN warsztaty_crud.warsztaty_add('$adres', '$miasto'); END;");

    if (oci_execute($stid) == TRUE) {
        $_SESSION['komunikat'] = "dodany";
        header('Location: warsztaty.php');
    }else{
        $_SESSION['komunikat']="istnieje";
        header('Location: warsztaty.php');
    }

    oci_close($polaczenie);
}
