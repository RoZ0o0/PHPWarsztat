<?php

    session_start();

    require_once "connect.php";

    $polaczenie = @new mysqli($host, $user, $password, $db);

    if($polaczenie->connect_errno!=0){
        echo "Error: ".$polaczenie->connect_errno;
    }else{
        $login = $_POST['login'];
        $haslo = $_POST['password'];
        
        $sql = "SELECT * FROM pracownik WHERE username='$login' AND pass='$haslo'";

        if($result = @$polaczenie->query($sql)){
            $ilu = $result->num_rows;
            if($ilu>0){
                $row = $result->fetch_assoc();
                $_SESSION['user'] = $row['username'];
                $_SESSION['nazwisko'] = $row['nazwisko'];
                $_SESSION['imie'] = $row['imie'];
                $_SESSION['pesel'] = $row['pesel'];
                $_SESSION['data_zatrudnienia'] = $row['data_zatrudnienia'];
                $_SESSION['wynagrodzenie'] = $row['wynagrodzenie'];

                $result->free_result();
                header('Location: usluga.php');
            }else{

            }
        }

        $polaczenie->close();
    }
?>


