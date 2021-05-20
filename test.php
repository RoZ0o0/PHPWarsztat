<?php
    include('library1/tcpdf.php');
    $pdf = new TCPDF('P','mm','A4', true, 'UTF-8', false);

    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetFont('dejavusans', '', 10);

    $pdf->AddPage();
    $pdf->writeHTML("JSśśąąśąśąśżź  GURWA MADŹ");
    $html = '
    <style>
    .usluga table, .usluga td, .usluga th{
        border: 1px solid black;
      }
    </style>
    <body>
    <table>
        <tr>
            <td>
                <p><b>Faktura Nr: </b>JD</p>
                <p><b>Data Wystawienia</b></p>
            </td>
            <td><img src="https://i.kym-cdn.com/entries/icons/original/000/008/001/Spurdo.jpg"></td>
        </tr>
    </table>

    <hr>

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
            <td>Janusz Markowski</td>
        </tr>
    </table>

    <table class="usluga">
        <tr>
            <th><b>L.P.</b></th>
            <th><b>Nazwa towaru/uslugi</b></th>
            <th><b>Ilość</b></th>
            <th><b>Cena netto</b></th>
            <th><b>Wartość Netto</b></th>
            <th><b>VAT%</b></th>
            <th><b>Wartość VAT</b></th>
            <th><b>Wartość Brutto</b></th>
        </tr>
        <tr>
            <td>1</td>
            <td>Dawanie kodu</td>
            <td>1 szt</td>
            <td>500zł</td>
            <td>500zł</td>
            <td>500zł</td>
            <td>500zł</td>
            <td>500zł</td>
        </tr>
        <tr>
            <td style="border: none;"></td>
            <td style="border: none;"></td>
            <td style="border: none;"></td>
            <td>Razem</td>
            <td>500zł</td>
            <td>500zł</td>
            <td>500zł</td>
            <td>500zł</td>
        </tr>
        <tr>
            <td style="border: none;"></td>
            <td style="border: none;"></td>
            <td style="border: none;"></td>
            <td>W tym</td>
            <td>500zł</td>
            <td>500zł</td>
            <td>500zł</td>
            <td>500zł</td>
        </tr>
    </table>
    </html>
    ';
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Cell(190,10,"JD",1,1,'C');

    $pdf->Output();