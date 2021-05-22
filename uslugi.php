<?php
session_start();
$page = "uslugi";
if (isset($_SESSION['komunikat'])) {
  $blad = $_SESSION['komunikat'];
}
if (!isset($_SESSION['zalogowany'])) {
  header('Location: index.php');
  exit();
}
$imiep = $_SESSION['imie'] . " " . $_SESSION['nazwisko'];
?>
<!DOCTYPE html>
<html>

<head>
  <title>Usługi warsztatowe</title>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="style_dashboard.css">
  <link rel="stylesheet" href="pracownik.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <?php include 'nav.php'; ?>
  <script>
    $(function() {
      $('#sidebarCollapse').on('click', function() {
        $('#sidebar, #content').toggleClass('active');
      });
    });
  </script>

  <script>
    $(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>


</head>

<body onload="blad()">
  <center>
    <h2 class="display-4 text-white">Sekcja usługi</h2>
  </center>
  <div class="container">
    <div class="table-responsive">
      <div class="table-wrapper">
        <div class="table-title">
          <div class="row">
            <div class="col-xs-5">
              <h2>Zarządzenie usługami</h2>
            </div>
            <div class="col-xs-2 ml-auto">
              <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="material-icons">&#xE147;</i> <span>Dodaj Usługe</span></a>
              <!-- <a href="#" class="btn btn-primary"><i class="material-icons">&#xE24D;</i> <span>Exportuj do Excela</span></a> -->
            </div>
          </div>
        </div>
        <table id="table_to_highlight" class="table table-striped table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Pracownik</th>
              <th>Warsztat</th>
              <th>Data</th>
              <th>Cena</th>
              <th>Pojazd</th>
              <th>Akcja</th>
            </tr>
          </thead>
          <tbody>
            <?php
            require_once "connect.php";

            $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

            // $polaczenie->set_charset("utf8");

            if (!$polaczenie) {
              die("Connection failed: " . oci_error());
            } else {
              $stid = oci_parse($polaczenie, "SELECT id_uslugi, pracownicy.imie as imiep, pracownicy.nazwisko as nazwiskop, warsztaty.adres, warsztaty.miasto, uslugi.data_obslugi, uslugi.cena, pojazdy.model, pojazdy.marka, klienci.imie, klienci.nazwisko  FROM uslugi inner join pracownicy on uslugi.id_pracownika=pracownicy.id_pracownika inner join warsztaty on uslugi.id_warsztatu=warsztaty.id_warsztatu inner join pojazdy on uslugi.id_pojazdu=pojazdy.id_pojazdu inner join klienci on pojazdy.id_pojazdu=klienci.id_klienta");
              $licznik = 1;
              if (oci_execute($stid) == TRUE) {
                // $ilu = $result->num_rows;
                // $_SESSION['ile'] = $ilu;
                // if ($ilu > 0) {
                while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                  echo "<tr>";
                  echo "<td>" . $licznik . "</td>";
                  echo "<td>" . $row['IMIEP'] . " " . $row['NAZWISKOP'] . "</td>";
                  echo "<td>" . $row['ADRES'] . " | " . $row['MIASTO'] . "</td>";
                  $datee = date_create($row['DATA_OBSLUGI']);
                  echo "<td>" . date_format($datee, 'Y-m-d') . "</td>";
                  echo "<td>" . $row['CENA'] . "</td>";
                  echo "<td>" . $row['MODEL'] . " " . $row['MARKA'] . " | " . $row['IMIE'] .  " " . $row['NAZWISKO'] . "</td>";

                  $faktura = 0;
                  $id_uslugi = $row['ID_USLUGI'];

                  $stid2 = oci_parse($polaczenie, "SELECT * from faktury where id_uslugi=$id_uslugi");
                  if (oci_execute($stid2) == TRUE) {
                    while ((oci_fetch_array($stid2, OCI_BOTH)) != false) {
                      $faktura++;
                    }
                  }

                  echo "<td style='width:9%'>";
                   if ($faktura > 0) {
                    echo "<a href='#' class='zdjecia' id='" . $row['ID_USLUGI'] . "' title='Galeria' data-toggle='tooltip' onclick='getid(this.id);goGaleria()'><i class='material-icons'>&#xe3f4;</i></a>";
                    echo "<a href='#' class='pdf' id='" . $row['ID_USLUGI'] . "' title='PDF' data-toggle='tooltip' onclick='faktura_close()'><i class='material-icons'>&#xe873;</i></a>";
                    echo "<a href='#' class='settings' id='" . $row['ID_USLUGI'] . "' title='Edytowanie' data-target='#editModal' onclick='edit_close();'><i class='material-icons'>&#xE8B8;</i></a>";
                    echo "<a href='#' class='delete' id='" . $row['ID_USLUGI'] . "' title='Usunięcie' data-toggle='tooltip' onclick='getid(this.id);deletePrac()'><i class='material-icons'>&#xE5C9;</i></a>";
                  } else {
                    echo "<a href='#' class='zdjecia' id='" . $row['ID_USLUGI'] . "' title='Galeria' data-toggle='tooltip' onclick='getid(this.id);goGaleria()'><i class='material-icons'>&#xe3f4;</i></a>";
                    echo "<a href='#' class='pdf' id='" . $row['ID_USLUGI'] . "' title='PDF' data-toggle='tooltip' onclick='getid(this.id);createPdf()'><i class='material-icons'>&#xe873;</i></a>";
                    echo "<a href='#' class='settings' id='" . $row['ID_USLUGI'] . "' title='Edytowanie' data-target='#editModal'  data-toggle='modal' onclick='getid(this.id);getlicznik(" . $licznik . ");showTableData()'><i class='material-icons'>&#xE8B8;</i></a>";
                    echo "<a href='#' class='delete' id='" . $row['ID_USLUGI'] . "' title='Usunięcie' data-toggle='tooltip' onclick='getid(this.id);deletePrac()'><i class='material-icons'>&#xE5C9;</i></a>";
                  }
                  echo "</td>";
                  echo "</tr>";
                  $licznik++;
                  $faktura = 0;
                }
              }
            }
            oci_close($polaczenie);
            ?>
          </tbody>
        </table>

        <div class='pagination-container'>
          <nav>
            <ul class="pagination">

              <li data-page="prev">
                <span>
                  < <span class="sr-only">(current)
                </span></span>
              </li>
              <li data-page="next" id="prev">
                <span> > <span class="sr-only">(current)</span></span>
              </li>
            </ul>
          </nav>
        </div>
        <div class="form-group hidden">
          <select class="form-control" name="state" id="maxRows" style="width: 10%">
            <option value="5000">Wszystko</option>
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="15">15</option>
            <option value="20">20</option>
          </select>

        </div>
      </div>
    </div>
  </div>

  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">

      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Dodaj Usługe</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form method="post" action="dodajusluge.php" id="form">
            <div class="form-group row">
              <label for="pracownik" class="col-sm-4 col-form-label">Pracownik</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="pracownik" name="pracownik" placeholder="Pracownik" value="<?php echo $imiep ?>" disabled required>
                <input type="hidden" id="id_pracownika" name="id_pracownika" value="<?php echo $_SESSION['id_prac']; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="warsztat" class="col-sm-4 col-form-label">Warsztat</label>
              <div class="col-sm-8">
                <input class="col-sm-12 form-control" list="wbrow" id="wselect" name="wselect" autocomplete="off" value="" placeholder="Podaj Warsztat" required>
                <datalist id="wbrow">
                  <?php
                  require_once "connect.php";

                  $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

                  if (!$polaczenie) {
                    die("Connection failed: " . oci_error());
                  } else {
                    $stid = oci_parse($polaczenie, "SELECT * FROM warsztaty");
                    $licznik = 1;
                    if (oci_execute($stid) == TRUE) {
                      while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                        $idw = $row['ID_WARSZTATU'];
                        $adres = $row['ADRES'];
                        $miasto = $row['MIASTO'];
                        echo "<option data-id='$idw' value='" . $adres . " " . $miasto . "'></option>";
                      }
                    }
                  }
                  oci_close($polaczenie);
                  ?>
                </datalist>
                <input type="hidden" id="id_war" name="id_war" value="">
              </div>
            </div>
            <div class="form-group row">
              <label for="date" class="col-sm-4 col-form-label">Data Obsługi</label>
              <div class="col-sm-8">
                <input type="date" class="form-control" id="date" name="date" placeholder="Data Obsługi" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="cena" class="col-sm-4 col-form-label">Cena</label>
              <div class="col-sm-8">
                <input type="number" class="form-control" id="cena" name="cena" placeholder="Cena" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="czesci" class="col-sm-4 col-form-label">Części</label>
              <div class="col-sm-8">
                <select id="czes" name="czesci[]" style="width:100%" size="3" onmouseover="this.style.width='150%'; this.size='5';" onmouseout="this.style.width='100%';  this.size='3';" multiple="multiple">
                  <?php
                  require_once "connect.php";

                  $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

                  if (!$polaczenie) {
                    die("Connection failed: " . oci_error());
                  } else {
                    $stid = oci_parse($polaczenie, "SELECT * FROM czesci where liczba_dostepnych_sztuk>0");
                    $licznik = 1;
                    if (oci_execute($stid) == TRUE) {
                      while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                        $id_cz = $row['ID_CZESCI'];
                        $nazwa = $row['NAZWA_CZESCI'];
                        $nr_czesci = $row['NR_CZESCI'];
                        $cena = $row['CENA'];
                        echo "<option value='$id_cz'>$nazwa | $nr_czesci | $cena zł</option>";
                      }
                    }
                  }
                  oci_close($polaczenie);
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="pojazd" class="col-sm-4 col-form-label">Pojazd</label>
              <div class="col-sm-8">
                <input class="col-sm-12 form-control" list="pbrow" id="pselect" name="pselect" autocomplete="off" value="" placeholder="Podaj Pojazd" required>
                <datalist id="pbrow">
                  <?php
                  require_once "connect.php";

                  $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

                  if (!$polaczenie) {
                    die("Connection failed: " . oci_error());
                  } else {
                    $stid = oci_parse($polaczenie, "SELECT pojazdy.id_pojazdu, pojazdy.marka, pojazdy.model, klienci.imie, klienci.nazwisko FROM pojazdy inner join klienci on pojazdy.id_klienta=klienci.id_klienta");
                    $licznik = 1;
                    if (oci_execute($stid) == TRUE) {
                      while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                        $idp = $row['ID_POJAZDU'];
                        $marka = $row['MARKA'];
                        $model = $row['MODEL'];
                        $imiek = $row['IMIE'];
                        $nazwiskok = $row['NAZWISKO'];
                        echo "<option data-id='$idp' value='" . $marka . " " . $model . " " . $imiek . " " . $nazwiskok . "'></option>";
                      }
                    }
                  }
                  oci_close($polaczenie);
                  ?>
                </datalist>
                <input type="hidden" id="id_poj" name="id_poj" value="">
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <input type="submit" class="sub form-control col-sm-4" value="Dodaj Pracownika">
        </div>
        </form>
      </div>
    </div>
  </div>

  <div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edytuj Usługę</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form method="post" action="edituslugi.php" id="form1">
            <div class="form-group row">
              <label for="pracownike" class="col-sm-4 col-form-label">Pracownik</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="pracownike" name="pracownike" placeholder="Pracownik" value="<?php echo $imiep ?>" disabled required>
                <input type="hidden" id="id_pracownikae" name="id_pracownikae" value="<?php echo $_SESSION['id_prac']; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="warsztate" class="col-sm-4 col-form-label">Warsztat</label>
              <div class="col-sm-8">
                <input class="col-sm-12 form-control" list="wbrowe" id="wselecte" name="wselecte" autocomplete="off" value="" placeholder="Podaj Warsztat" required>
                <datalist id="wbrowe">
                  <?php
                  require_once "connect.php";

                  $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

                  if (!$polaczenie) {
                    die("Connection failed: " . oci_error());
                  } else {
                    $stid = oci_parse($polaczenie, "SELECT * FROM warsztaty");
                    $licznik = 1;
                    if (oci_execute($stid) == TRUE) {
                      while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                        $idw = $row['ID_WARSZTATU'];
                        $adres = $row['ADRES'];
                        $miasto = $row['MIASTO'];
                        echo "<option data-id='$idw' value='" . $adres . " " . $miasto . "'></option>";
                      }
                    }
                  }
                  oci_close($polaczenie);
                  ?>
                </datalist>
                <input type="hidden" id="id_ware" name="id_ware" value="">
              </div>
            </div>
            <div class="form-group row">
              <label for="datee" class="col-sm-4 col-form-label">Data Obsługi</label>
              <div class="col-sm-8">
                <input type="date" class="form-control" id="datee" name="datee" placeholder="Data Obsługi" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="cenae" class="col-sm-4 col-form-label">Cena</label>
              <div class="col-sm-8">
                <input type="number" class="form-control" id="cenae" name="cenae" placeholder="Cena" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="pojazde" class="col-sm-4 col-form-label">Pojazd</label>
              <div class="col-sm-8">
                <input class="col-sm-12 form-control" list="pbrowe" id="pselecte" name="pselecte" autocomplete="off" value="" placeholder="Podaj Pojazd" required>
                <datalist id="pbrowe">
                  <?php
                  require_once "connect.php";

                  $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

                  if (!$polaczenie) {
                    die("Connection failed: " . oci_error());
                  } else {
                    $stid = oci_parse($polaczenie, "SELECT pojazdy.id_pojazdu, pojazdy.marka, pojazdy.model, klienci.imie, klienci.nazwisko FROM pojazdy inner join klienci on pojazdy.id_klienta=klienci.id_klienta");
                    $licznik = 1;
                    if (oci_execute($stid) == TRUE) {
                      while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                        $idp = $row['ID_POJAZDU'];
                        $marka = $row['MARKA'];
                        $model = $row['MODEL'];
                        $imiek = $row['IMIE'];
                        $nazwiskok = $row['NAZWISKO'];
                        echo "<option data-id='$idp' value='" . $marka . " " . $model . " " . $imiek . " " . $nazwiskok . "'></option>";
                      }
                    }
                  }
                  oci_close($polaczenie);
                  ?>
                </datalist>
                <input type="hidden" id="id_poje" name="id_poje" value="">
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <input type="submit" class="sub form-control col-sm-4" value="Edytuj Usługę">
          <input type="hidden" name="id_p" id="id_p" value="">
        </div>
        </form>
      </div>
    </div>
  </div>

  <p id="test"></p>

  <form name="delprac" id="delprac" method="post" action="usunusluge.php">
    <input type="hidden" name="id_del" id="id_del" value="">
  </form>

  <form name="faktura" id="faktura" method="post" action="utworzfakture.php">
    <input type="hidden" name="id_usl" id="id_usl" value="">
  </form>

  <form name="galeria" id="galeria" method="post" action="galeria.php">
    <input type="hidden" name="id_gal" id="id_gal" value="">
  </form>

  <script>
    getPagination('#table_to_highlight');

    function getPagination(table) {
      var lastPage = 1;

      $('#maxRows')
        .on('change', function(evt) {

          lastPage = 1;
          $('.pagination')
            .find('li')
            .slice(1, -1)
            .remove();
          var trnum = 0;
          var maxRows = parseInt($(this).val());

          if (maxRows == 5000) {
            $('.pagination').hide();
          } else {
            $('.pagination').show();
          }

          if (maxRows)

            var totalRows = $(table + ' tbody tr').length;
          $(table + ' tr:gt(0)').each(function() {
            trnum++;
            if (trnum > maxRows) {

              $(this).hide();
            }
            if (trnum <= maxRows) {
              $(this).show();
            }
          });
          if (totalRows > maxRows) {
            var pagenum = Math.ceil(totalRows / maxRows);
            for (var i = 1; i <= pagenum;) {
              $('.pagination #prev')
                .before(
                  '<li data-page="' +
                  i +
                  '">\
								  <span>' +
                  i++ +
                  '<span class="sr-only">(current)</span></span>\
								</li>'
                )
                .show();
            }
          }
          $('.pagination [data-page="1"]').addClass('active');
          $('.pagination li').on('click', function(evt) {
            evt.stopImmediatePropagation();
            evt.preventDefault();
            var pageNum = $(this).attr('data-page');

            var maxRows = parseInt($('#maxRows').val());

            if (pageNum == 'prev') {
              if (lastPage == 1) {
                return;
              }
              pageNum = --lastPage;
            }
            if (pageNum == 'next') {
              if (lastPage == $('.pagination li').length - 2) {
                return;
              }
              pageNum = ++lastPage;
            }

            lastPage = pageNum;
            var trIndex = 0;
            $('.pagination li').removeClass('active');
            $('.pagination [data-page="' + lastPage + '"]').addClass('active');
            limitPagging();
            $(table + ' tr:gt(0)').each(function() {
              trIndex++;
              if (
                trIndex > maxRows * pageNum ||
                trIndex <= maxRows * pageNum - maxRows
              ) {
                $(this).hide();
              } else {
                $(this).show();
              }
            });
          });
          limitPagging();
        })
        .val(5)
        .change();
    }

    function limitPagging() {

      if ($('.pagination li').length > 7) {
        if ($('.pagination li.active').attr('data-page') <= 3) {
          $('.pagination li:gt(5)').hide();
          $('.pagination li:lt(5)').show();
          $('.pagination [data-page="next"]').show();
        }
        if ($('.pagination li.active').attr('data-page') > 3) {
          $('.pagination li:gt(0)').hide();
          $('.pagination [data-page="next"]').show();
          for (let i = (parseInt($('.pagination li.active').attr('data-page')) - 2); i <= (parseInt($('.pagination li.active').attr('data-page')) + 2); i++) {
            $('.pagination [data-page="' + i + '"]').show();

          }

        }
      }
    }
  </script>
  <script>
    function confirm_alert() {
      return Swal.fire({
        icon: 'error',
        title: 'Błąd',
        text: 'Nie masz uprawnień!',
      });
    }
  </script>

  <script>
    function edit_close() {
      return Swal.fire({
        icon: 'error',
        title: 'Błąd',
        text: 'Nie można edytować, ponieważ usługa już jest zrealizowana!',
      });
    }
  </script>
  <script>
    function faktura_close() {
      return Swal.fire({
        icon: 'error',
        title: 'Błąd',
        text: 'Nie można stworzyć faktury, ponieważ faktura już istnieje!',
      });
    }
  </script>

  <script>
    function blad() {

      var simple = '<?php echo $blad; ?>';

      if (simple == "istnieje") {
        Swal.fire({
          icon: 'error',
          title: 'Błąd',
          text: 'Usługa już istnieje!',
        });
      } else if (simple == "dodany") {
        Swal.fire({
          icon: 'success',
          title: 'Udało się!',
          text: 'Usługa została dodana!',
        });
      } else if (simple == "edycja") {
        Swal.fire({
          icon: 'success',
          title: 'Udało się!',
          text: 'Usługa została edytowana!',
        });
      } else if (simple == "usuniete") {
        Swal.fire({
          icon: 'success',
          title: 'Udało się!',
          text: 'Usługa została usunięta!',
        });
      } else if (simple == "fakturkapyk") {
        let timerInterval
        Swal.fire({
          title: 'Faktura się generuje!',
          html: 'Faktura wygeneruje się w <b></b> milisekund.',
          timer: 2000,
          timerProgressBar: true,
          didOpen: () => {
            Swal.showLoading()
            timerInterval = setInterval(() => {
              const content = Swal.getHtmlContainer()
              if (content) {
                const b = content.querySelector('b')
                if (b) {
                  b.textContent = Swal.getTimerLeft()
                }
              }
            }, 100)
          },
          willClose: () => {
            clearInterval(timerInterval)
          }
        }).then((result) => {
          if (result.dismiss === Swal.DismissReason.timer) {
            console.log('Zamknięto okno!')
          }
        })
      } else if (simple == "fakturaniepyk") {
        Swal.fire({
          icon: 'error',
          title: 'Błąd!',
          text: 'Faktura już istnieje!',
        });
      }
    }
  </script>
  <script>
    function deletePrac() {
      Swal.fire({
        title: 'Jesteś pewien?',
        text: "Nie będziesz mógł tego cofnąć!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Anuluj',
        confirmButtonText: 'Tak, usuń!'
      }).then((result) => {
        if (result.isConfirmed) {
          document.forms["delprac"].submit();
        }
      })
    }
  </script>
  <script>
    function createPdf() {
      Swal.fire({
        title: 'Stworzyć fakturę danej usługi?',
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: `Stwórz`,
        cancelButtonText: `Anuluj`
      }).then((result) => {
        if (result.isConfirmed) {
          document.forms["faktura"].submit();
        }
      })
    }
  </script>
  <script>
    function goGaleria() {
      Swal.fire({
        title: 'Przejść do galerii usługi?',
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: `Tak`,
        cancelButtonText: `Anuluj`
      }).then((result) => {
        if (result.isConfirmed) {
          document.forms["galeria"].submit();
        }
      })
    }
  </script>
  <script>
    var b_id;
    var licz;

    function getid(c_id) {
      b_id = c_id;
      document.getElementById('id_p').value = b_id;
      document.getElementById('id_del').value = b_id;
      document.getElementById('id_usl').value = b_id;
      document.getElementById('id_gal').value=b_id;
      document.getElementById("galeria").action = "galeria.php?id="+b_id;
      return b_id;
    }

    function getlicznik(licz1) {
      licz = licz1;
      return licz;
    }

    function showTableData() {
      var myTab = document.getElementById('table_to_highlight');
      var array = [];

      for (i = licz; i < licz + 1; i++) {
        array[i] = [];
        var objCells = myTab.rows.item(i).cells;

        for (var j = 1; j < objCells.length - 1; j++) {
          array[i][j] = objCells.item(j).innerHTML;
        }
      }
      document.getElementById("wselecte").value = array[licz][2];
      document.getElementById("datee").value = array[licz][3];
      document.getElementById("cenae").value = array[licz][4];
      document.getElementById("pselecte").value = array[licz][5];
    }
  </script>
  <script>
    $("input").on('input', function() {
      var g = $('#wselect').val();
      var id = $('#wbrow option[value="' + g + '"]').attr('data-id');
      document.getElementById('id_war').value = id;
    });
    $("input").on('input', function() {
      var g = $('#pselect').val();
      var id = $('#pbrow option[value="' + g + '"]').attr('data-id');
      document.getElementById('id_poj').value = id;
    });
  </script>
  <script>
    $("input").on('input', function() {
      var g = $('#wselecte').val();
      var id = $('#wbrowe option[value="' + g + '"]').attr('data-id');
      document.getElementById('id_ware').value = id;
    });
  </script>
  <script>
    $("input").on('input', function() {
      var g = $('#pselecte').val();
      var id = $('#pbrowe option[value="' + g + '"]').attr('data-id');
      document.getElementById('id_poje').value = id;
    });
  </script>
  <?php
  unset($_SESSION['komunikat']);
  unset($blad);
  ?>
</body>

</html>