<?php
session_start();
$page = "czesci";
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
  <script>
    var c_id;
    var cos;
    var array = [];
    var licznik = 0;
    var licz;
    var val;

    function getid(b_id) {
      c_id = b_id;
      cos = b_id + "czesc";
      // alert(b_id);
    }

    function addCzesc() {
      val = document.getElementById(cos).value;
      document.getElementById(cos).value = '';
      array[licznik] = [];
      array[licznik][0] = c_id;
      array[licznik][1] = val;

      licznik++;
      JSON.stringify(array);
    }

    $(document).ready(function() {
      $('#btn').click(function() {
        $('#str').val(JSON.stringify(array));
      });
    });

    function getlicznik(licz1) {
      licz = licz1;
      return licz;
    }

    function showTableData() {
      var myTab = document.getElementById('table_to_highlight');
      var arr = [];

      for (i = licz; i < licz + 1; i++) {
        arr[i] = [];
        var objCells = myTab.rows.item(i).cells;

        for (var j = 1; j < objCells.length - 1; j++) {
          arr[i][j] = objCells.item(j).innerHTML;
        }
      }
      $('#zamowienia').append('<p>' + arr[licz][1] + ' | ' + arr[licz][2] + ' | ' + arr[licz][3] + ': ' + val + ' szt.' + '</p>');
      document.getElementById('info').innerHTML = 'Przedmioty w koszyku';
    }
  </script>

</head>

<body onload="blad()">
  <center>
    <h2 class="display-4 text-white">Sekcja części</h2>
  </center>
  <div class="container">
    <div class="table-responsive">
      <div class="table-wrapper">
        <div class="table-title">
          <div class="row">
            <div class="col-xs-5">
              <h2>Zarządzenie częściami</h2>
            </div>
            <div class="col-xs-5 ml-auto">
              <input class="form-control" type="text" id="myInput" onkeyup="myFunction()" placeholder="Wyszukaj części">
            </div>
            <div class="col-xs-5 ml-auto">
              <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="material-icons">&#xe8cc;</i> <span>Koszyk</span></a>
            </div>
          </div>
        </div>
        <table id="table_to_highlight" class="table table-striped table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Nazwa</th>
              <th>Numer</th>
              <th>Opis</th>
              <th>Cena</th>
              <th>Sztuki</th>
              <th style='width:5%;'>Zamówienie</th>
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
              $stid = oci_parse($polaczenie, "SELECT * FROM czesci");
              $licznik = 1;
              if (oci_execute($stid) == TRUE) {
                // $ilu = $result->num_rows;
                // $_SESSION['ile'] = $ilu;
                // if ($ilu > 0) {
                while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                  $id_czescis = $row['ID_CZESCI'] . "czesc";
                  $id_czesc = $row['ID_CZESCI'];
                  echo "<tr>";
                  echo "<td>" . $licznik . "</td>";
                  echo "<td>" . $row['NAZWA_CZESCI'] . "</td>";
                  echo "<td>" . $row['NR_CZESCI'] . "</td>";
                  echo "<td>" . $row['OPIS'] . "</td>";
                  echo "<td>" . $row['CENA'] . "</td>";
                  if ($row['LICZBA_DOSTEPNYCH_SZTUK'] == 0) {
                    echo "<td>Brak</td>";
                  } else {
                    echo "<td>" . $row['LICZBA_DOSTEPNYCH_SZTUK'] . "</td>";
                  }
                  echo "<td><input id='$id_czescis' class='form-control' style='width:50px; display:inline;' type='number'>";
                  echo "<a href='#' class='dodaj' id='" . $id_czesc . "' title='Dodaj' data-toggle='tooltip' onclick='getid(this.id);addCzesc();getlicznik(" . $licznik . ");showTableData()'><i class='material-icons'>&#xe145;</i></a>";
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


  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">

      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Zamówienie</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form method="post" action="koszyk.php" id="form">
            <div class="form-group row">
              <div class="col-sm-12" id="zamowienia">
                <br>
                <center>
                  <p id="info">Koszyk jest pusty</p>
                </center>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <input type="submit" class="sub form-control col-sm-4" id="btn" name="submit" value="Zamów">
          <input type="hidden" id="str" name="str" value="" />
        </div>
        </form>
      </div>
    </div>
  </div>

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

    $(document).ready(function() {
      $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#table_to_highlight tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      $('#myInput').on("keyup", function() {
        if (!$(this).val()) {
          $('#maxRows').val(5).change();
        }
      });
    });
  </script>
  <script>
    function doSomething(b_id) {
      alert(b_id);
    }
  </script>
  <script>
    function blad() {

      var simple = '<?php echo $blad; ?>';

      if (simple == "istnieje") {
        Swal.fire({
          icon: 'error',
          title: 'Błąd',
          text: 'Wystąpił błąd!',
        });
      } else if (simple == "dodany") {
        Swal.fire({
          icon: 'success',
          title: 'Udało się!',
          text: 'Zamówienie zostało stworzone!',
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