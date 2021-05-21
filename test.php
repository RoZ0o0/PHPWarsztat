<?php
    session_start();
    include('library1/tcpdf.php');
    $pdf = new TCPDF('P','mm','A4', true, 'UTF-8', false);

    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetFont('dejavusans', '', 8);

    $pdf->AddPage();

    require_once "connect.php";

    $id_fakt;
    if(isset($_POST['id_fakt'])){
        $id_fakt = $_POST['id_fakt'];
    }

            $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

            // $polaczenie->set_charset("utf8");

            if (!$polaczenie) {
              die("Connection failed: " . oci_error());
            } else {
              $stid = oci_parse($polaczenie, "SELECT klienci.imie, klienci.nazwisko, faktury.nr_faktury, uslugi.data_obslugi, pracownicy.imie as imiep, pracownicy.nazwisko as nazwiskop FROM faktury INNER JOIN klienci on faktury.id_klienta=klienci.id_klienta inner join uslugi on faktury.id_uslugi=uslugi.id_uslugi inner join pracownicy on uslugi.id_pracownika=pracownicy.id_pracownika where id_faktury=$id_fakt");
              $licznik = 1;
              if (oci_execute($stid) == TRUE) {
                while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                    $nr_faktury = $row['NR_FAKTURY'];
                    $imie = $row['IMIE'];
                    $nazwisko = $row['NAZWISKO'];
                    $data = $row['DATA_OBSLUGI'];
                    $imiep = $row['IMIEP'];
                    $nazwiskop = $row['NAZWISKOP'];
                }
              }
            }
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
                <p><b>Faktura Nr: </b>';
                $html = $html.$nr_faktury.'</p>
                <p><b>Data Wystawienia: </b>';
                $html .= $data.'</p>
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
            <td>';$html .= $imie." ".$nazwisko.'</td>
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
            <td>Dawanie kodu</td>
            <td>1 szt</td>
            <td>500zł</td>
            <td>500zł</td>
            <td>23</td>
            <td>500zł</td>
            <td>500zł</td>
        </tr>
        <tr>
            <td style="border: none;"></td>
            <td style="border: none;"></td>
            <td style="border: none;"></td>
            <td>Razem</td>
            <td>500zł</td>
            <td>23</td>
            <td>500zł</td>
            <td>JD</td>
        </tr>';

        $html = $html. '
        <tr>
            <td style="border: none;"></td>
            <td style="border: none;"></td>
            <td style="border: none;"></td>
            <td>W tym</td>
            <td>500zł</td>
            <td>23</td>
            <td>500zł</td>
            <td>500zł</td>
        </tr>
    </table>
    <br>
    <hr>
    <br>
        <p class="zap">Kwota do zapłaty: </p>
    <br>
    <hr>
    <br>
        <p class="right"><b>Imie i nazwisko wystawcy</b></p>
        <p class="right">';$html .= $imiep." ".$nazwiskop.'</p>

    ';
    $pdf->writeHTML($html, true, false, true, false, '');

    $pdf->Output();