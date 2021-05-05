<?php
    session_start();

    require_once "connect.php";

    $polaczenie = @new mysqli($host, $user, $password, $db);

    $polaczenie->set_charset("utf8");

    if($polaczenie->connect_errno!=0){
        echo "Error: ".$polaczenie->connect_errno;
    }else{
        $imie = $_POST['imie'];
        $nazwisko = $_POST['nazwisko'];
        $wynagrodzenie = $_POST['wynagrodzenie'];
        $stanowisko = $_POST['stanowisko'];
        $date = $_POST['date'];
        $pesel = $_POST['pesel'];

        $sql = "SELECT * FROM pracownik WHERE pesel='$pesel'";

        if($result = @$polaczenie->query($sql)){
            $ilu = $result->num_rows;
            if($ilu>0){
                $_SESSION['komunikat']='<div class="alert alert-danger" role="alert"><p style="color:red; text-align:center; left: 50%; right: 50%;">Już istnieje pracownik o takim peselu!</p></div>';
                header('Location: pracownicy.php');
            }else{
                $sql2 = "INSERT INTO pracownik(nazwisko, imie, stanowisko, pesel, data_zatrudnienia, wynagrodzenie) VALUES ('$nazwisko', '$imie', '$stanowisko', '$pesel', '$date', $wynagrodzenie)";
                echo $sql2;
                if($polaczenie->query($sql2)=== TRUE){
                    $_SESSION['komunikat'] = '<div class="alert alert-success" role="alert"><p style="color:green; text-align:center; left: 50%; right: 50%;">Konto pomyślnie utworzone!</p></div>';
                    header('Location: pracownicy.php');
                }
            }
        }
        $polaczenie->close();
    }
?>