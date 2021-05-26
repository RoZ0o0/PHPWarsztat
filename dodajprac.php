<?php
session_start();

require_once "connect.php";

$polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

if (!$polaczenie) {
    die("Connection failed: " . oci_error());
} else {
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $wynagrodzenie = $_POST['wynagrodzenie'];
    $stanowisko = $_POST['stanowisko'];
    $date = date_create($_POST['date']);
    $date = date_format($date, 'y/m/d');
    $pesel = $_POST['pesel'];

    $stid = oci_parse($polaczenie, "BEGIN pracownicy_crud.pracownik_add('$imie', '$nazwisko', (TO_DATE('$date', 'yy/mm/dd')), $wynagrodzenie, $pesel, '$stanowisko'); END;");

    if (oci_execute($stid) == TRUE) {
        $_SESSION['komunikat'] = "dodany";
        header('Location: pracownicy.php');
    }else{
        $_SESSION['komunikat']="istnieje";
        header('Location: pracownicy.php');
    }
    oci_close($polaczenie);
}
?>