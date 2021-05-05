<?php
    require_once "connect.php";

    session_start();

    $polaczenie = @new mysqli($host, $user, $password, $db);

?>