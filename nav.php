
<html><!-- Vertical navbar -->
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
      <a href="#" class="nav-link text-dark bg-light">
                <i class="fa fa-th-large mr-3 text-primary fa-fw"></i>
                home
            </a>
    </li>
    <li class="nav-item">
      <a href="#" class="nav-link text-dark">
                <i class="fa fa-users mr-3 text-primary fa-fw"></i>
                Pracownicy
            </a>
    </li>
    <li class="nav-item">
      <a href="#" class="nav-link text-dark">
                <i class="fa fa-cubes mr-3 text-primary fa-fw"></i>
                Usługi
            </a>
    </li>
    <li class="nav-item">
      <a href="#" class="nav-link text-dark">
                <i class="fa fa-picture-o mr-3 text-primary fa-fw"></i>
                Galeria
            </a>
    </li>
    <li class="nav-item">
      <a href="#" class="nav-link text-dark">
      <i class="fa fa-wrench mr-3 text-primary fa-fw"></i>
                Warsztaty
            </a>
    </li>
  </ul>

  <p class="text-gray font-weight-bold text-uppercase px-3 small py-4 mb-0">Charts</p>

  <ul class="nav flex-column bg-white mb-0">
    <li class="nav-item">
      <a href="#" class="nav-link text-dark">
                <i class="fa fa-area-chart mr-3 text-primary fa-fw"></i>
                area charts
            </a>
    </li>
    <li class="nav-item">
      <a href="#" class="nav-link text-dark">
                <i class="fa fa-bar-chart mr-3 text-primary fa-fw"></i>
                bar charts
            </a>
    </li>
    <li class="nav-item">
      <a href="#" class="nav-link text-dark">
                <i class="fa fa-pie-chart mr-3 text-primary fa-fw"></i>
                pie charts
            </a>
    </li>
    <li class="nav-item">
      <a href="#" class="nav-link text-dark">
                <i class="fa fa-line-chart mr-3 text-primary fa-fw"></i>
                line charts
            </a>
    </li>
  </ul>
</div>


<div class="page-content p-5" id="content">
  <!-- Toggle button -->
  <button id="sidebarCollapse" type="button" class="btn btn-light bg-white rounded-pill shadow-sm px-4 mb-4"><i class="fa fa-bars mr-2"></i><small class="text-uppercase font-weight-bold">Toggle</small></button>
</html>