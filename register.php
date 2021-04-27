<?php

    session_start();

    require_once "connect.php";

    $polaczenie = @new mysqli($host, $user, $password, $db);

    if($polaczenie->connect_errno!=0){
        echo "Error: ".$polaczenie->connect_errno;
    }else{
        $pesel = $_POST['pesel'];
        $login = $_POST['login'];
        $haslo = $_POST['password'];
        
        $sql = "SELECT * FROM pracownik WHERE pesel='$pesel'";

        if($result = @$polaczenie->query($sql)){
            $ilu = $result->num_rows;
            if($ilu>0){
                $row = $result->fetch_assoc();
                $_SESSION['user'] = $row['username'];
                $_SESSION['pesel'] = $row['pesel'];
                if($row['username'] == null){
                    $sql2 = "UPDATE pracownik SET username='$login', pass='$haslo' where pesel='$pesel'";
                    if($polaczenie->query($sql2)=== TRUE){
                        $_SESSION['komunikat'] = '<div class="alert alert-success" role="alert"><p style="color:green">Konto pomyślnie utworzone!</p></div>';
                        header('Location: index2.php');
                    }else{
                        $_SESSION['komunikat'] = '<div class="alert alert-danger" role="alert"><p style="color:green">Konto nie zostało utworzone!</p></div>';
                        header('Location: index2.php');
                    }
                }else{
                    $_SESSION['komunikat'] = '<div class="alert alert-warning" role="alert"><p style="color:orange">Użytkownik już istnieje!</p></div>';
                        header('Location: index2.php');
                }

                $result->free_result();

            }else{
                $_SESSION['komunikat'] = '<div class="alert alert-danger" role="alert"><p style="color:red">Nieprawidłowe dane!</p></div>';
                        header('Location: index2.php');
            }
        }

        $polaczenie->close();
    }
?>


