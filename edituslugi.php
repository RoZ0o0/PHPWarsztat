<?php
    session_start();
    require_once "connect.php";
    if(isset($_POST['id_p'])){
        $id_p = $_POST['id_p'];
    }

    $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

    if (!$polaczenie) {
        die("Connection failed: " . oci_error());
    } else {
        $id_prac = $_POST['id_pracownikae'];
        $id_war = $_POST['id_ware'];

        if($id_war != 'undefined'){
            $id_war = $_POST['id_ware']; 
        }else{
            $id_war = NULL;
        }

        $cena = $_POST['cenae'];

        $id_poj = $_POST['id_poje'];
        if($id_poj != 'undefined'){
            $id_poj = $_POST['id_poje']; 
        }else{
            $id_poj = NULL;
        }
        $date = date_create($_POST['datee']);
        $date = date_format($date, 'y/m/d');
        $stid  = oci_parse($polaczenie, "BEGIN uslugi_crud.uslugi_edit($id_p, $id_prac, '$id_war', $cena, '$id_poj', (TO_DATE('$date', 'yy/mm/dd'))); END;");
        if (oci_execute($stid) == TRUE) {
            
            $stid2 = oci_parse($polaczenie, "DELETE FROM uslugi_czesci where id_uslugi=$id_p");
            oci_execute($stid2);

            foreach ($_POST['czescie'] as $selectedOption){
                $stid3 = oci_parse($polaczenie, "INSERT INTO uslugi_czesci(id_czesci, id_uslugi, ilosc) values($selectedOption, $id_p, 1)");
                oci_execute($stid3);
            }

            $_SESSION['komunikat'] = "edycja";
            header('Location: uslugi.php');
        }
        oci_free_statement($stid);
    }
    oci_close($polaczenie);
    
?>