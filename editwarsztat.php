<?php
    session_start();
    require_once "connect.php";
    if(isset($_POST['id_w'])){
        $id_warsz = $_POST['id_w'];
    }

    $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

    if (!$polaczenie) {
        die("Connection failed: " . oci_error());
    } else {
        $adres = $_POST['adrese'];
        $miasto = $_POST['miastoe'];
        $stid  = oci_parse($polaczenie, "BEGIN warsztaty_crud.warsztaty_edit('$id_warsz', '$adres', '$miasto'); END;");
        if (oci_execute($stid) == TRUE) {
            $_SESSION['komunikat'] = "edycja";
            header('Location: warsztaty.php');
        }
        oci_free_statement($stid);
    }
    oci_close($polaczenie);
    
?>