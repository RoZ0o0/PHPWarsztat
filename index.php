<?php
    session_start();

    if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true)){
        header('Location: dashboard.php');
        exit();
    }
?>

<!doctype html>
<meta charset="utf-8">
<html lang="pl">
<head>


<!-- <link rel="stylesheet" href="./css/bootstrap.min.css">
<script src="./js/bootstrap.min.js"></script> Tymczasowo wyłączone-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />

  <title>Warsztaty Blacharskie</title>

 
</head>
<body>
<div class="container">
        <div class="subCont">
            <div class="row">
                <div class="col-md-7">
                    <div class="leftCont"> 
                        <form class="myForm text-center" action="login.php" method="post" autocomplete="off">
                            <header>Logowanie</header>
                            <div class="form-group">
                                <i class="fas fa-user"></i>
                                <input class="myInput" type="text" placeholder="Login" id="username" name="login" required> 
                            </div>
                            <div class="form-group">
                                <i class="fas fa-lock"></i>
                                <input class="myInput" type="password" id="password" placeholder="Hasło" name="password" required> 
                            </div>
                            <input type="submit" class="butt" value="ZALOGUJ">
                            <div class="register-employee">
                              <a href="index2.php">Rejestracja konta pracownika</a>
                            </div>
                        </form>
                    </div>
                </div> 
                <div class="col-md-5">
                    <div class="rightCont">
                            <div class="box"><header>Panel logowania</header>
                            
                            <p>Zaloguj się danymi pracownika podanymi w procesie rejestracji. Jeśli nie jesteś jeszcze zarejestrowany użyj opcji "Rejestracja konta pracownika".</p>
                                <input type="button" class="butt_out" value="Więcej informacji"/>
                                
                            </div>
                                
                    </div>
                </div>
            </div>
        </div>
</div>
      
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>



</body>
</html>