<?php
  session_start();
  $page = "pracownik";
  if(!isset($_SESSION['zalogowany'])){
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
    <?php include 'nav.php';?> 
    <script>$(function() { 
        $('#sidebarCollapse').on('click', function() {
            $('#sidebar, #content').toggleClass('active');
        });
        });

    </script>

    <script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
    </script>


</head>
<body>
    <center><h2 class="display-4 text-white">Sekcja pracownicy</h2></center>
    <div class="container">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-xs-5">
                            <h2>Zarządzenie pracownikami</h2>
                        </div>
                        <div class="col-xs-2 ml-auto">
                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="material-icons">&#xE147;</i> <span>Dodaj Pracownika</span></a>
                            <!-- <a href="#" class="btn btn-primary"><i class="material-icons">&#xE24D;</i> <span>Exportuj do Excela</span></a> -->
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Imię i nazwisko</th>						
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

                        if($polaczenie->connect_errno!=0){
                            echo "Error: ".$polaczenie->connect_errno;
                        }else{
                            $sql = "SELECT * FROM pracownik";
                            $licznik = 1;
                            if($result = @$polaczenie->query($sql)){
                                $ilu = $result->num_rows;
                                $_SESSION['ile'] = $ilu;
                                if($ilu>0){
                                    while($row = $result->fetch_assoc()){

                                        echo "<tr>";
                                            echo "<td>".$licznik."</td>";
                                            echo "<td><a href='#'>".$row['imie']." ".$row['nazwisko']."</a></td>";
                                            echo "<td>".$row['data_zatrudnienia']."</td>";                  
                                            echo "<td>".$row['stanowisko']."</td>";
                                            echo "<td>".$row['pesel']."</td>";
                                            echo "<td>".$row['wynagrodzenie']." zł</td>";
                                            echo "<td>";
                                                echo "<a href='#' class='settings' title='Settings' data-toggle='tooltip'><i class='material-icons'>&#xE8B8;</i></a>";
                                                echo "<a href='#' class='delete' title='Delete' data-toggle='tooltip'><i class='material-icons'>&#xE5C9;</i></a>";
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
                    <div class="hint-text">Pokazano <b>3</b> / <b><?php echo $_SESSION['ile']; ?></b> wyników.</div>
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


<p id="demo"><?php if(isset($_SESSION['komunikat'])){echo $_SESSION['komunikat'];}?></p>

<!-- <script>
function myFunction() {
  var x = document.getElementById("jd").value;
  document.getElementById("demo").innerHTML = x;
}
</script> -->
<script>
$('form').on('submit', function(e) {
  if(pesel.value.length < 11) {
    e.preventDefault();
    alert("Podany PESEL jest nieprawidłowy");
  } 
});
</script>

<?php
    unset($_SESSION['komunikat']);
?>
</body>
</html>


