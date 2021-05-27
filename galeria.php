<?php
session_start();
$page = "galeria";
if (isset($_SESSION['komunikat'])) {
    $blad = $_SESSION['komunikat'];
}
if (!isset($_SESSION['zalogowany'])) {
  header('Location: index.php');
  exit();
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Usługi warsztatowe</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" /> -->
  <link rel="stylesheet" href="style_dashboard.css">
</head>

<body onload="blad()">

  <?php include 'nav.php'; ?>
  <h2 class="display-4 text-white" style="text-align: center">Sekcja Galerii</h2>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script src="main.js"></script>
  <script>
    $(function() {
      $('#sidebarCollapse').on('click', function() {
        $('#sidebar, #content').toggleClass('active');
      });
    });
  </script>
  <div id="entirebody">
    <div class="container">
      <div class="row">
        <form method="post" action="galeria.php">
          <input type="text" id="inputFilter" name='textFilter' placeholder="Wyszukaj" />
          <input type="submit" class="btn btn-primary btn-lg" value="Filtruj"></button>
          <button type="button" class="btn btn-secondary btn-lg" style="margin-left:5px;" data-toggle="modal" data-target="#dodajZdjecie">Dodaj zdjęcie</button>
        </form>
      </div>
      <div class="row">

        <?php
        require_once "connect.php";
        $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');
        $arrLocales = array('pl_PL', 'pl', 'Polish_Poland.28592');

        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; //potrzebne do wyciągania id z linku
        $id_from_link = parse_url($url, 6);


        setlocale(LC_ALL, $arrLocales);
        // $polaczenie->set_charset("utf8");
        function strftimeV($format, $timestamp)
        {
          return iconv("ISO-8859-2", "UTF-8", ucfirst(strftime($format, $timestamp)));
        }
        if (!$polaczenie) {
          die("Connection failed: " . oci_error());
        } else {

          if (!isset($id_from_link)) { //gdy nie jest ustawione id w linku strony



            if (isset($_POST['textFilter'])) {
              $text = $_POST['textFilter'];
              $sql_query = "SELECT KLIENCI.imie, KLIENCI.nazwisko, KLIENCI.imie || ' ' || KLIENCI.nazwisko as hehe, GALERIA.zdjecie, galeria.komentarz, galeria.stan USLUGI.DATA_OBSLUGI FROM (((KLIENCI INNER JOIN POJAZDY ON klienci.id_klienta = pojazdy.id_klienta)
        INNER JOIN USLUGI
        ON pojazdy.id_pojazdu = uslugi.id_pojazdu)
        INNER JOIN GALERIA ON uslugi.id_uslugi = galeria.id_uslugi) 
        WHERE LOWER(galeria.komentarz) LIKE LOWER('%" . $text . "%') OR LOWER(klienci.imie) || ' ' || LOWER(klienci.nazwisko) LIKE LOWER('%" . $text . "%')
        ORDER BY USLUGI.DATA_OBSLUGI DESC";
            } else {
              $sql_query = "SELECT KLIENCI.imie, KLIENCI.nazwisko, GALERIA.zdjecie, galeria.komentarz, galeria.stan, USLUGI.DATA_OBSLUGI  
        FROM (((KLIENCI INNER JOIN POJAZDY ON klienci.id_klienta = pojazdy.id_klienta)
        INNER JOIN USLUGI
        ON pojazdy.id_pojazdu = uslugi.id_pojazdu)
        INNER JOIN GALERIA ON uslugi.id_uslugi = galeria.id_uslugi)
        ORDER BY USLUGI.DATA_OBSLUGI DESC";
            }
          } else { //gdy w id strony jest ustawione id uslugi 
            $id_from_link = substr($id_from_link, 3);
            $sql_query = "SELECT KLIENCI.imie, KLIENCI.nazwisko, KLIENCI.imie || ' ' || KLIENCI.nazwisko as hehe, GALERIA.zdjecie, galeria.komentarz, galeria.stan USLUGI.DATA_OBSLUGI FROM (((KLIENCI INNER JOIN POJAZDY ON klienci.id_klienta = pojazdy.id_klienta)
        INNER JOIN USLUGI
        ON pojazdy.id_pojazdu = uslugi.id_pojazdu)
        INNER JOIN GALERIA ON uslugi.id_uslugi = galeria.id_uslugi) 
        WHERE uslugi.id_uslugi LIKE '" . $id_from_link . "'
        ORDER BY USLUGI.DATA_OBSLUGI DESC";
          }

          $stid = oci_parse($polaczenie, $sql_query);
          if (oci_execute($stid) == TRUE) {

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
              echo "<div class='col-lg-4 col-12 column'>";
              echo "<div class='content'>";
              echo "<div class='photo_container'>";
              echo "<img src='./gallery/" . $row['ZDJECIE'] . "' alt='zdj' style='width:100%'>";
              echo "</div>";
              echo "<h5>" . $row['IMIE'] . " " . $row['NAZWISKO'] . "</h5>";
              echo "<h6>" . $row['KOMENTARZ'] . "</h6>";

              $datee = date_create($row['DATA_OBSLUGI']);
              $datef = date_format($datee, 'd-m-Y');
              $datetstamp = utf8_encode(strtotime($datef));
              $stan;
              if($row['STAN']==1){
                $stan = 'PRZED';
              }
              else $stan = 'PO';

              echo "<h7 class='data'>" . strftimeV('%d %B %Y', $datetstamp) .' Stan: '. $stan."</h7>";
              echo "</div>";
              echo "</div>";
            }
          }
        }
        oci_close($polaczenie);
        unset($_POST['textFilter']);



        ?>
      </div>
    </div>


    <div id="dodajZdjecie" class="modal fade" role="dialog">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Dodaj zdjęcie</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form method="post" action="dodajzdjecie.php" id="form2" enctype="multipart/form-data">
              <div class="form-group row">
                <label for="imie" class="col-sm-4 col-form-label">Usługa</label>
                <div class="col-sm-8">
                  <input class="col-sm-12 form-control" list="wbrow" id="usluga" name="wselect" autocomplete="off" value="" placeholder="Usługa" onfocus="this.value=''" onchange="this.blur();" required>
                  <datalist id="wbrow" >
                    <?php
                    require_once "connect.php";

                    $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');


                    if (!$polaczenie) {
                      die("Connection failed: " . oci_error());
                    } else {
                      $stid = oci_parse($polaczenie, "SELECT USLUGI.id_uslugi, USLUGI.id_pojazdu, USLUGI.data_obslugi, POJAZDY.marka, POJAZDY.model, KLIENCI.imie ,KLIENCI.nazwisko FROM USLUGI INNER JOIN POJAZDY ON uslugi.id_pojazdu = pojazdy.id_pojazdu
                                    INNER JOIN KLIENCI ON pojazdy.id_klienta=klienci.id_klienta ORDER BY USLUGI.data_obslugi DESC");
                      $licznik = 1;
                      if (oci_execute($stid) == TRUE) {
                        while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                          $id_usl = $row['ID_USLUGI'];
                          $marka_poj = $row['MARKA'];
                          $model_poj = $row['MODEL'];
                          $imie_kl = $row['IMIE'];
                          $nazw_kl = $row['NAZWISKO'];
                          $datee = date_create($row['DATA_OBSLUGI']);
                          $datee = date_format($datee, 'Y-m-d');
                          echo "<option data-id='$id_usl' value='" . $imie_kl . " " . $nazw_kl . ', ' . " $marka_poj $model_poj | $datee'></option>";
                        }
                      }
                    }
                    oci_close($polaczenie);
                    ?>
                  </datalist>
                  <input type="hidden" id="id_usl" name="id_usl" value="">
                </div>
              </div>


              <div class="form-group row ">
                <label for="stan" class="col-sm-4 col-form-label">Stan</label>
                <div class="form-check form-check-inline col-sm-2" style="padding-left: 20px">
                  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="przed" value="option1" required>
                  <label class="form-check-label" for="inlineRadio1 ">Przed</label>
                </div>
                <div class="form-check form-check-inline col-sm-3">
                  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="po" value="option2">
                  <label class="form-check-label" for="inlineRadio2">Po</label>
                </div>
              </div>


              <div class="form-group row ">
                <label for="stan" class="col-sm-4 col-form-label">Komentarz</label>

                <textarea id="komentarz" name="komentarz" rows="5" cols="33" style="margin-left: 13px; padding-right:30px;border-radius: 5px;border: 1px solid #ccc;"> </textarea>

              </div>
              <div class="form-group row">
                <label for="nazwisko" class="col-sm-4 col-form-label">Zdjęcie</label>
                <div class="col-sm-8">

                  <input type="file" name="fileToUpload" id="fileToUpload" accept="image/png, image/jpeg" required>
                </div>
              </div>

          </div>
          <div class="modal-footer">
            <input type="submit" class="sub form-control col-sm-4" value="Dodaj">
            <input type="hidden" name="id_w" id="id_w" value="">
          </div>

         


          </form>
        </div>
      </div>
    </div>



   


    <script>
      $("input").on('input', function() {
        var g = $('#usluga').val();
        var id = $('#wbrow option[value="' + g + '"]').attr('data-id');
        document.getElementById('id_usl').value = id;
      });
    </script>



<script>
        function blad() {

            var simple = '<?php echo $blad; ?>';
             if (simple == "zaduzy") {
                Swal.fire({
                    icon: 'error',
                    title: 'Błąd!',
                    text: 'Zdjęcie ma zbyt duży rozmiar!',
                });
            } 
            else if (simple == "blad") {
                Swal.fire({
                    icon: 'error',
                    title: 'Błąd',
                    text: 'Zdjęcie nie zostało dodane!',
                });
            } else if (simple == "dodany") {
                Swal.fire({
                    icon: 'success',
                    title: 'Udało się!',
                    text: 'Zdjęcie zostało dodane!',
                });
            } 
            else if (simple == "zlyformat") {
                Swal.fire({
                    icon: 'error',
                    title: 'Błąd!',
                    text: 'Zdjęcie ma zły format!',
                });
            }
        }
    </script>
        <?php
    unset($_SESSION['komunikat']);
    unset($blad);
    ?>

</body>
<style>
  * {
    box-sizing: border-box;
  }

  body {
    background-color: #f1f1f1;
    padding: 20px;
  }

  /* Center website */
  .main {
    max-width: 1000px;
    margin: auto;
  }

  h1 {
    font-size: 50px;
    word-break: break-all;
  }

  .row {
    margin: 8px -16px;
  }

  /* Add padding BETWEEN each column (if you want) */
  .row,
  .row>.column {
    padding: 8px;
  }

  /* Create three equal columns that floats next to each other */
  .column {
    float: left;
    width: 33.33%;
  }

  /* Clear floats after rows */
  .row:after {
    content: "";
    display: table;
    clear: both;
  }

  /* Content */
  .content {
    background-color: white;
    padding: 15px;
    height: 100%;
    border-radius: 2px;
    max-width: 380px;
  }

  .photo_container {
    height: 200px;
  }

  /* The "show" class is added to the filtered elements */
  .show {
    display: block;
  }

  /* Style the buttons */
  .btnfilter {
    border: none;
    outline: none;
    padding: 12px 16px;
    border-radius: 10px;
    background-color: white;
    cursor: pointer;
    margin-top: 8px;
  }

  /* Add a grey background color on mouse-over */
  .btn:hover {
    background-color: #ddd;
  }

  /* Add a dark background color to the active button */
  .btn.active {
    background-color: #666;
    color: white;
  }

  #searchfilter {
    margin-top: 12px;
  }

  #inputFilter {
    display: inline-block;
    padding: 13px 10px;
    line-height: 100%;
    border-radius: 10px;
    margin-right: 10px;
    margin-top: 10px;
    border-style: none;
  }

  img {
    max-width: 360px;
    max-height: 200px;
    position: relative;
    padding-bottom: 10px;
    top: 50%;
    transform: translateY(-50%);
  }

  form {
    margin-left: 1%;
  }
</style>

</html>