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
    <?php include 'nav.php';?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>    
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
                        <div class="col-xs-7">
                            <a href="#" class="btn btn-primary"><i class="material-icons">&#xE147;</i> <span>Dodaj Pracownika</span></a>
                            <a href="#" class="btn btn-primary"><i class="material-icons">&#xE24D;</i> <span>Exportuj do Excela</span></a>	
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
</body>
</html>


