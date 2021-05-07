<?php
session_start();
$page = "pracownik";
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
        <h2 class="display-4 text-white">Sekcja pracownicy</h2>
    </center>
    <div class="container">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-xs-5">
                            <h2>Zarządzenie pracownikami</h2>
                        </div>
                        <div class="col-xs-2 ml-auto">
                            <a href="#" class="btn btn-primary" <?php if ($_SESSION['stanowisko'] == "Pracownik") {
                                                                    echo 'onclick="return confirm_alert();"';
                                                                } else {
                                                                    echo 'data-toggle="modal"';
                                                                } ?> data-target="#myModal"><i class="material-icons">&#xE147;</i> <span>Dodaj Pracownika</span></a>
                            <!-- <a href="#" class="btn btn-primary"><i class="material-icons">&#xE24D;</i> <span>Exportuj do Excela</span></a> -->
                        </div>
                    </div>
                </div>
                <table id="table_to_highlight" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Imię</th>
                            <th>Nazwisko</th>
                            <th>Data zatrudnienia</th>
                            <th>Stanowisko</th>
                            <th>PESEL</th>
                            <th>Wynagrodzenie</th>
                            <th>Akcja</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once "connect.php";

                        $polaczenie = @new mysqli($host, $user, $password, $db);

                        $polaczenie->set_charset("utf8");

                        if ($polaczenie->connect_errno != 0) {
                            echo "Error: " . $polaczenie->connect_errno;
                        } else {
                            $sql = "SELECT * FROM pracownik";
                            $licznik = 1;
                            if ($result = @$polaczenie->query($sql)) {
                                $ilu = $result->num_rows;
                                $_SESSION['ile'] = $ilu;
                                if ($ilu > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $licznik . "</td>";
                                        echo "<td>" . $row['imie'] . "</td>";
                                        echo "<td>" . $row['nazwisko'] . "</td>";
                                        echo "<td>" . $row['data_zatrudnienia'] . "</td>";
                                        echo "<td>" . $row['stanowisko'] . "</td>";
                                        if ($_SESSION['stanowisko'] == "Pracownik") {
                                            echo "<td>Ukryto Dane</td>";
                                            echo "<td>Ukryto Dane</td>";
                                        } else {
                                            echo "<td>" . $row['pesel'] . "</td>";
                                            echo "<td>" . $row['wynagrodzenie'] . " zł</td>";
                                        }
                                        echo "<td>";
                                        echo "<a href='#' class='settings' id='" . $row['id_pracownika'] . "' title='Settings' data-target='#editModal' data-toggle='modal' onclick='getid(this.id);showTableData()'><i class='material-icons'>&#xE8B8;</i></a>";
                                        echo "<a href='#' class='delete' id='" . $row['id_pracownika'] . "' title='Delete' data-toggle='tooltip' onclick='getid(this.id, ".$licznik.");deletePrac()'><i class='material-icons'>&#xE5C9;</i></a>";
                                        echo "</td>";
                                        echo "</tr>";
                                        $licznik++;
                                    }
                                }
                            }
                        }
                        $polaczenie->close();
                        ?>
                    </tbody>
                </table>
                <div class="clearfix">
                    <div class="hint-text">Pokazano <b><?php echo $_SESSION['ile']; ?></b> / <b><?php echo $_SESSION['ile']; ?></b> wyników.</div>
                    <ul class="pagination">
                        <li class="page-item disabled"><a href="#">Poprzedni</a></li>
                        <li class="page-item"><a href="#" class="page-link">1</a></li>
                        <!-- <li class="page-item"><a href="#" class="page-link">2</a></li>
                        <li class="page-item active"><a href="#" class="page-link">3</a></li>
                        <li class="page-item"><a href="#" class="page-link">4</a></li>
                        <li class="page-item"><a href="#" class="page-link">5</a></li> -->
                        <li class="page-item"><a href="#" class="page-link">Następny</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Dodaj Pracownika</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="post" action="dodajprac.php" id="form">
                        <div class="form-group row">
                            <label for="imie" class="col-sm-4 col-form-label">Imie</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="imie" name="imie" placeholder="Imie" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nazwisko" class="col-sm-4 col-form-label">Nazwisko</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="nazwisko" name="nazwisko" placeholder="Nazwisko" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="date" class="col-sm-4 col-form-label">Data Zatrudnienia</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="date" name="date" placeholder="Data Zatrudnienia" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="stanowisko" class="col-sm-4 col-form-label">Stanowisko</label>
                            <div class="col-sm-8">
                                <select id="stanowisko" name="stanowisko" class="col-sm-12 form-control" required>
                                    <option value="">Wybierz stanowisko</option>
                                    <option value="Prezes">Prezes</option>
                                    <option value="Kierownik">Kierownik</option>
                                    <option value="Pracownik">Pracownik</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="wynagrodzenie" class="col-sm-4 col-form-label">Wynagrodzenie</label>
                            <div class="col-sm-8">
                                <input type="number" min="0" max="99999" class="form-control" id="wynagrodzenie" name="wynagrodzenie" placeholder="Wynagrodzenie" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pesel" class="col-sm-4 col-form-label">PESEL</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="pesel" name="pesel" placeholder="PESEL" onKeyDown="if(this.value.length==11 && event.keyCode!=8) return false;" required>
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
                    <h4 class="modal-title">Edytuj Pracownika</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="post" action="editprac.php" id="form1">
                        <div class="form-group row">
                            <label for="imie" class="col-sm-4 col-form-label">Imie</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="imiee" name="imiee" placeholder="Imie" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nazwisko" class="col-sm-4 col-form-label">Nazwisko</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="nazwiskoe" name="nazwiskoe" placeholder="Nazwisko" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="date" class="col-sm-4 col-form-label">Data Zatrudnienia</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="datee" name="datee" placeholder="Data Zatrudnienia" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="stanowisko" class="col-sm-4 col-form-label">Stanowisko</label>
                            <div class="col-sm-8">
                                <select id="stanowiskoe" name="stanowiskoe" class="col-sm-12 form-control" required>
                                    <option value="">Wybierz stanowisko</option>
                                    <option value="Prezes">Prezes</option>
                                    <option value="Kierownik">Kierownik</option>
                                    <option value="Pracownik">Pracownik</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="wynagrodzenie" class="col-sm-4 col-form-label">Wynagrodzenie</label>

                            <div class="col-sm-8">
                                <input type="number" min="0" max="99999" class="form-control" id="wynagrodzeniee" name="wynagrodzeniee" placeholder="Wynagrodzenie" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pesel" class="col-sm-4 col-form-label">PESEL</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="pesele" name="pesele" placeholder="PESEL" onKeyDown="if(this.value.length==11 && event.keyCode!=8) return false;" required>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="sub form-control col-sm-4" value="Edytuj Pracownika">
                    <input type="hidden" name="id_p" id="id_p" value="">
                </div>
                </form>
            </div>
        </div>
    </div>

    <p id="test"></p>

    <form name="delprac" id="delprac" method="post" action="usunprac.php">
        <input type="hidden" name="id_del" id="id_del" value="">
    </form>

    <script>
        function confirm_alert() {
            return Swal.fire({
                icon: 'error',
                title: 'Błąd',
                text: 'Nie masz uprawnień aby dodać pracownika!',
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
                    text: 'Pracownik już istnieje!',
                });
            } else if (simple == "dodany") {
                Swal.fire({
                    icon: 'success',
                    title: 'Udało się!',
                    text: 'Pracownik został dodany!',
                });
            } else if (simple == "edycja") {
                Swal.fire({
                    icon: 'success',
                    title: 'Udało się!',
                    text: 'Pracownik został edytowany!',
                });
            } else if (simple == "usuniete") {
                Swal.fire({
                    icon: 'success',
                    title: 'Udało się!',
                    text: 'Pracownik został usunięty!',
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

        function getid(c_id, licz) {
            b_id = c_id;
            document.getElementById('id_p').value = b_id;
            document.getElementById('id_del').value = b_id;
            return b_id;
        }

        function showTableData() {
            var myTab = document.getElementById('table_to_highlight');
            var array = [];

            for (i = b_id - 2; i < b_id - 1; i++) {
                array[i] = [];
                var objCells = myTab.rows.item(i).cells;

                for (var j = 1; j < objCells.length - 1; j++) {
                    array[i][j] = objCells.item(j).innerHTML;
                }
            }

            var wynag = array[b_id - 2][6].substring(0, array[b_id - 2][6].length - 3);
            document.getElementById("imiee").value = array[b_id - 2][1];
            document.getElementById("nazwiskoe").value = array[b_id - 2][2];
            document.getElementById("datee").value = array[b_id - 2][3];
            document.getElementById("stanowiskoe").value = array[b_id - 2][4];
            document.getElementById("pesele").value = parseFloat(array[b_id - 2][5]);
            document.getElementById("wynagrodzeniee").value = parseFloat(wynag);
        }
    </script>
    <script>
        $('form1').on('submit', function(e) {
            if (pesel.value.length < 11) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Błąd',
                    text: 'Podany PESEL jest nieprawidłowy!',
                });
            }
        });
    </script>
    <script type="text/javascript">
        document.getElementById('table_to_highlight')
            .addEventListener('click', function(item) {
                var row = item.path[1];

                var row_value = "";

                for (var j = 0; j < row.cells.length; j++) {
                    row_value += row.cells[j].innerHTML;
                    if (row_value.includes('zł')) {
                        break;
                    }
                    row_value += " | ";
                }

                alert(row_value);

                if (row.classList.contains('highlight'))
                    row.classList.remove('highlight');
                else
                    row.classList.add('highlight');
            });
    </script>

    <?php
    unset($_SESSION['komunikat']);
    unset($blad);
    ?>
</body>

</html>