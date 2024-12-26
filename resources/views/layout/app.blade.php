<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>EggGrade Pro | Home</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../../dist/css/adminlte.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light"
      style="background-color: #343a40; color: #ffffff;">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button" style="color: #ffffff;"><i
              class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          {{-- <b><a href="/admin" class="nav-link" style="color: #ffffff;">Home</a></b> --}}

          @if(Auth::user()->roleID === 1)
          <b><a href="{{ route('dashboard.index') }}" class="nav-link">
              <p style="color: #ffffff;">
                Dashboard
              </p>
            </a>
          </b>

          @endif
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="{{ route('eggGrading') }}" class="nav-link" style="color: #ffffff;">Grade Egg</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          @if(Auth::user()->roleID === 2)
          <a href="{{ route('task-schedulings.calendar') }}" class="nav-link" style="color: #ffffff;">Calender</a>
          @endif
        </li>
      </ul>

      </ul>
    </nav>

    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="/admin" class="brand-link">

        <img src="../../../dist/img/Chicken And Egg.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
          style="opacity: .8">
        <span class="brand-text font-weight-light">EggGrade Pro</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user (optional) -->

        {{--
        <!-- SidebarSearch Form -->
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
              @if(Auth::user()->roleID === 1)
              <a href="{{ route('dashboard.index') }}" class="nav-link">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>
                  Dashboard
                </p>
              </a>
            
              @endif
            
            </li>
            
            <li class="nav-item">
              @if(Auth::user()->roleID === 1)
              <a href="{{ route('users.index') }}" class="nav-link">
                <i class="fas fa-users-cog nav-icon"></i>
                <p>
                  User Management
                </p>
              </a>
              @endif

            </li>
            <li class="nav-item">
              <a href="{{ route('eggGrading') }}" class="nav-link">
                <i class="fas fa-egg nav-icon"></i>
                <p>
                  Grade Egg
                  <i class="far fa-plus-square" style="margin-left: 8px;"></i>
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('chickens.index') }}" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Chicken Management
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('cages.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Cage Management</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('chickens.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Chicken Management</p>
                  </a>
                </li>


              </ul>
            </li>

            <li class="nav-item">
              @if(Auth::user()->roleID === 1)
              <a href="{{ route('vaccinationplan.index') }}" class="nav-link">
                <i class="fas fa-syringe nav-icon"></i>
                <p>
                  Vaccination Management
                </p>
              </a>
              @endif
            </li>

            <li class="nav-item">
              @if(Auth::user()->roleID === 1)
              <a href="{{ route('vaccination_records.index') }}" class="nav-link">
                <i class="fas fa-syringe nav-icon"></i>
                <p>
                  Vaccination Records
                </p>
              </a>
              @endif
            </li>

            <li class="nav-item">
              @if(Auth::user()->roleID === 1)
              <a href="{{ route('task-schedulings.index') }}" class="nav-link">
                <i class="fas fa-tasks nav-icon"></i>
                <p>
                  Task Scheduling

                </p>
              </a>
              @endif
            </li>

            <li class="nav-item">
              @if(Auth::user()->roleID === 1)
              <a href="{{ route('collectionplan.index') }}" class="nav-link">
                <i class="fas fa-hand-holding nav-icon"></i>
                <p>
                  Egg Collection Plan
                </p>
              </a>
              @endif


            </li>
            <li class="nav-item">
              @if(Auth::user()->roleID === 1)
              <a href="{{ route('feedingplan.index') }}" class="nav-link">
                <i class="fas fa-cookie-bite nav-icon"></i>
                <p>
                  Feeding Plan
                </p>
              </a>
              @endif
            </li>

            <li class="nav-item">
              @if(Auth::user()->roleID === 1)
              <a href="{{ route('cullingplan.index') }}" class="nav-link">
                <i class="far fa-window-close nav-icon"></i>
                <p>
                  Culling Plan
                </p>
              </a>
              @endif
            </li>

            

            <li class="nav-item">
              @if(Auth::user()->roleID === 2)
              <a href="{{ route('employee.listAssignedTasks') }}" class="nav-link">
                <i class="fas fa-check nav-icon"></i>
                <p>Task Submission Form</p>
              </a>
              @endif
            </li>

            {{-- <li class="nav-item">
              <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
              <a href="#" class="nav-link"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt nav-icon"></i>
                <p>Logout</p>
              </a>
            </li> --}}

            <li class="nav-item">
              <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
              <a href="#" class="nav-link"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt nav-icon"></i>
                <p>Logout</p>
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