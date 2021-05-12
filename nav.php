<html>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"><!-- Vertical navbar -->
<div class="vertical-nav bg-white" id="sidebar">
  <div class="py-4 px-3 mb-4 bg-light">
    <div class="media d-flex align-items-center">
      <div class="media-body">
        <h4 class="m-0"><?php echo "<p>Witaj ".$_SESSION['imie']."!</p>"; ?></h4>
        <p class="font-weight-normal text-muted mb-0"><?php echo $_SESSION['stanowisko']; ?></p>
        <a href="logout.php"><button type="button" class="btn btn-outline-secondary">Wyloguj</button></a>
      </div>
    </div>
  </div>

  <p class="text-gray font-weight-bold text-uppercase px-3 small pb-4 mb-0">Dashboard</p>

  <ul class="nav flex-column bg-white mb-0">
    <li class="nav-item">
      <a href="dashboard.php" class="<?php if ( $page == "home" ) { echo "nav-link text-dark bg-light"; }else{ echo "nav-link text-dark";} ?>">
                <i class="fa fa-th-large mr-3 text-primary fa-fw"></i>
                Strona Główna
            </a>
    </li>
    <li class="nav-item">
      <a href="pracownicy.php" class="<?php if ( $page == "pracownik" ) { echo "nav-link text-dark bg-light"; }else{ echo "nav-link text-dark";} ?>">
                <i class="fa fa-users mr-3 text-primary fa-fw"></i>
                Pracownicy
            </a>
    </li>
    <li class="nav-item">
      <a href="uslugi.php" class="<?php if ( $page == "uslugi" ) { echo "nav-link text-dark bg-light"; }else{ echo "nav-link text-dark";} ?>">
                <i class="fa fa-cubes mr-3 text-primary fa-fw"></i>
                Usługi
            </a>
    </li>
    <li class="nav-item">
      <a href="faktury.php" class="<?php if ( $page == "faktury" ) { echo "nav-link text-dark bg-light"; }else{ echo "nav-link text-dark";} ?>">
                <i class="fa fa-file-text-o mr-3 text-primary fa-fw"></i>
                Faktury
            </a>
            <li class="nav-item">
      <a href="klienci.php" class="<?php if ( $page == "klienci" ) { echo "nav-link text-dark bg-light"; }else{ echo "nav-link text-dark";} ?>">
                <i class="fa fa-user mr-3 text-primary fa-fw"></i>
                Klienci
            </a>
            <li class="nav-item">
      <a href="pojazdy.php" class="<?php if ( $page == "pojazdy" ) { echo "nav-link text-dark bg-light"; }else{ echo "nav-link text-dark";} ?>">
                <i class="fa fa-car mr-3 text-primary fa-fw"></i>
                Pojazdy
            </a>
    <li class="nav-item">
      <a href="faktury.php" class="<?php if ( $page == "faktury" ) { echo "nav-link text-dark bg-light"; }else{ echo "nav-link text-dark";} ?>">
        <i class="fa fa-shopping-cart mr-3 text-primary fa-fw"></i>
        Zamówienia
    </a>
            
    <li class="nav-item">
      <a href="galeria.php" class="<?php if ( $page == "galeria" ) { echo "nav-link text-dark bg-light"; }else{ echo "nav-link text-dark";} ?>">
                <i class="fa fa-picture-o mr-3 text-primary fa-fw"></i>
                Galeria
            </a>
    </li>
    <li class="nav-item">
      <a href="warsztaty.php" class="<?php if ( $page == "warsztaty" ) { echo "nav-link text-dark bg-light"; }else{ echo "nav-link text-dark";} ?>">
      <i class="fa fa-wrench mr-3 text-primary fa-fw"></i>
                Warsztaty
            </a>
    </li>
  </ul>

</div>


<div class="page-content p-5" id="content">
  <!-- Toggle button -->
  <button id="sidebarCollapse" type="button" class="btn btn-light bg-white rounded-pill shadow-sm px-4 mb-4"><i class="fa fa-bars mr-2"></i><small class="text-uppercase font-weight-bold">MENU</small></button>
</html>