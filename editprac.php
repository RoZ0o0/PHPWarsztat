<?php
    session_start();
    require_once "connect.php";
    $id_prac;
    if(isset($_POST['id_p'])){
        $id_prac = $_POST['id_p'];
    }

    $polaczenie = @new mysqli($host, $user, $password, $db);

    $polaczenie->set_charset("utf8");
    if ($polaczenie->connect_errno != 0) {
        echo "Error: " . $polaczenie->connect_errno;
    } else {
        $imie = $_POST['imiee'];
        $nazwisko = $_POST['nazwiskoe'];
        $wynagrodzenie = $_POST['wynagrodzeniee'];
        $stanowisko = $_POST['stanowiskoe'];
        $date = $_POST['datee'];
        $pesel = $_POST['pesele'];
        $sql = "UPDATE pracownik SET nazwisko='$nazwisko', imie='$imie', stanowisko='$stanowisko', pesel='$pesel', data_zatrudnienia='$date', wynagrodzenie=$wynagrodzenie WHERE id_pracownika = $id_prac";
        if ($result = @$polaczenie->query($sql)) {
            $_SESSION['komunikat'] = "edycja";
            header('Location: pracownicy.php');
        }
    }
    $polaczenie->close();
?>