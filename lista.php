<?php
session_start();
include('library/tcpdf.php');
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$id_listy;
if(isset($_POST['id_listy'])){
    $id_listy = $_POST['id_listy'];
}

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetFont('dejavusans', '', 8);

$pdf->AddPage();

require_once "connect.php";

$polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

// $polaczenie->set_charset("utf8");

$html = '
    <style>
    .usluga table, .usluga td, .usluga th{
        border: 1px solid black;
        text-align: right;
      }

    th{
        background-color: grey;
    }
    
    .right{
        text-align: right;
    }
    
    </style>
    <body>
    <h2>Zamówione części</h2>
    <table class="usluga" cellpadding="3">
        <tr>
            <th width="5%"><b>L.P.</b></th>
            <th width="80%"><b>Nazwa czesci</b></th>
            <th width="15%"><b>Sztuki</b></th>
        </tr>';


$polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');
if (!$polaczenie) {
    die("Connection failed: " . oci_error());
} else {
    $stid = oci_parse($polaczenie, "SELECT czesci_zamowienia.id_zamowienia, czesci_zamowienia.liczba_zam_sztuk, czesci.nazwa_czesci, czesci.nr_czesci, czesci.opis, zamowienia.status FROM czesci_zamowienia inner join czesci on czesci_zamowienia.id_czesci=czesci.id_czesci inner join zamowienia on czesci_zamowienia.id_zamowienia=zamowienia.id_zamowienia where czesci_zamowienia.id_zamowienia=$id_listy");
    $licznik = 1;
    if (oci_execute($stid) == TRUE) {
        while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
            $id_zamowienia = $row['ID_ZAMOWIENIA'];
            $ilosc_cz = $row['LICZBA_ZAM_SZTUK'];
            $status = $row['STATUS'];
            $html .= '
            <tr>
                <td>'.$licznik.'</td>
                <td>'.$row['NAZWA_CZESCI'].' | '.$row['NR_CZESCI'].' | '.$row['OPIS'].'</td>
                <td>'.$ilosc_cz.'</td>
            </tr>
            ';
            $licznik++;
        }
    }
}
oci_close($polaczenie);
$html = $html . '
    </table>
    ';

    if($status == 1){
        $html .= '<h1 style="color: red; text-align:right;">Zrealizowane</h1>';
    }
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Output();
