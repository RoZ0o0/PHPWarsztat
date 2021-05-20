<?php
    session_start();
    require_once "connect.php";
    $id_usl;
    if(isset($_POST['id_usl'])){
        $id_usl = $_POST['id_usl'];
    }

    $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

    if (!$polaczenie) {
        die("Connection failed: " . oci_error());
    } else {
        $stid = oci_parse($polaczenie, "SELECT pojazdy.id_klienta from uslugi INNER JOIN pojazdy on uslugi.id_pojazdu=pojazdy.id_pojazdu where id_uslugi = $id_usl");
        if (oci_execute($stid) == TRUE) {
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                $id_kl = $row['ID_KLIENTA'];
            }
        }
        
        oci_free_statement($stid);

        $nr_fak = "SPR\\0000".$id_usl;

        echo $nr_fak."<br>";
        echo $id_usl."<br>";
        echo $id_kl."<br>";

        $stid2 = oci_parse($polaczenie, "BEGIN uslugi_crud.uslugi_faktura($id_kl, $id_usl, '$nr_fak'); END;");
        if (oci_execute($stid2) == TRUE) {
            $_SESSION['komunikat'] = "fakturkapyk";
            header('Location: uslugi.php');
        }else{
            $_SESSION['komunikat'] = "fakturaniepyk";
            header('Location: uslugi.php');
        }
        oci_free_statement($stid2);
    }
    oci_close($polaczenie);
    
?>