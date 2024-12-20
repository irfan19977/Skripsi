@extends('layouts.master')

@section('content')
<div class="row ">
    <div class="col-12 col-md-11 col-lg-11 mx-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Edit User</h4>
                <!-- Tambahkan tombol tambah di kanan -->
                <button type="button" class="btn btn-info" onclick="history.back()">Kembali</button>            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>No. Kartu</label>
                        <input type="text" id="no_kartu" class="form-control @error('no_kartu') is-invalid @enderror" 
                               name="no_kartu" value="{{ old('no_kartu', $user->no_kartu) }}" placeholder="Tap kartu RFID..." readonly>
                        @error('no_kartu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            placeholder="Masukkan Nama User" value="{{ old('name', $user->name) }}" >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>NISN</label>
                        <input type="number" class="form-control @error('nisn') is-invalid @enderror" name="nisn"
                            placeholder="Masukkan Nisn User" value="{{ old('nisn', $user->nisn) }}" >
                        @error('nisn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            placeholder="Masukkan Nama Email" value="{{ old('name', $user->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="d-block">Role</label>
                        @foreach ($roles as $role)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="role" value="{{ $role->name }}" id="check-{{ $role->id }}" 
                                {{ (isset($user) && $user->roles->first()->name == $role->name) ? 'checked' : '' }}>
                                <label class="form-check-label" for="check-{{ $role->id }}">{{ $role->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
    <script>
       $(document).ready(function() {
            let lastKnownRFID = '';
            let isWaitingConfirmation = false;
            let pollingTimeout = null;
            let oldValue = $('#no_kartu').val(); // Store initial value
            
            function clearRFIDCache() {
                return $.ajax({
                    url: '{{ route("clear.rfid") }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            }
            
            function pollRFID() {
                if (isWaitingConfirmation) {
                    pollingTimeout = setTimeout(pollRFID, 1000);
                    return;
                }

                $.ajax({
                    url: '{{ route("get.latest.rfid") }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.rfid && response.rfid !== lastKnownRFID && !isWaitingConfirmation) {
                            isWaitingConfirmation = true;
                            const currentRFID = response.rfid;
                            
                            // Check if card is already in use
                            if (response.is_used) {
                                swal({
                                    title: "Kartu Sudah Digunakan!",
                                    text: response.message,
                                    icon: "error",
                                    timer: 3000,
                                    buttons: false
                                });
                                
                                clearRFIDCache().then(() => {
                                    // Reset state
                                    isWaitingConfirmation = false;
                                    $('#no_kartu').val(oldValue);
                                });
                                
                                return;
                            }
                            
                            // If card is not in use, proceed with confirmation
                            swal({
                                title: "Kartu Terdeteksi!",
                                text: `Apakah anda akan menggunakan kartu dengan nomor ${currentRFID}?`,
                                icon: "warning",
                                buttons: [
                                    'Tidak',
                                    'Ya, Gunakan'
                                ],
                                dangerMode: true,
                            }).then(function(isConfirm) {
                                if (isConfirm) {
                                    // Jika user memilih Ya
                                    lastKnownRFID = currentRFID;
                                    oldValue = currentRFID; // Update old value
                                    $('#no_kartu').val(currentRFID);
                                    
                                    // Tambahkan efek highlight
                                    $('#no_kartu').addClass('bg-light');
                                    setTimeout(function() {
                                        $('#no_kartu').removeClass('bg-light');
                                    }, 500);
                                    
                                    // Notifikasi sukses
                                    swal({
                                        title: "Berhasil!",
                                        text: "Nomor kartu berhasil ditambahkan",
                                        icon: "success",
                                        timer: 1500,
                                        buttons: false
                                    });
                                } else {
                                    // Jika user memilih Tidak, kembalikan ke nilai lama
                                    $('#no_kartu').val(oldValue);
                                    
                                    // Clear the cache when user clicks No
                                    clearRFIDCache().then(() => {
                                        // Notifikasi batal
                                        swal({
                                            title: "Dibatalkan",
                                            text: "Tetap menggunakan nomor kartu sebelumnya",
                                            icon: "info",
                                            timer: 1500,
                                            buttons: false
                                        });
                                    });
                                }
                                // Reset waiting confirmation state
                                isWaitingConfirmation = false;
                            });
                        }
                    },
                    complete: function() {
                        pollingTimeout = setTimeout(pollRFID, 1000);
                    }
                });
            }
            
            // Mulai RFID polling
            pollRFID();
            
            // Reset button handler
            $('#resetRFID').click(function() {
                $('#no_kartu').val('');
                lastKnownRFID = '';
                oldValue = ''; // Reset old value as well
                isWaitingConfirmation = false;
                
                clearRFIDCache().then(() => {
                    swal({
                        title: "Reset!",
                        text: "Nomor kartu telah direset",
                        icon: "info",
                        timer: 1500,
                        buttons: false
                    });
                });
            });

            // Cleanup when leaving page
            $(window).on('beforeunload', function() {
                if (pollingTimeout) {
                    clearTimeout(pollingTimeout);
                }
            });
        });
    </script>
@endpush