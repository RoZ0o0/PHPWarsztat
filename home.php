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
        <option value="9">Informacje ogólne</option>
        <option value="1">Wynagrodzenie</option>
        <option value="2">Marki</option>
        <option value="3">Naprawy</option>
        <option value="4">Kody pocztowe</option>
        <option value="5">Części</option>
        <option value="6">TOP 5 Pracowników</option>
        <option value="7">TOP 5 Warsztatów</option>
        <option value="8">Najczęsciej płacący klienci</option>
      </select>


    </div>
    <div id="container" class="container" style="position: relative; left: 20%;">
      <div class="outside_chart" id="div9" style="width: 1110px;height:570px;background-color:#ffffff; margin-left:auto; margin-right:auto;border-radius:20px; margin-top:10px; padding:20px;">
        <div style="color:black;" class="col-sm-12">

          <br>
          <center>
            <h1>Informacje Ogólne</h1>
          </center>
          <br>
          <div class="row">
            <div class="col-sm-4">

              <p class="pstat" style="text-align:center;"><b>Łączna ilość klientów</b></p>
              <center>
                <?php

                require_once "connect.php";

                $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

                // $polaczenie->set_charset("utf8");

                if (!$polaczenie) {
                  die("Connection failed: " . oci_error());
                } else {
                  $stid = oci_parse($polaczenie, "BEGIN :a:=TOTALCUSTOMERS(); END;");
                  oci_bind_by_name($stid, ':a', $total, 32);
                  oci_execute($stid);
                  echo $total;
                }
                oci_close($polaczenie);
                ?>
                <br>
                <br><br><br><br><br>
                <p>Jd</p>
              </center>
            </div>
            <div class="col-sm-4">
              <p class="pstat" style="text-align:center;"><b>Dochód ze sprzedanych części</b></p>
              <center>
                <?php

                require_once "connect.php";

                $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

                // $polaczenie->set_charset("utf8");

                if (!$polaczenie) {
                  die("Connection failed: " . oci_error());
                } else {
                  $stid = oci_parse($polaczenie, "BEGIN :a:=CZESCIDOCHOD(); END;");
                  oci_bind_by_name($stid, ':a', $total, 32);
                  oci_execute($stid);
                  echo $total . "zł";
                }
                oci_close($polaczenie);
                ?>
                <br>
                <br><br><br><br><br>
                <p>Jd</p>
              </center>
            </div>
            <div class="col-sm-4">
              <p class="pstat" style="text-align:center;"><b>Kończące się części</b></p>
              <center>
                <?php

                require_once "connect.php";

                $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

                // $polaczenie->set_charset("utf8");

                if (!$polaczenie) {
                  die("Connection failed: " . oci_error());
                } else {
                  $curs = oci_new_cursor($polaczenie);
                  $stid = oci_parse($polaczenie, "BEGIN :cursr:=KONCZACE_SIE_CZESCI; END;");
                  oci_bind_by_name($stid, ':cursr', $curs, -1, OCI_B_CURSOR);
                  oci_execute($stid);
                  oci_execute($curs);

                  while (($row = oci_fetch_array($curs, OCI_BOTH)) != false) {
                    echo $row['NAZWA_CZESCI'] . " | Pozostało: " . $row['LICZBA_DOSTEPNYCH_SZTUK'] . "szt.<br>";
                  }
                }
                oci_close($polaczenie);
                ?>
              </center>
            </div>
          </div>
        </div>
      </div>
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
        <div id="klienci_kody" style="width: 970px; height: 570px;margin-left:auto;margin-right:auto;margin-top:10px;"></div>
      </div>

      <div class="outside-chart" id="div5" style="width: 1110px;height:570px;background-color:#ffffff; margin-left:auto; margin-right:auto;border-radius:20px;">
        <div id="czesci_wykres" style="width: 970px; height: 550px;padding-top: 25px;padding-left: 60px; margin-top:10px;"></div>
      </div>
      <div class="outside_chart" id="div6" style="width: 1110px;height:570px;background-color:#ffffff; margin-left:auto; margin-right:auto;border-radius:20px;">
        <div id="pracownicy_top" style="width: 970px; height: 550px;padding-top: 25px;padding-left: 60px; margin-top:10px;"></div>
      </div>
      <div class="outside_chart" id="div7" style="width: 1110px;height:570px;background-color:#ffffff; margin-left:auto; margin-right:auto;border-radius:20px;">
        <div id="warsztaty_top" style="width: 970px; height: 550px;padding-top: 25px;padding-left: 60px; margin-top:10px;"></div>
      </div>
      <div class="outside_chart" id="div8" style="width: 1110px;height:570px;background-color:#ffffff; margin-left:auto; margin-right:auto;border-radius:20px;">
        <div id="klient_najczesciej" style="width: 970px; height: 550px;padding-top: 25px;padding-left: 60px; margin-top:10px;"></div>
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
            $stid = oci_parse($polaczenie, "BEGIN STATYSTYKI.PRACOWNICY_WYNAGRODZENIE(:cursr); END;");
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
          colors: '#94d651',
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
            $stid = oci_parse($polaczenie, "BEGIN STATYSTYKI.POJAZDY_MARKA(:cursr); END;");
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
          colors: '#82AE8B',
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
            $stid = oci_parse($polaczenie, "BEGIN STATYSTYKI.USLUGI_MARKA(:cursr); END;");
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
            $stid = oci_parse($polaczenie, "BEGIN STATYSTYKI.KLIENCI_KODY(:cursr); END;");
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
          sliceVisibilityThreshold: .1,
          slices: {
            0: {
              color: '#2B987E'
            },
            1: {
              color: '#BDBA04'
            },
            2: {
              color: '#A1C6CA'
            },
          }
        };

        var chart = new google.visualization.PieChart(document.getElementById('klienci_kody'));
        chart.draw(data, options);
      }
    </script>



    <script>
      google.charts.load('current', {
        'packages': ['bar']
      });
      google.charts.setOnLoadCallback(czesci_wykres);

      function czesci_wykres() {
        var data = new google.visualization.arrayToDataTable([
          ['Nazwa części', 'Ilość'],
          <?php
          require_once "connect.php";
          $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

          // $polaczenie->set_charset("utf8");

          if (!$polaczenie) {
            die("Connection failed: " . oci_error());
          } else {
            $curs = oci_new_cursor($polaczenie);
            $stid = oci_parse($polaczenie, "BEGIN STATYSTYKI.CZESCI_WYKRES(:cursr); END;");
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
          colors: '#107a4c',
          fontSize: 20,
          bars: 'horizontal',
          legend: {
            position: 'none'
          },

          chart: {
            title: 'TOP 10 Najczęściej sprzedawanych części',
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
      google.charts.load('current', {
        'packages': ['bar']
      });
      google.charts.setOnLoadCallback(pracownicy_top);

      function pracownicy_top() {
        var data = new google.visualization.arrayToDataTable([
          ['Pracownik', 'Usługi'],
          <?php
          require_once "connect.php";

          $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

          // $polaczenie->set_charset("utf8");

          if (!$polaczenie) {
            die("Connection failed: " . oci_error());
          } else {
            $curs = oci_new_cursor($polaczenie);
            $stid = oci_parse($polaczenie, "BEGIN STATYSTYKI.PRACOWNICY_TOP(:cursr); END;");
            oci_bind_by_name($stid, ":cursr", $curs, -1, OCI_B_CURSOR);
            oci_execute($stid);
            oci_execute($curs);

            while (($row = oci_fetch_array($curs, OCI_BOTH)) != false) {
              echo "['" . $row['PRACOWNIK'] . "'," . $row['ILE'] . "],";
            }
          }
          oci_close($polaczenie);
          ?>
        ]);

        var options = {
          width: 970,
          colors: '#066997',
          fontSize: 20,
          bars: 'horizontal',
          legend: {
            position: 'none'
          },

          chart: {
            title: 'TOP 5 Pracowników',
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


        var chart = new google.charts.Bar(document.getElementById('pracownicy_top'));
        // Convert the Classic options to Material options.
        chart.draw(data, google.charts.Bar.convertOptions(options));
      };
    </script>

    <script>
      google.charts.load('current', {
        'packages': ['bar']
      });
      google.charts.setOnLoadCallback(warsztaty_top);

      function warsztaty_top() {
        var data = new google.visualization.arrayToDataTable([
          ['Warsztat', 'Usługi'],
          <?php
          require_once "connect.php";

          $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

          // $polaczenie->set_charset("utf8");

          if (!$polaczenie) {
            die("Connection failed: " . oci_error());
          } else {
            $curs = oci_new_cursor($polaczenie);
            $stid = oci_parse($polaczenie, "BEGIN STATYSTYKI.WARSZTATY_TOP(:cursr); END;");
            oci_bind_by_name($stid, ":cursr", $curs, -1, OCI_B_CURSOR);
            oci_execute($stid);
            oci_execute($curs);

            while (($row = oci_fetch_array($curs, OCI_BOTH)) != false) {
              echo "['" . $row['WARSZTAT'] . "'," . $row['ILE'] . "],";
            }
          }
          oci_close($polaczenie);
          ?>
        ]);

        var options = {
          width: 970,
          colors: '#066997',
          fontSize: 20,
          bars: 'horizontal',
          legend: {
            position: 'none'
          },

          chart: {
            title: 'TOP 5 Warsztatów',
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


        var chart = new google.charts.Bar(document.getElementById('warsztaty_top'));
        // Convert the Classic options to Material options.
        chart.draw(data, google.charts.Bar.convertOptions(options));
      };
    </script>

    <script>
      google.charts.load('current', {
        'packages': ['bar']
      });
      google.charts.setOnLoadCallback(warsztaty_top);

      function warsztaty_top() {
        var data = new google.visualization.arrayToDataTable([
          ['Klient', 'Płatności'],
          <?php
          require_once "connect.php";

          $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

          // $polaczenie->set_charset("utf8");

          if (!$polaczenie) {
            die("Connection failed: " . oci_error());
          } else {
            $curs = oci_new_cursor($polaczenie);
            $stid = oci_parse($polaczenie, "BEGIN STATYSTYKI.KLIENT_NAJCZESCIEJ(:cursr); END;");
            oci_bind_by_name($stid, ":cursr", $curs, -1, OCI_B_CURSOR);
            oci_execute($stid);
            oci_execute($curs);

            while (($row = oci_fetch_array($curs, OCI_BOTH)) != false) {
              echo "['" . $row['KLIENT'] . "'," . $row['ILE'] . "],";
            }
          }
          oci_close($polaczenie);
          ?>
        ]);

        var options = {
          width: 970,
          colors: '#066997',
          fontSize: 20,
          bars: 'horizontal',
          legend: {
            position: 'none'
          },

          chart: {
            title: 'Najczęściej płacący klienci',
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


        var chart = new google.charts.Bar(document.getElementById('klient_najczesciej'));
        // Convert the Classic options to Material options.
        chart.draw(data, google.charts.Bar.convertOptions(options));
      };
    </script>

    <script>
      $(".chartSelect").change(function() {
        if ($(this).val() == -1) {
          $("#div1").show();
          $("#div2").show();
          $("#div3").show();
          $("#div4").show();
          $("#div5").show();
          $("#div6").show();
          $("#div7").show();
          $("#div8").show();
          $("#div9").show();
        } else {
          $("#div" + $(this).val()).show().siblings().hide();
        }
      });
    </script>

  </div>
</div>
</div>