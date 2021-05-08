<?php

    session_start();

    if((!isset($_POST['login'])) || (!isset($_POST['password']))){

        header('Location: index.php');
        exit();
    }

    require_once "connect.php";

    $polaczenie = oci_connect($user, $password, $db);

    if(!$polaczenie){
        die("Connection failed: " . oci_error());
    }else{
        $login = $_POST['login'];
        $haslo = $_POST['password'];
        $haslo = md5($haslo);

        $sql = "SELECT * FROM pracownicy WHERE username='$login' AND pass='$haslo'";

        $stid = oci_parse($polaczenie, $sql);

        if($result = oci_execute($stid)){
            $ilu = oci_num_rows($stid);
            if($ilu>0){
                $_SESSION['zalogowany'] = true;
                
                $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
                $_SESSION['user'] = $row['username'];
                $_SESSION['nazwisko'] = $row['nazwisko'];
                $_SESSION['imie'] = $row['imie'];
                $_SESSION['pesel'] = $row['pesel'];
                $_SESSION['data_zatrudnienia'] = $row['data_zatrudnienia'];
                $_SESSION['wynagrodzenie'] = $row['wynagrodzenie'];
                $_SESSION['stanowisko'] = $row['stanowisko'];

                unset($_SESSION['blad']);

                header('Location: dashboard.php');
            }else{
                $_SESSION['blad'] = '<div class="alert alert-danger" role="alert"><p style="color:red; text-align:center">Niepoprawny login lub hasło!</p></div>';
                header('Location: index.php');
            }
        }

        oci_close($polaczenie);
    }
?>


