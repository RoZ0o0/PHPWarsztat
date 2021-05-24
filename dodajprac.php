<?php
session_start();

require_once "connect.php";

$polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

// $polaczenie->set_charset("utf8");

if (!$polaczenie) {
    die("Connection failed: " . oci_error());
} else {
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $wynagrodzenie = $_POST['wynagrodzenie'];
    $stanowisko = $_POST['stanowisko'];
    $date = date_create($_POST['date']);
    $date = date_format($date, 'y/m/d');
    $pesel = $_POST['pesel'];

    // $sql = "BEGIN pracownicy_crud.pracownik_add('$imie', '$nazwisko', (TO_DATE('$date', 'dd/mm/yy')), $wynagrodzenie, $pesel, '$stanowisko'); END;";
    // echo $sql;

    $stid = oci_parse($polaczenie, "BEGIN pracownicy_crud.pracownik_add('$imie', '$nazwisko', (TO_DATE('$date', 'dd/mm/yy')), $wynagrodzenie, $pesel, '$stanowisko'); END;");

    if (oci_execute($stid) == TRUE) {
        $_SESSION['komunikat'] = "dodany";
        header('Location: pracownicy.php');
    }else{
        $_SESSION['komunikat']="istnieje";
        header('Location: pracownicy.php');
    }

    // if(oci_execute($stid) == TRUE){
    //     while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
    //         $ilu++;
    //     }
    //     if($ilu>0){
    //         $_SESSION['komunikat']="istnieje";
    //         header('Location: pracownicy.php');
    //     }else{
    //         $stid2 = oci_parse($polaczenie, "INSERT INTO pracownicy(id_pracownika, nazwisko, imie, stanowisko, pesel, data_zatrudnienia, wynagrodzenie) VALUES ('$nazwisko', '$imie', '$stanowisko', '$pesel', '$date', $wynagrodzenie)");
    //         // echo $sql2;
    //         if(oci_execute($stid)== TRUE){
    //             $_SESSION['komunikat'] = "dodany";
    //             header('Location: pracownicy.php');
    //         }
    //     }
    // }
    oci_close($polaczenie);
}
?>