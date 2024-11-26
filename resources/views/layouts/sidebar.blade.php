<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="index.html"> <img alt="image" src="assets/img/logo.png" class="header-logo" /> <span
        class="logo-name">Otika</span>
    </a>
  </div>
  <ul class="sidebar-menu">
    <li class="menu-header">Main</li>
    <li class="dropdown {{ Request::is('dashboard') ? 'active' : ''}} ">
      <a href="{{ route('dashboard.index') }}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
    </li>

    <li class="dropdown {{ Request::is('student') ? 'active' : ''}} ">
      <a href="#" class="nav-link"><i data-feather="monitor"></i><span>Siswa</span></a>
    </li>

    <li class="dropdown {{ Request::is('teacher') ? 'active' : ''}} ">
      <a href="#" class="nav-link"><i data-feather="monitor"></i><span>Guru</span></a>
    </li>

    <li class="dropdown {{ Request::is('mapel') ? 'active' : ''}} ">
      <a href="#" class="nav-link"><i data-feather="monitor"></i><span>Mata Pelajaran</span></a>
    </li>

    <li class="dropdown {{ Request::is('class') ? 'active' : ''}} ">
      <a href="#" class="nav-link"><i data-feather="monitor"></i><span>Kelas</span></a>
    </li>
    
    <li class="menu-header">UI Elements</li>
    <li class="dropdown {{ Request::is('permissions') ? 'active' : ''}} ">
      <a href="{{ route('permissions.index') }}" class="nav-link"><i data-feather="monitor"></i><span>Permissions</span></a>
    </li>

    <li class="dropdown {{ Request::is('roles') ? 'active' : ''}} ">
      <a href="{{ route('roles.index') }}" class="nav-link"><i data-feather="monitor"></i><span>Role</span></a>
    </li>
    
    <li class="dropdown {{ Request::is('users') ? 'active' : ''}} ">
      <a href="{{ route('users.index') }}" class="nav-link"><i data-feather="monitor"></i><span>User</span></a>
    </li>
  </ul>
</aside>