<?php
    session_start();
    require_once "connect.php";
    $id_prac;
    if (isset($_POST['id_del'])) {
        $id_prac = $_POST['id_del'];
    }

    $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

    if (!$polaczenie) {
        die("Connection failed: " . oci_error());
    } else {
        $stid = oci_parse($polaczenie, "BEGIN pracownicy_crud.pracownik_delete($id_prac); END;");
        if (oci_execute($stid) == TRUE) {
            $_SESSION['komunikat'] = "usuniete";
            header('Location: pracownicy.php');
        }else{
            $_SESSION['komunikat'] = "niemozna";
            header('Location: pracownicy.php');
        }
        oci_free_statement($stid);
    }
    oci_close($polaczenie);
?>