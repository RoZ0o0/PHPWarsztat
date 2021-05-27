<?php
    session_start();
    require_once "connect.php";
    $id_warsztat;
    if (isset($_POST['id_del'])) {
        $id_warsztat = $_POST['id_del'];
    }

    $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

    if (!$polaczenie) {
        die("Connection failed: " . oci_error());
    } else {
        $stid = oci_parse($polaczenie, "BEGIN warsztaty_crud.warsztaty_delete($id_warsztat); END;");
        if (oci_execute($stid) == TRUE) {
            $_SESSION['komunikat'] = "usuniete";
            header('Location: warsztaty.php');
        }else{
            $_SESSION['komunikat'] = "niemozna";
            header('Location: warsztaty.php');
        }
        oci_free_statement($stid);
    }
    oci_close($polaczenie);
?>