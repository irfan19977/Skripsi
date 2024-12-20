@extends('layouts.master')

@section('content')
<div class="section-body">
  <div class="row mt-sm-4">
    <div class="col-12 col-md-12 col-lg-4">
      <div class="card author-box">
        <div class="card-body">
          <div class="author-box-center">
            <img alt="image" src="{{ asset('backend/assets/img/users/user-1.png') }}" class="rounded-circle author-box-picture">
            <div class="clearfix"></div>
            <div class="author-box-name">
              <a href="#">{{ $user->name }}</a>
            </div>
            <div class="author-box-job">NISN : {{ $user->nisn }}</div>
          </div>
          <div class="text-center">
            <div class="author-box-description">
              <p>
                {{ $user->first()->about ?? 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur voluptatum alias molestias
                minus quod dignissimos.' }}
              </p>
            </div>
            <div class="mb-2 mt-3">
              <div class="text-small font-weight-bold">Follow Hasan On</div>
            </div>
            <a href="#" class="btn btn-social-icon mr-1 btn-facebook">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="btn btn-social-icon mr-1 btn-twitter">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="btn btn-social-icon mr-1 btn-github">
              <i class="fab fa-github"></i>
            </a>
            <a href="#" class="btn btn-social-icon mr-1 btn-instagram">
              <i class="fab fa-instagram"></i>
            </a>
            <div class="w-100 d-sm-none"></div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header">
          <h4>Data Diri</h4>
        </div>
        <div class="card-body">
          <div class="py-4">
            <p class="clearfix">
              <span class="float-left">
                Birthday
              </span>
              <span class="float-right text-muted">
                30-05-1998
              </span>
            </p>
            <p class="clearfix">
              <span class="float-left">
                Phone
              </span>
              <span class="float-right text-muted">
                (0123)123456789
              </span>
            </p>
            <p class="clearfix">
              <span class="float-left">
                Mail
              </span>
              <span class="float-right text-muted">
                {{ $user->email }}
              </span>
            </p>
            <p class="clearfix">
              <span class="float-left">
                Facebook
              </span>
              <span class="float-right text-muted">
                <a href="#">John Deo</a>
              </span>
            </p>
            <p class="clearfix">
              <span class="float-left">
                Twitter
              </span>
              <span class="float-right text-muted">
                <a href="#">@johndeo</a>
              </span>
            </p>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header">
          <h4>Skills</h4>
        </div>
        <div class="card-body">
          <ul class="list-unstyled user-progress list-unstyled-border list-unstyled-noborder">
            <li class="media">
              <div class="media-body">
                <div class="media-title">Java</div>
              </div>
              <div class="media-progressbar p-t-10">
                <div class="progress" data-height="6">
                  <div class="progress-bar bg-primary" data-width="70%"></div>
                </div>
              </div>
            </li>
            <li class="media">
              <div class="media-body">
                <div class="media-title">Web Design</div>
              </div>
              <div class="media-progressbar p-t-10">
                <div class="progress" data-height="6">
                  <div class="progress-bar bg-warning" data-width="80%"></div>
                </div>
              </div>
            </li>
            <li class="media">
              <div class="media-body">
                <div class="media-title">Photoshop</div>
              </div>
              <div class="media-progressbar p-t-10">
                <div class="progress" data-height="6">
                  <div class="progress-bar bg-green" data-width="48%"></div>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-12 col-lg-8">
      <div class="card">
        <div class="padding-20">
          <ul class="nav nav-tabs" id="myTab2" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about" role="tab"
                aria-selected="true">Pengaturan</a>
            </li>
          </ul>
          <div class="tab-content tab-bordered" id="myTab3Content">
            <form method="POST" action="{{ route('profile.update', $user->id) }}" class="needs-validation">
                @csrf
                @method('PUT')
              <div class="card-header">
                <h4>Edit Profile</h4>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="form-group col-md-12 col-12">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" readonly>
                    <div class="invalid-feedback">
                      Please fill in the first name
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-7 col-12">
                    <label>Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}">
                    @error('email')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                   
                  </div>
                  <div class="form-group col-md-5 col-12">
                    <label>No. Whatsapp</label>
                    <input type="number" class="form-control @error('no_wa') is-invalid @enderror" name="no_wa" value="{{ $user->no_wa }}">
                    @error('no_wa')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-12">
                    <label>Bio</label>
                    <textarea
                      class="form-control summernote-simple" name="bio">{{ $user->bio }}</textarea>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-6 col-12">
                    <label>Provinsi</label>
                    <select name="province" id="province" class="form-control @error('province') is-invalid @enderror">
                      <option value="">Pilih Provinsi</option>
                      @foreach($provinces as $province)
                          <option value="{{ $province['id'] }}" 
                              @if((string) old('province', $user->province) === (string) $province['id']) selected @endif>
                              {{ $province['name'] }}
                          </option>
                      @endforeach
                    </select>
                    @error('province')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group col-md-6 col-12">
                    <label>Kabupaten/Kota</label>
                    <select name="city" id="city" class="form-control @error('city') is-invalid @enderror">
                        <option value="">Pilih Kabupaten/Kota</option>
                        @foreach($regencies as $city)
                          <option value="{{ $city['id'] }}" 
                              @if((string) old('city', $user->city) === (string) $city['id']) selected @endif>
                              {{ $city['name'] }}
                          </option>
                        @endforeach
                    </select>
                    @error('city')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-6 col-12">
                  <label>Kecamatan</label>
                  <select name="district" id="district" class="form-control @error('district') is-invalid @enderror">
                      <option value="">Pilih Kecamatan</option>
                      @foreach($districts as $district)
                        <option value="{{ $district['id'] }}" 
                            @if((string) old('district', $user->district) === (string) $district['id']) selected @endif>
                            {{ $district['name'] }}
                        </option>
                      @endforeach
                  </select>
                  @error('city')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group col-md-6 col-12">
                    <label>Desa</label>
                    <select name="village" id="village" class="form-control @error('village') is-invalid @enderror">
                        <option value="">Pilih Desa</option>
                        @foreach($villages as $village)
                        <option value="{{ $village['id'] }}" 
                            @if((string) old('village', $user->village) === (string) $village['id']) selected @endif>
                            {{ $village['name'] }}
                        </option>
                      @endforeach
                    </select>
                    @error('village')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                </div>
                <div class="row">
                  <div class="form-group col-12">
                    <label>Alamat</label>
                    <textarea
                      class="form-control summernote-simple @error('alamat') is-invalid @enderror" name="alamat">{{ $user->alamat }}</textarea>
                  </div>
                  @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                  <div class="form-group col-12">
                    <label>Ganti Password</label>
                    <input type="password"
                      class="form-control @error('password') is-invalid @enderror" 
                      name="password" 
                      placeholder="Kosongkan jika tidak ingin mengganti">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group col-12">
                    <label>Konfirmasi Password</label>
                    <input type="password"
                      class="form-control" 
                      name="password_confirmation" 
                      placeholder="Konfirmasi password baru">
                  </div>
                </div>
                
                
              </div>
              <div class="card-footer text-right">
                <button class="btn btn-primary">Save Changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('script')
<script>
  $(document).ready(function() {
    // Fungsi untuk memuat data select dinamis
    function loadSelect(url, selectElement, placeholder) {
      $.get(url, function(data) {
        selectElement.html(`<option value="">${placeholder}</option>`);
        data.forEach(function(item) {
          selectElement.append(new Option(item.name, item.id));
        });
        selectElement.trigger('change');
      });
    }
  
    // Event handler untuk provinsi
    $('#province').on('change', function() {
      const provinceId = $(this).val();
      const citySelect = $('#city');
      const districtSelect = $('#district');
      const villageSelect = $('#village');
  
      // Reset dropdown yang ada di bawahnya
      districtSelect.html('<option value="">Pilih Kecamatan</option>');
      villageSelect.html('<option value="">Pilih Desa</option>');
  
      if (provinceId) {
        loadSelect(
          `https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`, 
          citySelect, 
          'Pilih Kabupaten/Kota'
        );
      }
    });
  
    // Event handler untuk kota
    $('#city').on('change', function() {
      const cityId = $(this).val();
      const districtSelect = $('#district');
      const villageSelect = $('#village');
  
      // Reset dropdown yang ada di bawahnya
      villageSelect.html('<option value="">Pilih Desa</option>');
  
      if (cityId) {
        loadSelect(
          `https://www.emsifa.com/api-wilayah-indonesia/api/districts/${cityId}.json`, 
          districtSelect, 
          'Pilih Kecamatan'
        );
      }
    });
  
    // Event handler untuk kecamatan
    $('#district').on('change', function() {
      const districtId = $(this).val();
      const villageSelect = $('#village');
  
      if (districtId) {
        loadSelect(
          `https://www.emsifa.com/api-wilayah-indonesia/api/villages/${districtId}.json`, 
          villageSelect, 
          'Pilih Desa'
        );
      }
    });

    // Form validation function
    function validateForm() {
      let isValid = true;
      const requiredFields = [
        'name',
        'email',
        'no_wa',
        'province',
        'city',
        'district',
        'village',
        'alamat'
      ];

      requiredFields.forEach(function(fieldName) {
        const field = $(`[name="${fieldName}"]`);
        const value = field.val().trim();

        if (value === '') {
          isValid = false;
          field.addClass('is-invalid');
          
          // Create error message if not exists
          if (field.next('.invalid-feedback').length === 0) {
            field.after(`<div class="invalid-feedback">This field is required</div>`);
          }
        } else {
          field.removeClass('is-invalid');
          field.next('.invalid-feedback').remove();
        }
      });

      return isValid;
    }

    // Prevent navigation if form is incomplete
    $('a.nav-link, .sidebar-menu a').on('click', function(e) {
      if (!validateForm()) {
        e.preventDefault();
        Swal.fire({
          icon: 'warning',
          title: 'Formulir Tidak Lengkap!!',
          text: 'Harap isi semua kolom yang diperlukan sebelum meninggalkan situs.',
          confirmButtonText: 'OK'
        });
      }
    });

    // Form submission validation
    $('form').on('submit', function(e) {
      if (!validateForm()) {
        e.preventDefault();
        Swal.fire({
          icon: 'warning',
          title: 'Form Incomplete',
          text: 'Please fill out all required fields.',
          confirmButtonText: 'OK'
        });
      }
    });

    // Real-time validation as user types/changes fields
    $('input, select, textarea').on('change input', function() {
      const field = $(this);
      const value = field.val().trim();

      if (value === '') {
        field.addClass('is-invalid');
        
        // Create error message if not exists
        if (field.next('.invalid-feedback').length === 0) {
          field.after(`<div class="invalid-feedback">This field is required</div>`);
        }
      } else {
        field.removeClass('is-invalid');
        field.next('.invalid-feedback').remove();
      }
    });
  });
</script>

<!-- Add SweetAlert library for nice alert messages -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush