<?php
    session_start();
?>

<!doctype html>
<meta charset="utf-8">
<html lang="pl">
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
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
                        <form class="myForm text-center" action="register.php" method="post" autocomplete="off">
                            <header>Rejestracja</header>
                            <div class="form-group">
                                <i class="fas fa-key"></i>
                                <input class="myInput" type="number" min="01010100000" max="99121299999" placeholder="PESEL" id="pesel" name="pesel" required> 
                            </div>
                            <div class="form-group">
                                <i class="fas fa-user"></i>
                                <input class="myInput" type="text" placeholder="Nazwa użytkownika" id="username"name="login" required> 
                            </div>
                            <div class="form-group">
                                <i class="fas fa-lock"></i>
                                <input class="myInput" type="password" id="password" placeholder="Hasło" name="password"  required> 
                            </div>
                            <div class="form-group">
                                <i class="fas fa-lock"></i>
                                <input class="myInput" type="password" id="password" placeholder="Powtórz hasło" name="password"  required> 
                            </div>

                            <div class="form-group">
                                <label>
                                    <input id="check_1" name="check_1"  type="checkbox" required><small> Przeczytałem i akceptuję regulamin</small></input> 
                                    <div class="invalid-feedback">Zaznacz to pole jeśli chcesz kontynuować.</div>
                                </label>
                            </div>
                            <input type="submit" class="butt" value="ZAREJESTRUJ SIĘ">
                            <?php
                                if(isset($_SESSION['komunikat'])){
                                    echo $_SESSION['komunikat'];
                                }
                            ?>   
                        </form>
                    </div>
                </div> 
                <div class="col-md-5">
                    <div class="rightCont">
                            <div class="box"><header>Rejestracja</header>
                            <p>Stwórz konto pracownika wpisując numer PESEL, nazwę użytkownika oraz hasło. Jeśli posiadasz już konto przejdź do logowania</p>
                                <a href="index.php"><input type="button" class="butt_out" value="Logowanie"/></a>
                            </div>   
                    </div>
                </div>
            </div>
        </div>
</div>
      
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

<?php
    unset($_SESSION['komunikat']);
?>

</body>
</html>