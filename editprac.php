<?php
    session_start();
    require_once "connect.php";
    $id_prac;
    if(isset($_POST['id_p'])){
        $id_prac = $_POST['id_p'];
    }

    $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

    if (!$polaczenie) {
        die("Connection failed: " . oci_error());
    } else {
        $imie = $_POST['imiee'];
        $nazwisko = $_POST['nazwiskoe'];
        $wynagrodzenie = $_POST['wynagrodzeniee'];
        $stanowisko = $_POST['stanowiskoe'];
        $date = date_create($_POST['datee']);
        $date = date_format($date, 'y/m/d');
        $pesel = $_POST['pesele'];
        $stid  = oci_parse($polaczenie, "BEGIN pracownicy_crud.pracownik_edit('$id_prac', '$imie', '$nazwisko', (TO_DATE('$date', 'yy/mm/dd')), $wynagrodzenie, $pesel, '$stanowisko'); END;");
        // $sql = "BEGIN pracownicy_crud.pracownik_edit('$id_prac', '$imie', '$nazwisko', (TO_DATE('$date', 'yy/mm/dd')), $wynagrodzenie, $pesel, '$stanowisko'); END;";
        // echo $sql;
        if (oci_execute($stid) == TRUE) {
            $_SESSION['komunikat'] = "edycja";
            header('Location: pracownicy.php');
        }
        oci_free_statement($stid);
    }
    oci_close($polaczenie);
    
?>