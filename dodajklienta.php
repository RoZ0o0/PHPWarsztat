<?php
session_start();

require_once "connect.php";

$polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');


if (!$polaczenie) {
    die("Connection failed: " . oci_error());
} else {
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $miasto = $_POST['miasto'];
    $nr_telefonu = $_POST['nrtelefonu'];
    $ulica_dom = $_POST['ulica_nr_domu'];
    $kod = $_POST['kod_pocztowy'];

    $stid = oci_parse($polaczenie, "BEGIN klienci_crud.klienci_add('$imie', '$nazwisko', '$miasto', $nr_telefonu, '$ulica_dom', '$kod'); END;");

    if (oci_execute($stid) == TRUE) {
        $_SESSION['komunikat'] = "dodany";
        header('Location: klienci.php');
    }else{
        $_SESSION['komunikat']="istnieje";
        header('Location: klienci.php');
    }
    oci_close($polaczenie);
}
