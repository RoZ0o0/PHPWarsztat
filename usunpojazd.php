<?php
    session_start();
    require_once "connect.php";
    if (isset($_POST['id_del'])) {
        $id_poj = $_POST['id_del'];
    }

    $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

    if (!$polaczenie) {
        die("Connection failed: " . oci_error());
    } else {
        $stid = oci_parse($polaczenie, "BEGIN pojazdy_crud.pojazdy_delete($id_poj); END;");
        if (oci_execute($stid) == TRUE) {
            $_SESSION['komunikat'] = "usuniete";
            header('Location: pojazdy.php');
        }
        oci_free_statement($stid);
    }
    oci_close($polaczenie);
?>