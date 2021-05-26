<?php
session_start();
include('library/tcpdf.php');
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetFont('dejavusans', '', 8);

$pdf->AddPage();

require_once "connect.php";

$id_fakt;
if (isset($_POST['id_fakt'])) {
    $id_fakt = $_POST['id_fakt'];
}

$polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

// $polaczenie->set_charset("utf8");

if (!$polaczenie) {
    die("Connection failed: " . oci_error());
} else {
    $stid = oci_parse($polaczenie, "SELECT klienci.imie, klienci.nazwisko, klienci.miasto, klienci.ulica_nr_domu, klienci.kod_pocztowy, faktury.nr_faktury, faktury.id_uslugi, uslugi.data_obslugi, pracownicy.imie as imiep, pracownicy.nazwisko as nazwiskop, uslugi.cena, warsztaty.miasto as miastow, warsztaty.adres as adresw FROM faktury INNER JOIN klienci on faktury.id_klienta=klienci.id_klienta inner join uslugi on faktury.id_uslugi=uslugi.id_uslugi inner join pracownicy on uslugi.id_pracownika=pracownicy.id_pracownika inner join warsztaty on uslugi.id_warsztatu=warsztaty.id_warsztatu where id_faktury=$id_fakt");
    if (oci_execute($stid) == TRUE) {
        while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
            $nr_faktury = $row['NR_FAKTURY'];
            $imie = $row['IMIE'];
            $nazwisko = $row['NAZWISKO'];
            $data = $row['DATA_OBSLUGI'];
            $imiep = $row['IMIEP'];
            $nazwiskop = $row['NAZWISKOP'];
            $cena = $row['CENA'];
            $miasto = $row['MIASTO'];
            $ulica = $row['ULICA_NR_DOMU'];
            $kod_pocz = $row['KOD_POCZTOWY'];
            $adresw = $row['ADRESW'];
            $miastow = $row['MIASTOW'];
            $id_us = $row['ID_USLUGI'];
        }
    }
}
oci_free_statement($stid);
oci_close($polaczenie);

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
    <table>
        <tr>
            <td>
                <p><b>Faktura Nr: </b>'. $nr_faktury . '</p>
                <p><b>Data Wystawienia: </b>'.$data . '</p>
            </td>
            <td><img src="https://i.kym-cdn.com/entries/icons/original/000/008/001/Spurdo.jpg"></td>
        </tr>
    </table>

    <hr>
    <br>
    <table>
        <tr>
            <td><b>Sprzedawca</b></td>
            <td><b>Nabywca</b></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Spurdo Company S.A.</td>
            <td>'.$imie . " " . $nazwisko . '</td>
        </tr>
        <tr>
            <td>'.$adresw.' '.$miastow.'</td>
            <td>'.$kod_pocz.' '.$miasto.', '.$ulica.'</td>
        </tr>
    </table>
    <br>
    <table class="usluga" cellpadding="3">
        <tr>
            <th width="5%"><b>L.P.</b></th>
            <th width="33%"><b>Nazwa towaru/uslugi</b></th>
            <th width="7%"><b>Ilość</b></th>
            <th width="15%"><b>Cena netto</b></th>
            <th width="15%"><b>Wartość Netto</b></th>
            <th width="5%"><b>VAT%</b></th>
            <th width="10%"><b>Wartość VAT</b></th>
            <th width="10%"><b>Wartość Brutto</b></th>
        </tr>
        <tr>
            <td>1</td>
            <td>Robocizna</td>
            <td>-</td>
            <td>'.$cena . 'zł</td>
            <td>'.$cena . 'zł</td>
            <td>23</td>
            <td>'.$cena * 0.23 . 'zł</td>
            <td>'.($cena + $cena * 0.23) . 'zł</td>
        </tr>';

$razemnetto = $cena;
$razemvat = $cena * 0.23;
$razembrutto = ($cena + $cena * 0.23);

$polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');
if (!$polaczenie) {
    die("Connection failed: " . oci_error());
} else {
    $stid2 = oci_parse($polaczenie, "SELECT czesci.nazwa_czesci, czesci.nr_czesci, czesci.cena from uslugi_czesci inner join czesci on uslugi_czesci.id_czesci=czesci.id_czesci where id_uslugi=$id_us");
    $licznik = 2;
    if (oci_execute($stid2) == TRUE) {
        while (($row = oci_fetch_array($stid2, OCI_BOTH)) != false) {
            $nazwa_cz = $row['NAZWA_CZESCI'];
            $nr_czesci = $row['NR_CZESCI'];
            $cena_cz = $row['CENA'];
            $okr = round($cena_cz*0.23,2);
            $razemnetto += $cena_cz;
            $razemvat += $okr;
            $razembrutto += ($cena_cz+$okr);
            $html .= '
            <tr>
                <td>'.$licznik.'</td>
                <td>'.$nazwa_cz.' | '. $nr_czesci. '</td>
                <td>1 szt.</td>
                <td>'.$cena_cz.'zł</td>
                <td>'.$cena_cz.'zł</td>
                <td>23</td>
                <td>'.$okr.'zł</td>
                <td>'.($cena_cz+$okr).'zł</td>
            </tr>
            ';
            $licznik++;
        }
    }
}
oci_close($polaczenie);
$html .= '
        <tr>
            <td style="border: none;"></td>
            <td style="border: none;"></td>
            <td style="border: none;"></td>
            <td>Razem</td>
            <td>'.$razemnetto.'zł</td>
            <td>23</td>
            <td>'.$razemvat.'zł</td>
            <td>'.$razembrutto.'zł</td>
        </tr>';

$html = $html . '
    </table>
    <br>
        <p class="right"><b>Wartość netto </b>'.$razemnetto.' PLN</p>
        <p class="right"><b>VAT </b>'.$razemvat.' PLN</p>
        <p class="right"><b>Wartość brutto </b>'.$razembrutto.' PLN</p>
    <br>
    <hr>
    <br>
        <p class="zap">Kwota do zapłaty: '.$razembrutto.'PLN</p>
    <br>
    <hr>
    <br>
        <p class="right"><b>Imie i nazwisko wystawcy</b></p>
        <p class="right">'.$imiep . " " . $nazwiskop . '</p>

    ';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Output();
