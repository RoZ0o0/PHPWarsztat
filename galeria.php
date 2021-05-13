<?php
session_start();
$page = "galeria";
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
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" /> -->
  <link rel="stylesheet" href="style_dashboard.css">
</head>

<body>

  <?php include 'nav.php'; ?>
  <h2 class="display-4 text-white" style="text-align: center">Sekcja Galerii</h2>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="main.js"></script>
  <script>
    $(function() {
      $('#sidebarCollapse').on('click', function() {
        $('#sidebar, #content').toggleClass('active');
      });
    });
  </script>
  <div id="entirebody">
    <div id="myBtnContainer">
      <form method="post" action="galeria.php">
        <input type="text" id="textFilter" name="textFilter" placeholder="Wyszukaj" />
        <input type="submit" class="btn btn-primary btn-lg" value="Filtruj" />
      </form>
    </div>
    <div class="container">
      <div class="row">

        <?php
        require_once "connect.php";

        $polaczenie = oci_connect($user, $password, $db, 'AL32UTF8');

        // $polaczenie->set_charset("utf8");

        if (!$polaczenie) {
          die("Connection failed: " . oci_error());
        } else {
          if(isset($_POST['textFilter'])){
            $text = $_POST['textFilter'];
            $text = strtoupper($text);
            $sql_query = "SELECT * FROM galeria WHERE UPPER(komentarz) like '%$text%'";
          }else{
            $sql_query = "SELECT * FROM galeria";
          }
          $stid = oci_parse($polaczenie, $sql_query);

          if (oci_execute($stid) == TRUE) {

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
              echo "<div class='col-lg-4 col-12 column'>";
              echo "<div class='content'>";
              echo "<div class='photo_container'>";
              echo "<img src='./gallery/" . $row['ZDJECIE'] . "' alt='zdj' style='width:100%'>";
              echo "</div>";
              echo "<h4>Zdjęcie 1</h4>";
              echo "<p>" . $row['KOMENTARZ'] . "</p>";
              echo "</div>";
              echo "</div>";
            }
          }
        }
        oci_close($polaczenie);
        ?>
      </div>
    </div>
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
    display: none;
    /* Hide columns by default */
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
    padding: 12px 10px;
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

  #myBtnContainer {
    transform: translateX(20%);
  }
</style>
<script>
  filterSelection("all") // Execute the function and show all columns
  function filterSelection(c) {
    var x, i;
    x = document.getElementsByClassName("column");
    if (c == "all") c = "";
    // Add the "show" class (display:block) to the filtered elements, and remove the "show" class from the elements that are not selected
    for (i = 0; i < x.length; i++) {
      w3RemoveClass(x[i], "show");
      if (x[i].className.indexOf(c) > -1) w3AddClass(x[i], "show");
    }
  }

  // Show filtered elements
  function w3AddClass(element, name) {
    var i, arr1, arr2;
    arr1 = element.className.split(" ");
    arr2 = name.split(" ");
    for (i = 0; i < arr2.length; i++) {
      if (arr1.indexOf(arr2[i]) == -1) {
        element.className += " " + arr2[i];
      }
    }
  }

  // Hide elements that are not selected
  function w3RemoveClass(element, name) {
    var i, arr1, arr2;
    arr1 = element.className.split(" ");
    arr2 = name.split(" ");
    for (i = 0; i < arr2.length; i++) {
      while (arr1.indexOf(arr2[i]) > -1) {
        arr1.splice(arr1.indexOf(arr2[i]), 1);
      }
    }
    element.className = arr1.join(" ");
  }

  // Add active class to the current button (highlight it)
  var btnContainer = document.getElementById("myBtnContainer");
  var btns = btnContainer.getElementsByClassName("btn");
  for (var i = 0; i < btns.length; i++) {
    btns[i].addEventListener("click", function() {
      var current = document.getElementsByClassName("active");
      current[0].className = current[0].className.replace(" active", "");
      this.className += " active";
    });
  }

  function getFilterText() {
    var textfilter = document.getElementById("inputFilter").value;
    return textfilter;
  }
</script>

</html>