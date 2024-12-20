<!DOCTYPE html>
<html lang="en">


<!-- index.html  21 Nov 2019 03:44:50 GMT -->
<head>
  <meta charset="UTF-8">
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Otika - Admin Dashboard Template</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('backend/assets/css/app.min.css') }}">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/assets/css/components.css') }}">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{ asset('backend/assets/css/custom.css') }}">
  <link rel='shortcut icon' type='image/x-icon' href='{{ asset('backend/assets/img/favicon.ico') }}' />
  
  <link rel="stylesheet" href="{{ asset('backend/assets/bundles/select2/dist/css/select2.min.css') }}">
  @stack('styles')
</head>

<body>
  {{-- <div class="loader"></div> --}}
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>

      @include('layouts.navbar')
      
      <div class="main-sidebar sidebar-style-2">
        @include('layouts.sidebar')
      </div>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          @yield('content')
        </section>
        
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          <a href="templateshub.net">Templateshub</a></a>
        </div>
        <div class="footer-right">
        </div>
      </footer>
    </div>
  </div>
  <!-- General JS Scripts -->
  <script src="{{ asset('backend/assets/js/app.min.js') }}"></script>
  <!-- JS Libraies -->
  <script src="{{ asset('backend/assets/bundles/apexcharts/apexcharts.min.js') }}"></script>
  <!-- Page Specific JS File -->
  <script src="{{ asset('backend/assets/js/page/index.js') }}"></script>
  <!-- Template JS File -->
  <script src="{{ asset('backend/assets/js/scripts.js') }}"></script>
  <!-- Custom JS File -->
  <script src="{{ asset('backend/assets/js/custom.js') }}"></script>
  <!-- Page Specific JS File -->
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="{{ asset('backend/assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
  {{-- <script src="https://unpkg.com/instascan@latest/instascan.min.js"></script> --}}
  
  <script>
    @if (session('success'))
        swal({
            title: "Berhasil!",
            text: "{{ session('success') }}",
            icon: "success",
            timer: 3000,
            button: false,
        });
    @endif

    @if (session('error'))
        swal({
            title: "Gagal!",
            text: "{{ session('error') }}",
            icon: "error",
            timer: 3000,
            button: false,
        });
    @endif
  </script>
  @stack('script')
  



</body>


<!-- index.html  21 Nov 2019 03:47:04 GMT -->
</html>