<?php

session_start();

if ((!isset($_POST['login'])) || (!isset($_POST['password']))) {

    header('Location: index.php');
    exit();
}

require_once "connect.php";

$polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

if (!$polaczenie) {
    die("Connection failed: " . oci_error());
} else {
    $login = $_POST['login'];
    $haslo = $_POST['password'];
    $haslo = md5($haslo);
    $stid = oci_parse($polaczenie, "SELECT * FROM pracownicy WHERE username='$login' AND pass='$haslo'");
    if (oci_execute($stid) == true) {
        // oci_fetch_all($stid, $out);
        // $ilu = oci_num_rows($stid);
        // if ($ilu > 0) {

        while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
            $_SESSION['user'] = $row['USERNAME'];
            $_SESSION['nazwisko'] = $row['NAZWISKO'];
            $_SESSION['imie'] = $row['IMIE'];
            $_SESSION['pesel'] = $row['PESEL'];
            $_SESSION['data_zatrudnienia'] = $row['DATA_ZATRUDNIENIA'];
            $_SESSION['wynagrodzenie'] = $row['WYNAGRODZENIE'];
            $_SESSION['stanowisko'] = $row['STANOWISKO'];
            $_SESSION['zalogowany'] = true;
            oci_free_statement($stid);
            header('Location: dashboard.php');
            oci_close($polaczenie);
            exit();
        }

        // if($row == 0){
        //     $_SESSION['blad'] = '<div class="alert alert-danger" role="alert"><p style="color:red; text-align:center">Niepoprawny login lub hasło!</p></div>';
        //     header('Location: index.php');
        // }else{
        //     unset($_SESSION['blad']);
        //     oci_free_statement($stid);
        //     header('Location: dashboard.php');
        // }

        // } else {
        $_SESSION['blad'] = '<div class="alert alert-danger" role="alert"><p style="color:red; text-align:center">Niepoprawny login lub hasło!</p></div>';
        header('Location: index.php');
        // }
        oci_close($polaczenie);
    }
}
