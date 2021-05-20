<?php
    session_start();

require_once "connect.php";

$polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

if (!$polaczenie) {
    die("Connection failed: " . oci_error());
} else {
    $id_pracownika = $_POST['id_pracownika'];
    $id_warsztatu = $_POST['id_war'];
    $id_pojazdu = $_POST['id_poj'];
    $date = date_create($_POST['date']);
    $date = date_format($date, 'y/m/d');
    $cena = $_POST['cena'];

    $stid = oci_parse($polaczenie, "BEGIN uslugi_crud.uslugi_add($id_pracownika, $id_warsztatu, $cena, $id_pojazdu, (TO_DATE('$date', 'dd/mm/yy'))); END;");

    if (oci_execute($stid) == TRUE) {
        $_SESSION['komunikat'] = "dodany";
        header('Location: uslugi.php');
    }else{
        $_SESSION['komunikat']="istnieje";
        header('Location: uslugi.php');
    }
    oci_close($polaczenie);
}

?>