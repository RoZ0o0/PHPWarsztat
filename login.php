<?php

    session_start();

    if((!isset($_POST['login'])) || (!isset($_POST['password']))){

        header('Location: index.php');
        exit();
    }

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
                $_SESSION['zalogowany'] = true;
                
                $row = $result->fetch_assoc();
                $_SESSION['user'] = $row['username'];
                $_SESSION['nazwisko'] = $row['nazwisko'];
                $_SESSION['imie'] = $row['imie'];
                $_SESSION['pesel'] = $row['pesel'];
                $_SESSION['data_zatrudnienia'] = $row['data_zatrudnienia'];
                $_SESSION['wynagrodzenie'] = $row['wynagrodzenie'];
                $_SESSION['stanowisko'] = $row['stanowisko'];

                unset($_SESSION['blad']);

                $result->free_result();
                header('Location: dashboard.php');
            }else{
                $_SESSION['blad'] = '<div class="alert alert-danger" role="alert"><p style="color:red">Niepoprawny login lub hasło!</p></div>';
                header('Location: index.php');
            }
        }

        $polaczenie->close();
    }
?>


