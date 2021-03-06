<?php

session_start();

require_once "connect.php";

$polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

if (!$polaczenie) {
    die("Connection failed: " . oci_error());
} else {
    $pesel = $_POST['pesel'];
    $login = $_POST['login'];
    $haslo = $_POST['password'];
    $haslo = md5($haslo);
    $stid = oci_parse($polaczenie, "BEGIN pracownicy_crud.pracownik_register($pesel, '$login','$haslo', :numrows); END;");
    oci_bind_by_name($stid, ':numrows', $ile, 32);
    oci_execute($stid);

    if ($ile > 0) {
        $_SESSION['komunikat'] = '<div class="alert alert-success" role="alert"><p style="color:green; text-align:center">Konto pomyślnie utworzone!</p></div>';
        header('Location: index2.php');
    } else {
        $_SESSION['komunikat'] = '<div class="alert alert-warning" role="alert"><p style="color:orange; text-align:center">Użytkownik już istnieje!</p></div>';
        header('Location: index2.php');
    }

    oci_free_statement($stid);
    oci_close($polaczenie);
}
