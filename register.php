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
                        echo '<script type="text/javascript">'; 
                        echo 'alert("Stworzono konto");';
                        echo 'window.location.href = "index2.php";';
                        echo '</script>';
                    }else{
                        echo '<script type="text/javascript">'; 
                        echo 'alert("Nie stworzono użytkownika: "). $polaczenie->error;';
                        echo 'window.location.href = "index2.php";';
                        echo '</script>';
                    }
                }else{
                    echo '<script type="text/javascript">'; 
                    echo 'alert("Użytkownik już istnieje");';
                    echo 'window.location.href = "index2.php";';
                    echo '</script>';
                }


                $result->free_result();
            }else{

            }
        }

        $polaczenie->close();
    }
?>


