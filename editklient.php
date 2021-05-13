<?php
    session_start();
    require_once "connect.php";
    if(isset($_POST['id_k'])){
        $id_kli = $_POST['id_k'];
    }

    $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

    if (!$polaczenie) {
        die("Connection failed: " . oci_error());
    } else {
        $imie = $_POST['imiee'];
        $nazwisko = $_POST['nazwiskoe'];
        $miasto = $_POST['miastoe'];
        $nr_telefonu = $_POST['nr_telefonue'];
        $adres = $_POST['ulica_nr_domue'];
        $stid  = oci_parse($polaczenie, "BEGIN klienci_crud.klienci_edit('$id_kli', '$imie', '$nazwisko', '$miasto', $nr_telefonu, '$adres'); END;");
        if (oci_execute($stid) == TRUE) {
            $_SESSION['komunikat'] = "edycja";
            header('Location: klienci.php');
        }
        oci_free_statement($stid);
    }
    oci_close($polaczenie);
    
?>