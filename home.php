<h2 class="display-4 text-white">Strona główna</h2>
<p class="lead text-white mb-0">Spurdo spardum dolor sit amet, consectetur adipiscing spurdo, sed do spardo tempor incididunt ut labore et dolore magna spurdo.</p>
<div class="separator"></div>
<div class="row text-white">
  <div class="col-lg-7">
    <table class="content-table">

    </table>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <div>
      <select class="chartSelect form-control" id="chartSelect" name="chartSelect" style="width: 20%;">
        <option value="-1">Wszystkie</option>
        <option value="1">Wynagrodzenie</option>
        <option value="2">Marki</option>
        <option value="3">Naprawy</option>
        <option value="4">Kody pocztowe</option>
        <option value="5">Części</option>
      </select>
    </div>
    <div id="container" class="container" style="position: relative; left: 20%;">
      <div class="outside_chart" id="div1" style="width: 1110px;height:570px;background-color:#ffffff; margin-left:auto; margin-right:auto;border-radius:20px;">
        <div id="wynagrodzenie" style="width: 970px; height: 550px;padding-top: 25px;padding-left: 60px; margin-top:10px;"></div>
      </div>
      <div class="outside_chart" id="div2" style="width: 1110px;height:570px;background-color:#ffffff; margin-left:auto; margin-right:auto;border-radius:20px;">
        <div id="marka" style="width: 970px; height: 550px;padding-top: 25px;padding-left: 60px; margin-top:10px;"></div>
      </div>
      <div class="outside_chart" id="div3" style="width: 1110px;height:570px;background-color:#ffffff; margin-left:auto; margin-right:auto;border-radius:20px;">
        <div id="naprawy" style="width: 970px; height: 550px;padding-top: 25px;padding-left: 60px; margin-top:10px;"></div>
      </div>
      <div class="outside-chart" id="div4" style="width: 1110px;height:570px;background-color:#fff; margin-left:auto; margin-right:auto;border-radius:20px;">
      <div id="klienci_kody" style="width: 970px; height: 570px;margin-left:auto;margin-right:auto;margin-top:10px;"></div></div>

      <div class="outside-chart" id="div5" style="width: 1110px;height:570px;background-color:#ffffff; margin-left:auto; margin-right:auto;border-radius:20px;">
      <!-- <label><h2 style="color:purple;">Najczęściej sprzedawane części</h2></label> -->
       <div id="czesci_wykres" style="width: 970px; height: 550px;padding-top: 25px;padding-left: 60px; margin-top:10px;"></div>
      </div>

    </div>

    <script>
      google.charts.load('current', {
        'packages': ['bar']
      });
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ['Wynagrodzenie', 'Liczba'],
          <?php
          require_once "connect.php";

          $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

          // $polaczenie->set_charset("utf8");

          if (!$polaczenie) {
            die("Connection failed: " . oci_error());
          } else {
            $curs = oci_new_cursor($polaczenie);
            $stid = oci_parse($polaczenie, "BEGIN STATYSTYKI_CRUD.PRACOWNICY_WYNAGRODZENIE(:cursr); END;");
            oci_bind_by_name($stid, ":cursr", $curs, -1, OCI_B_CURSOR);
            oci_execute($stid);
            oci_execute($curs);

            while (($row = oci_fetch_array($curs, OCI_BOTH)) != false) {
              echo "['" . $row['WYNAGRODZENIE'] . "'," . $row['WYN'] . "],";
            }
          }
          oci_close($polaczenie);
          ?>

        ]);

        var options = {
          width: 970,
          colors: '#3864cc',
          fontSize: 20,
          legend: {
            position: 'none'
          },
          chart: {
            title: 'Zarobki pracowników',
            subtitle: ''
          },
          titleTextStyle: {
            titlePosition: 'none'
          },
          axes: {
            x: {
              0: {
                side: 'top',
                label: ''
              } // Top x-axis.
            }
          },
          bar: {
            groupWidth: "90%"
          }
        };

        var chart = new google.charts.Bar(document.getElementById('wynagrodzenie'));
        // Convert the Classic options to Material options.
        chart.draw(data, google.charts.Bar.convertOptions(options));
      };
    </script>
    <script>
      google.charts.load('current', {
        'packages': ['bar']
      });
      google.charts.setOnLoadCallback(drawMarka);

      function drawMarka() {
        var data = new google.visualization.arrayToDataTable([
          ['Marka', 'Ilość'],
          <?php
          require_once "connect.php";

          $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

          // $polaczenie->set_charset("utf8");

          if (!$polaczenie) {
            die("Connection failed: " . oci_error());
          } else {
            $curs = oci_new_cursor($polaczenie);
            $stid = oci_parse($polaczenie, "BEGIN STATYSTYKI_CRUD.POJAZDY_MARKA(:cursr); END;");
            oci_bind_by_name($stid, ":cursr", $curs, -1, OCI_B_CURSOR);
            oci_execute($stid);
            oci_execute($curs);

            while (($row = oci_fetch_array($curs, OCI_BOTH)) != false) {
              echo "['" . $row['MARKA'] . "'," . $row['LICZ'] . "],";
            }
          }
          oci_close($polaczenie);
          ?>
        ]);

        var options = {
          width: 970,
          colors: '#3864cc',
          fontSize: 20,
          legend: {
            position: 'none'
          },
          chart: {
            title: 'Marki samochodowe klientów',
            subtitle: ''
          },
          axes: {
            x: {
              0: {
                side: 'top',
                label: ''
              } // Top x-axis.
            }
          },
          bar: {
            groupWidth: "90%"
          }
        };

        var chart = new google.charts.Bar(document.getElementById('marka'));
        // Convert the Classic options to Material options.
        chart.draw(data, google.charts.Bar.convertOptions(options));
      };
    </script>
    <script>
      google.charts.load('current', {
        'packages': ['corechart']
      });
      google.charts.setOnLoadCallback(drawNaprawy);

      function drawNaprawy() {
        var data = new google.visualization.arrayToDataTable([
          ['Marka', 'Naprawy'],
          <?php
          require_once "connect.php";

          $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

          // $polaczenie->set_charset("utf8");

          if (!$polaczenie) {
            die("Connection failed: " . oci_error());
          } else {
            $curs = oci_new_cursor($polaczenie);
            $stid = oci_parse($polaczenie, "BEGIN STATYSTYKI_CRUD.USLUGI_MARKA(:cursr); END;");
            oci_bind_by_name($stid, ":cursr", $curs, -1, OCI_B_CURSOR);
            oci_execute($stid);
            oci_execute($curs);

            while (($row = oci_fetch_array($curs, OCI_BOTH)) != false) {
              echo "['" . $row['MARKA'] . "'," . $row['POJ'] . "],";
            }
          }
          oci_close($polaczenie);
          ?>
        ]);

        var options = {
          title: 'Naprawa pojazdów ze względu na markę',
          is3D: true,
          fontSize: 20
        };

        var chart = new google.visualization.PieChart(document.getElementById('naprawy'));
        // Convert the Classic options to Material options.
        chart.draw(data, options);
      };
    </script>

<!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->
  <script type="text/javascript">
    google.charts.load("current", {
      packages: ["corechart"]
    });
    google.charts.setOnLoadCallback(drawKlienciKody);

    function drawKlienciKody() {
      var data = google.visualization.arrayToDataTable([
        ['Kod pocztowy', 'Częstotliwość'],
        <?php
        require_once "connect.php";
        $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

        // $polaczenie->set_charset("utf8");

        if (!$polaczenie) {
          die("Connection failed: " . oci_error());
        } else {
          $curs = oci_new_cursor($polaczenie);
          $stid = oci_parse($polaczenie, "BEGIN STATYSTYKI_CRUD.KLIENCI_KODY(:cursr); END;");
          oci_bind_by_name($stid, ":cursr", $curs, -1, OCI_B_CURSOR);
          oci_execute($stid);
          oci_execute($curs);

          while (($row = oci_fetch_array($curs, OCI_BOTH)) != false) {
            echo "['" . $row['KOD_POCZTOWY'] . "'," . $row['KOD'] . "],";
          }
        }
        oci_close($polaczenie);
        ?>
      ]);



      var options = {
        title: 'Kody pocztowe według ilości klientów',
        is3D: true,
        fontSize: 20,
        sliceVisibilityThreshold: .1
      };

      var chart = new google.visualization.PieChart(document.getElementById('klienci_kody'));
      chart.draw(data, options);
    }
  </script>



<script>
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(czesci_wykres);

      function czesci_wykres() {
        var data = new google.visualization.arrayToDataTable([
          ['Nazwa części', 'Percentage'],
          <?php
        require_once "connect.php";
        $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

        // $polaczenie->set_charset("utf8");

        if (!$polaczenie) {
          die("Connection failed: " . oci_error());
        } else {
          $curs = oci_new_cursor($polaczenie);
          $stid = oci_parse($polaczenie, "BEGIN STATYSTYKI_CRUD.CZESCI_WYKRES(:cursr); END;");
          oci_bind_by_name($stid, ":cursr", $curs, -1, OCI_B_CURSOR);
          oci_execute($stid);
          oci_execute($curs);

          while (($row = oci_fetch_array($curs, OCI_BOTH)) != false) {
            echo "['" . $row['NAZWA_CZESCI'] . "'," . $row['ILE'] . "],";
          }
        }
        oci_close($polaczenie);
        ?>
        ]);

        var options = {
          width: 970,
          colors: '#3864cc',
          fontSize: 20,
          bars: 'horizontal',
          legend: {
            position: 'none'
          },
    
          chart: {
            title: 'Najczęściej sprzedawane części',
            subtitle: ''
          },
          axes: {
            x: {
              0: {
                side: 'top',
                label: ''
              } // Top x-axis.
            }
          },
          bar: {
            groupWidth: "90%"
          }
        };


        var chart = new google.charts.Bar(document.getElementById('czesci_wykres'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
      };


</script>

    <script>
      $(".chartSelect").change(function() {
        if ($(this).val() == -1) {
          $("#div1").show();
          $("#div2").show();
          $("#div3").show();
        } else {
          $("#div" + $(this).val()).show().siblings().hide();
        }
      });
    </script>
    
  </div>
</div>
</div>