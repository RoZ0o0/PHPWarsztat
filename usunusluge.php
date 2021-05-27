<?php
    session_start();
    require_once "connect.php";
    if (isset($_POST['id_del'])) {
        $id_u = $_POST['id_del'];
    }
    $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

    if (!$polaczenie) {
        die("Connection failed: " . oci_error());
    } else {
        $stid = oci_parse($polaczenie, "BEGIN uslugi_crud.uslugi_delete($id_u); END;");
        if (oci_execute($stid) == TRUE) {
            $_SESSION['komunikat'] = "usuniete";
            header('Location: uslugi.php');
        }else{
            $_SESSION['komunikat'] = "niemozna";
            header('Location: uslugi.php');
        }
        oci_free_statement($stid);
    }
    oci_close($polaczenie);
?>