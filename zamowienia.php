<?php
session_start();
$page = "zamowienia";
if (!isset($_SESSION['zalogowany'])) {
  header('Location: index.php');
  exit();
}
if (isset($_SESSION['komunikat'])) {
  $blad = $_SESSION['komunikat'];
}
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
    <h2 class="display-4 text-white">Sekcja zamówienia</h2>
  </center>
  <div class="container">
    <div class="table-responsive">
      <div class="table-wrapper">
        <div class="table-title">
          <div class="row">
            <div class="col-xs-5">
              <h2>Zarządzenie zamówieniami</h2>
            </div>
            <div class="col-xs-5 ml-auto">
            </div>
            <div class="col-xs-5 ml-auto">
            </div>
          </div>
        </div>
        <table id="table_to_highlight" class="table table-striped table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Data</th>
              <th>Status</th>
              <th>Realizacja</th>
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
              $stid = oci_parse($polaczenie, "SELECT * FROM zamowienia");
              $licznik = 1;
              if (oci_execute($stid) == TRUE) {
                while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                  $id_zam = $row['ID_ZAMOWIENIA'];
                  echo "<tr>";
                  echo "<td>" . $licznik . "</td>";
                  $datee = date_create($row['DATA_ZAMOWIENIA']);
                  echo "<td>" . date_format($datee, 'Y-m-d') . "</td>";
                  if ($row['STATUS'] == 0) {
                    echo "<td>Nie zrealizowane</td>";
                  } else {
                    echo "<td>Zrealizowane</td>";
                  }
                  echo "<td>";
                  echo "<a href='#' class='dodaj' id='" . $id_zam . "' title='Przedmioty' data-target='#myModal'  data-toggle='modal' onclick='getid(this.id);goLista()'><i class='material-icons'>&#xe8ef;</i></a>";
                  if ($row['STATUS'] > 0) {
                    echo "<a href='#' class='dodaj' id='" . $id_zam . "' title='Zatwierdź' data-toggle='tooltip' onclick='alert();'><i class='material-icons'>&#xe876;</i></a>";
                  } else {
                    echo "<a href='#' class='dodaj' id='" . $id_zam . "' title='Zatwierdź' data-toggle='tooltip' onclick='getid(this.id);zatwierdz()'><i class='material-icons'>&#xe876;</i></a>";
                  }
                  echo "</td>";
                  echo "</tr>";
                  $licznik++;
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

  <form name="lista" id="lista" method="post" target="_blank" action="lista.php">
    <input type="hidden" name="id_listy" id="id_listy" value="">
  </form>

  <form name="zatwierdz_form" id="zatwierdz_form" method="post" action="zatwierdz_zamowienie.php">
    <input type="hidden" name="id_zatw" id="id_zatw" value="">
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
    var c_id;

    function getid(b_id) {
      c_id = b_id;
      document.getElementById('id_listy').value = b_id;
      document.getElementById('id_zatw').value = b_id;
    }

    function goLista() {
      document.forms["lista"].submit();
    }
  </script>
  <script>
    function alert() {

      Swal.fire({
        icon: 'error',
        title: 'Błąd',
        text: 'Zamówienie jest już zrealizowane!',
      });


    }

    function zatwierdz() {
      Swal.fire({
        title: 'Realizacja zamówienia!',
        text: "Czy zaznaczyć zamówienie jako zrealizowane?",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Anuluj',
        confirmButtonText: 'Tak'
      }).then((result) => {
        if (result.isConfirmed) {
          document.forms["zatwierdz_form"].submit();
        }
      })
    }
  </script>
    <script>
    function blad() {

      var simple = '<?php echo $blad; ?>';


     if (simple == "sukces") {
        Swal.fire({
          icon: 'success',
          title: 'Udało się!!',
          text: 'Zamówienie zostało zatwierdzone!',
        });
      }
    }
  </script>
   <?php
  unset($_SESSION['komunikat']);
  unset($blad);
  ?>
</body>

</html>