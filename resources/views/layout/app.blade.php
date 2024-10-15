<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>EggGrade Pro | Home</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../../dist/css/adminlte.css">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color: #343a40; color: #ffffff;">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button" style="color: #ffffff;"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <b><a href="/admin" class="nav-link" style="color: #ffffff;">Home</a></b>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/eggGrading" class="nav-link" style="color: #ffffff;">Grade Egg</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/taskSchedulingManagement" class="nav-link" style="color: #ffffff;">Task Scheduling</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/reportManagement" class="nav-link" style="color: #ffffff;">Report</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button" style="color: #ffffff;">
                <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block" style="background-color: #343a40; border: 1px solid #ffc107;">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search" style="background-color: #6c757d; color: #ffffff;">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit" style="background-color: #ffc107; color: #343a40;">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search" style="background-color: #ffc107; color: #343a40;">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" style="color: #ffffff;">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="background-color: #343a40; color: #ffffff;">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item" style="color: #ffffff;">
                    <i class="fas fa-envelope mr-2"></i> 4 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item" style="color: #ffffff;">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item" style="color: #ffffff;">
                    <i class="fas fa-file mr-2"></i> 3 new reports
                    <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer" style="color: #ffffff;">See All Notifications</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button" style="color: #ffffff;">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        
    </ul>
</nav>

  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/admin" class="brand-link">
      
      <img src="../../../dist/img/Chicken And Egg.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">EggGrade Pro</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      
      {{-- <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> --}}

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
                <a href="/profile" class="nav-link">
                  <i class="nav-icon fas fa-id-badge"></i>
                  <p>
                    Profile
                    
                    {{-- <i class="right fas fa-angle-left"></i> --}}
                  </p>
                </a>
                
              </li>
          <li class="nav-item">
            {{-- <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                {{-- <i class="right fas fa-angle-left"></i> 
              </p>
            </a> --}}
            
          </li>
          <li class="nav-item">
            <a href="/eggGrading" class="nav-link">
              <i class="fas fa-egg nav-icon"></i>
              <p>
                Grade Egg
                <i class="far fa-plus-square" style="margin-left: 8px;"></i>
              </p>
            </a>
          </li>          
          <li class="nav-item">
            <a href="/chickenManagement" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Chicken Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/cageManagement" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cage Management</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/chickenManagement" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Chicken Management</p>
                </a>
              </li>
        
              
            </ul>
          </li>
          
          <li class="nav-item">
            <a href="/vaccinationplanManagement" class="nav-link">
              <i class="fas fa-syringe nav-icon"></i>
              <p>
                Vaccination Management
                
              </p>
            </a>

            
          </li>

          <li class="nav-item">
            <a href="/taskSchedulingManagement" class="nav-link">
              <i class="fas fa-tasks nav-icon"></i>
              <p>
                Task Scheduling
                
              </p>
            </a>

            
          </li>

          <li class="nav-item">
            <a href="/collectionPlanManagement" class="nav-link">
              <i class="fas fa-hand-holding nav-icon"></i>
              <p>
                Collection Plan
                
              </p>
            </a>
            
          </li>
          <li class="nav-item">
            <a href="/feedingPlanManagement" class="nav-link">
              <i class="fas fa-cookie-bite nav-icon"></i>
              <p>
                Feeding Plan
              </p>
            </a>
            
          </li>

          <li class="nav-item">
            <a href="/cullingPlanManagement" class="nav-link">
              <i class="far fa-window-close nav-icon"></i>
              <p>
                Culling Plan                
              </p>
            </a>
            
          </li>

          <li class="nav-item">
            <a href="/reportManagement" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Reports
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../charts/chartjs.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>ChartJS</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../charts/flot.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Flot</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../charts/inline.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inline</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../charts/uplot.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>uPlot</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="/admin/logout" class="nav-link">
              <i class="fas fa-sign-out-alt nav-icon"></i>
              <p>
                Logout
                
                {{-- <i class="right fas fa-angle-left"></i> --}}
              </p>
            </a>
            
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../../dist/js/adminlte.min.js"></script>
</body>
</html>
