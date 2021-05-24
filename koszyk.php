<?php
session_start();
$str;
if (isset($_POST['submit'])) {
    $str = json_decode($_POST['str'], true);
}


require_once "connect.php";

$polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');


if (!$polaczenie) {
    die("Connection failed: " . oci_error());
} else {

    $stid = oci_parse($polaczenie, "BEGIN zamowienia_crud.zamowienia_add; END;");
    $last_zamowienie = 1;
    if (oci_execute($stid) == TRUE) {
        $_SESSION['komunikat'] = "dodany";
        $stid2 = oci_parse($polaczenie, "SELECT id_zamowienia FROM zamowienia WHERE ROWNUM = 1 ORDER BY id_zamowienia DESC");
        if (oci_execute($stid2) == TRUE) {
            while (($row = oci_fetch_array($stid2, OCI_BOTH)) != false) {
              $last_zamowienie= $row['ID_ZAMOWIENIA'];
            }
        }
        
        for($i = 0; $i < count($str); $i++){
            $stid3 = oci_parse($polaczenie, "INSERT INTO czesci_zamowienia(id_czesci, id_zamowienia, liczba_zam_sztuk) values(".$str[$i][0].", $last_zamowienie,".$str[$i][1].")");
            oci_execute($stid3);
        }
        header('Location: czesci.php');
    }else{
        $_SESSION['komunikat']="istnieje";
        header('Location: czesci.php');
    }
    oci_close($polaczenie);
}
