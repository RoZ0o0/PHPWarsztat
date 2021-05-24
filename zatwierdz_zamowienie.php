<?php
    session_start();
    require_once "connect.php";
    if (isset($_POST['id_zatw'])) {
        $id_u = $_POST['id_zatw'];
    }
    $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

    if (!$polaczenie) {
        die("Connection failed: " . oci_error());
    } else {
        $stid = oci_parse($polaczenie,"BEGIN ZAMOWIENIA_CRUD.ZAMOWIENIA_CONFIRM('$id_u'); END;");
        if (oci_execute($stid) == TRUE) {
            $_SESSION['komunikat'] = "sukces";
            header('Location: zamowienia.php');
        }
        oci_free_statement($stid);
    }
    oci_close($polaczenie);
?>