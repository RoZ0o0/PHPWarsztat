<?php
session_start();
$page = "warsztaty";
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


</head>

<body onload="blad()">
    <center>
        <h2 class="display-4 text-white">Sekcja warsztaty</h2>
    </center>
    <div class="container">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-xs-5">
                            <h2>Zarządzenie warsztatami</h2>
                        </div>
                        <div class="col-xs-2 ml-auto">
                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="material-icons">&#xE147;</i> <span>Dodaj Warsztat</span></a>
                            <!-- <a href="#" class="btn btn-primary"><i class="material-icons">&#xE24D;</i> <span>Exportuj do Excela</span></a> -->
                        </div>
                    </div>
                </div>
                <table id="table_to_highlight" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Adres</th>
                            <th>Miasto</th>
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
                            $stid = oci_parse($polaczenie, "SELECT * FROM warsztaty");
                            $licznik = 1;
                            if (oci_execute($stid) == TRUE) {
                                // $ilu = $result->num_rows;
                                // $_SESSION['ile'] = $ilu;
                                // if ($ilu > 0) {
                                while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                                    echo "<tr>";
                                    echo "<td>" . $licznik . "</td>";
                                    echo "<td class='adres_row'>" . $row['ADRES'] . "</td>";
                                    echo "<td class='miasto_row'>" . $row['MIASTO'] . "</td>";
                                    echo "<td class='tede'>";
                                    echo "<a href='#' class='material-icons-outlined' id='" . $row['ID_WARSZTATU'] . "' title='Map' data-target='#showMap' onclick='reloadMaps();'><i class='material-icons ikonka_map'>&#xe0c8;</i></a>";
                                    echo "<a href='#' class='settings' id='" . $row['ID_WARSZTATU'] . "' title='Settings' data-target='#editModal'  data-toggle='modal' onclick='getid(this.id);getlicznik(" . $licznik . ");showTableData()'><i class='material-icons'>&#xE8B8;</i></a>";
                                    echo "<a href='#' class='delete' id='" . $row['ID_WARSZTATU'] . "' title='Delete' data-toggle='tooltip' onclick='getid(this.id);deletePrac()'><i class='material-icons'>&#xE5C9;</i></a>";
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
                    <h4 class="modal-title">Dodaj Warsztat</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="post" action="dodajwarsztat.php" id="form">
                        <div class="form-group row">
                            <label for="imie" class="col-sm-4 col-form-label">Adres</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="adres" name="adres" placeholder="Adres" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nazwisko" class="col-sm-4 col-form-label">Miasto</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="miasto" name="miasto" placeholder="Miasto" required>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="sub form-control col-sm-4" value="Dodaj Warsztat">
                </div>
                </form>
            </div>
        </div>
    </div>

    <div id="editModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edytuj Warsztat</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="post" action="editwarsztat.php" id="form1">
                        <div class="form-group row">
                            <label for="imie" class="col-sm-4 col-form-label">Adres</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="adrese" name="adrese" placeholder="Adres" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nazwisko" class="col-sm-4 col-form-label">Miasto</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="miastoe" name="miastoe" placeholder="Miasto" required>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="sub form-control col-sm-4" value="Edytuj Warsztat">
                    <input type="hidden" name="id_w" id="id_w" value="">
                </div>
                </form>
            </div>
        </div>
    </div>

    <p id="test"></p>

    <form name="delprac" id="delprac" method="post" action="usunwarsztat.php">
        <input type="hidden" name="id_del" id="id_del" value="">
    </form>
<div id="tutaj_Mapy">
</div>
    <script>

    $('tbody .ikonka_map').click(function(e) {
        e.preventDefault();
        var adreso = $(this).closest('tr').find('.adres_row').text();
        var miastoo = $(this).closest('tr').find('.miasto_row').text();
        adreso = adreso + ' ';
        miastoo = miastoo + ' ';
        document.getElementById("tutaj_Mapy").innerHTML = "<div id='map-container-google-3' class='z-depth-1-half map-container-3'><iframe src='https://maps.google.com/maps?q="+miastoo+adreso+"E&t=&z=18&ie=UTF8&iwloc=&output=embed' frameborder='0' style='border:0' allowfullscreen></iframe></div>";

    });

// function reloadMaps(){
// var adreso = $('#adrese').val() + ' ';
// var miastoo = $('#miastoe').val()+ ' ';
// document.getElementById("tutaj_Mapy").innerHTML = "<div id='map-container-google-3' class='z-depth-1-half map-container-3'><iframe src='https://maps.google.com/maps?q="+miastoo+adreso+"E&t=&z=18&ie=UTF8&iwloc=&output=embed' frameborder='0' style='border:0' allowfullscreen></iframe></div>";
// console.log(miastoo+adreso);

</script>



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
                    if(totalRows <= 5){
                      $('.pagination').hide();
                    } else {
                        $('.pagination').show();
                    }

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
        function blad() {

            var simple = '<?php echo $blad; ?>';

            if (simple == "istnieje") {
                Swal.fire({
                    icon: 'error',
                    title: 'Błąd',
                    text: 'Warsztat już istnieje!',
                });
            } else if (simple == "dodany") {
                Swal.fire({
                    icon: 'success',
                    title: 'Udało się!',
                    text: 'Warsztat został dodany!',
                });
            } else if (simple == "edycja") {
                Swal.fire({
                    icon: 'success',
                    title: 'Udało się!',
                    text: 'Warsztat został edytowany!',
                });
            } else if (simple == "usuniete") {
                Swal.fire({
                    icon: 'success',
                    title: 'Udało się!',
                    text: 'Warsztat został usunięty!',
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
        var b_id;
        var licz;

        function getid(c_id) {
            b_id = c_id;
            document.getElementById('id_w').value = b_id;
            document.getElementById('id_del').value = b_id;
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

            document.getElementById("adrese").value = array[licz][1];
            document.getElementById("miastoe").value = array[licz][2];
        }
    </script>
    <?php
    unset($_SESSION['komunikat']);
    unset($blad);
    ?>

    <style>
   .map-container-3{
overflow:hidden;
padding-bottom:56.25%;
position: relative;
margin-top: 5%;
left:14.87%;
height:0;
}
.map-container-3 iframe{
left:0;
top:0;
height:70%;
width:70%;
position:absolute;
}
.tede{
width: 11.8875%;
}
    </style>
</body>


</html>