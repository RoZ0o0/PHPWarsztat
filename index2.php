<!doctype html>
<meta charset="utf-8">
<html lang="pl">
<head>


<link rel="stylesheet" href="./css/bootstrap.min.css">
<script src="./js/bootstrap.min.js"></script>
<link rel="stylesheet" href="style.css">

  <title>Warsztaty Blacharskie</title>

 
</head>
<body>
<div class="jumbotron text-center">
  <h1>Obsługa warsztatów blacharskich</h1>
  <p>Panel rejestracji</p>
 </div>
<form class="box" action="register.php" method="post" autocomplete="off" >

<h1> Zarejestruj się </h1>
<div id="inputs">
  <br><input type="text" name="pesel" placeholder="PESEL"/> <br>
  <br><input type="text" name="login" placeholder="Nazwa użytkownika"/><br>
  <br><input type="password" name="password" placeholder="Hasło"/><br>
</div>
  <p><a href="index.php">Wróć do logowania</a></p>
<button type="submit" class="btn btn-outline-primary btn-lg" value="Zarejestruj">Zarejestuj</button>
</form>

</body>
</html>