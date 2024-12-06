<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="index.html"> <img alt="image" src="{{ asset('backend/assets/img/logo.png') }}" class="header-logo" /> <span
        class="logo-name">Otika</span>
    </a>
  </div>
  <ul class="sidebar-menu">
    <li class="menu-header">Main</li>
    <li class="dropdown {{ Request::is('dashboard') ? 'active' : ''}} ">
      <a href="{{ route('dashboard.index') }}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
    </li>
    @can('students.index')    
      <li class="dropdown {{ Request::is('student*') ? 'active' : ''}} ">
        <a href="{{ route('student.indexst') }}" class="nav-link"><i data-feather="monitor"></i><span>Siswa</span></a>
      </li>
    @endcan

    @can('teachers.index')    
      <li class="dropdown {{ Request::is('teacher*') ? 'active' : ''}} ">
        <a href="{{ route('teacher.indextc') }}" class="nav-link"><i data-feather="monitor"></i><span>Guru</span></a>
      </li>
    @endcan
    
    @can('teachers.index')    
      <li class="dropdown {{ Request::is('teacher*') ? 'active' : ''}} ">
        <a href="{{ route('attendances.index') }}" class="nav-link"><i data-feather="monitor"></i><span>Guru</span></a>
      </li>
    @endcan

    @can('subjects.index')    
      <li class="dropdown {{ Request::is('subjects*') ? 'active' : ''}} ">
        <a href="{{ route('subjects.index') }}" class="nav-link"><i data-feather="monitor"></i><span>Mata Pelajaran</span></a>
      </li>
    @endcan

    @can('schedules.index')    
      <li class="dropdown {{ Request::is('schedules*') ? 'active' : ''}} ">
        <a href="{{ route('schedules.index') }}" class="nav-link"><i data-feather="monitor"></i><span>Jadwal Pelajaran</span></a>
      </li>
    @endcan

    @can('class.index') 
      <li class="dropdown {{ Request::is('class*') ? 'active' : ''}} ">
        <a href="{{ route('class.index') }}" class="nav-link"><i data-feather="monitor"></i><span>Kelas</span></a>
      </li>
    @endcan
    
    @if(auth()->user()->can('roles.index') || auth()->user()->can('permission.index') || auth()->user()->can('users.index'))
      <li class="menu-header">UI Elements</li>
    @endif

    @can('permissions.index')    
      <li class="dropdown {{ Request::is('permissions*') ? 'active' : ''}} ">
        <a href="{{ route('permissions.index') }}" class="nav-link"><i data-feather="monitor"></i><span>Permissions</span></a>
      </li>
    @endcan

    @can('roles.index')
      <li class="dropdown {{ Request::is('roles*') ? 'active' : ''}} ">
        <a href="{{ route('roles.index') }}" class="nav-link"><i data-feather="monitor"></i><span>Role</span></a>
      </li>
    @endcan
    
    @can('users.index')
      <li class="dropdown {{ Request::is('users*') ? 'active' : ''}} ">
        <a href="{{ route('users.index') }}" class="nav-link"><i data-feather="monitor"></i><span>User</span></a>
      </li>
    @endcan
  </ul>
</aside>