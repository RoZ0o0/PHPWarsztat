<?php
    session_start();
    require_once "connect.php";
    if(isset($_POST['id_p'])){
        $id_p = $_POST['id_p'];
    }

    $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

    if (!$polaczenie) {
        die("Connection failed: " . oci_error());
    } else {
        $id_prac = $_POST['id_pracownikae'];
        $id_war = $_POST['id_ware'];
        $cena = $_POST['cenae'];
        $id_poj = $_POST['id_poje'];
        $date = date_create($_POST['datee']);
        $date = date_format($date, 'y/m/d');
        echo $id_war;
        echo $id_poj;
        // $stid  = oci_parse($polaczenie, "BEGIN uslugi_crud.uslugi_edit($id_p, $id_prac, $id_war, $cena, $id_poj, (TO_DATE('$date', 'yy/mm/dd'))); END;");
        // if (oci_execute($stid) == TRUE) {
        //     $_SESSION['komunikat'] = "edycja";
        //     header('Location: uslugi.php');
        // }
        // oci_free_statement($stid);
    }
    oci_close($polaczenie);
    
?>