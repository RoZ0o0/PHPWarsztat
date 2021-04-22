<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome,opera=1" />
    <title>Warsztat Blacharski</title>
</head>

<body>

<?php

    echo "<p>Witaj ".$_SESSION['user']."!</p>";
    echo "<p>Nazwisko: ".$_SESSION['nazwisko']. " | Imie: ".$_SESSION['imie']." | PESEL: ".$_SESSION['pesel']." | Data Zatrudnienia: ".$_SESSION['data_zatrudnienia']." | Wynagrodzenie ".$_SESSION['wynagrodzenie'];

?>

</body>
</html>