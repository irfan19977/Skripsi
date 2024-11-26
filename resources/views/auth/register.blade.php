<!DOCTYPE html>
<html lang="en">


<!-- auth-register.html  21 Nov 2019 04:05:01 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Otika - Admin Dashboard Template</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('backend/assets/css/app.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/assets/bundles/jquery-selectric/selectric.css') }}">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/assets/css/components.css') }}">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{ asset('backend/assets/css/custom.css') }}">
  <link rel='shortcut icon' type='image/x-icon' href='{{ asset('backend/assets/img/favicon.ico') }}' />
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
            <div class="card card-primary">
              <div class="card-header">
                <h4>Register</h4>
              </div>
              <div class="card-body">
                
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                  <div class="row">
                    <div class="form-group col-6">
                      <label for="name">Nama</label>
                      <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"  value="{{ old('name') }}" placeholder="Masukkan Nama Lengkap" autofocus>
                      @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="form-group col-6">
                      <label for="no_wa">Nomor Whatsapp</label>
                      <input id="no_wa" type="number" class="form-control @error('no_wa') is-invalid @enderror" name="no_wa"  value="{{ old('no_wa') }}" placeholder="Masukkan Nomor WA">
                      @error('no_wa')
                      <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"  value="{{ old('email') }}" placeholder="Masukkan Email">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="row">
                    <div class="form-group col-6">
                      <label for="password" class="d-block">Password</label>
                      <input id="password" type="password" class="form-control pwstrength @error('password') is-invalid @enderror" data-indicator="pwindicator"
                        name="password" placeholder="Masukkan Password">
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      <div id="pwindicator" class="pwindicator">
                        <div class="bar"></div>
                        <div class="label"></div>
                      </div>
                    </div>
                    <div class="form-group col-6">
                      <label for="password2" class="d-block">Password Confirmation</label>
                      <input id="password2" type="password" class="form-control @error('password2') is-invalid @enderror" name="password_confirmation">
                      @error('password2')
                      <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="form-group col-6">
                      <label for="province">Provinsi</label>
                      <select name="province" id="province" class="form-control select2 @error('province') is-invalid @enderror">
                        <option value="">Pilih Provinsi</option>
                      </select>
                      @error('province')
                      <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="form-group col-6">
                      <label for="city">Kota/Kabupaten</label>
                      <select name="city" id="city" class="form-control select2 @error('city') is-invalid @enderror">
                        <option value="">Pilih Kota/Kabupaten</option>
                      </select>
                      @error('city')
                      <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-6">
                      <label for="district">Kecamatan</label>
                      <select name="district" id="district" class="form-control select2 @error('district') is-invalid @enderror">
                        <option value="">Pilih Kecamatan</option>
                      </select>
                      @error('distric')
                      <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="form-group col-6">
                      <label for="village">Desa/Kelurahan</label>
                      <select name="village" id="village" class="form-control select2 @error('village') is-invalid @enderror">
                        <option value="">Pilih Desa/Kelurahan</option>
                      </select>
                      @error('village')
                      <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                   </div>
                   <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="agree" class="custom-control-input @error('agree') is-invalid @enderror" id="agree">
                      <label class="custom-control-label" for="agree">I agree with the terms and conditions</label>
                      @error('agree')
                      <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                      Register
                    </button>
                  </div>
                </form>
              </div>
              <div class="mb-4 text-muted text-center">
                Sudah Punya Akun? <a href="{{ route('login') }}">Login</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- General JS Scripts -->
  <script src="{{ asset('backend/assets/js/app.min.js') }}"></script>
  <!-- JS Libraies -->
  <script src="{{ asset('backend/assets/bundles/jquery-pwstrength/jquery.pwstrength.min.js') }}"></script>
  <script src="{{ asset('backend/assets/bundles/jquery-selectric/jquery.selectric.min.js') }}"></script>
  <!-- Page Specific JS File -->
  <script src="{{ asset('backend/assets/js/page/auth-register.js') }}"></script>
  <!-- Template JS File -->
  <script src="{{ asset('backend/assets/js/scripts.js') }}"></script>
  <!-- Custom JS File -->
  <script src="{{ asset('backend/assets/js/custom.js') }}"></script>

  <script>
    $(document).ready(function() {
      // Fetch provinces
      $.get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json', function(provinces) {
        provinces.forEach(function(province) {
          $('#province').append(new Option(province.name, province.id));
        });
        $('#province').selectric('refresh');
      });

      // Fetch cities when province is selected
      $('#province').change(function() {
        var provinceId = $(this).val();
        $('#city').empty().append(new Option('Pilih Kota/Kabupaten', ''));
        $('#district').empty().append(new Option('Pilih Kecamatan', ''));
        $('#village').empty().append(new Option('Pilih Desa', ''));
        
        if (provinceId) {
          $.get(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`, function(cities) {
            cities.forEach(function(city) {
              $('#city').append(new Option(city.name, city.id));
            });
            $('#city').selectric('refresh');
          });
        }
      });

      // Fetch districts when city is selected
      $('#city').change(function() {
        var cityId = $(this).val();
        $('#district').empty().append(new Option('Pilih Kecamatan', ''));
        $('#village').empty().append(new Option('Pilih Desa', ''));
        
        if (cityId) {
          $.get(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${cityId}.json`, function(districts) {
            districts.forEach(function(district) {
              $('#district').append(new Option(district.name, district.id));
            });
            $('#district').selectric('refresh');
          });
        }
      });

      // Fetch villages when district is selected
      $('#district').change(function() {
        var districtId = $(this).val();
        $('#village').empty().append(new Option('Pilih Desa', ''));
        
        if (districtId) {
          $.get(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${districtId}.json`, function(villages) {
            villages.forEach(function(village) {
              $('#village').append(new Option(village.name, village.id));
            });
            $('#village').selectric('refresh');
          });
        }
      });
    });
  </script>
</body>


<!-- auth-register.html  21 Nov 2019 04:05:02 GMT -->
</html>