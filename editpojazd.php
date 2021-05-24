<?php
    session_start();
    require_once "connect.php";
    if(isset($_POST['id_poj'])){
        $id_poj = $_POST['id_poj'];
    }

    $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

    if (!$polaczenie) {
        die("Connection failed: " . oci_error());
    } else {
        $model = $_POST['modele'];
        $marka = $_POST['markae'];
        $rocznik = $_POST['rocznike'];
        $id_kl = $_POST['id_kle'];
        $stid  = oci_parse($polaczenie, "BEGIN pojazdy_crud.pojazdy_edit('$id_poj', '$id_kl', '$model', '$marka', $rocznik); END;");
        if (oci_execute($stid) == TRUE) {
            $_SESSION['komunikat'] = "edycja";
            header('Location: pojazdy.php');
        }
        oci_free_statement($stid);
    }
    oci_close($polaczenie);
    
?>