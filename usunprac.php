<?php
    session_start();
    require_once "connect.php";
    $id_prac;
    if(isset($_POST['id_del'])){
        $id_prac = $_POST['id_del'];
    }

    $polaczenie = @new mysqli($host, $user, $password, $db);

    $polaczenie->set_charset("utf8");
    if ($polaczenie->connect_errno != 0) {
        echo "Error: " . $polaczenie->connect_errno;
    } else {
        $sql = "DELETE FROM pracownik WHERE id_pracownika=$id_prac";
        if ($result = @$polaczenie->query($sql)) {
            $_SESSION['komunikat'] = "usuniete";
            header('Location: pracownicy.php');
        }
    }
    $polaczenie->close();
    ?>