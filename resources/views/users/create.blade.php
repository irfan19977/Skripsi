@extends('layouts.master')

@section('content')
<div class="row ">
    <div class="col-12 col-md-11 col-lg-11 mx-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Tambah User</h4>
                <!-- Tambahkan tombol tambah di kanan -->
                <button type="button" class="btn btn-info" onclick="history.back()">Kembali</button>            
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf

                    <div class="form-group">
                        <label>No. Kartu</label>
                        <input type="text" id="no_kartu" class="form-control @error('no_kartu') is-invalid @enderror" name="no_kartu"
                            placeholder="Masukkan No. Kartu" autofocus >
                        @error('no_kartu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            placeholder="Masukkan Nama User" autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>NISN</label>
                        <input type="text" class="form-control @error('nisn') is-invalid @enderror" name="nisn"
                            placeholder="Masukkan NISN User" autofocus>
                        @error('nisn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            placeholder="Masukkan Nama Email" autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="d-block">Role</label>
                        @foreach ($roles as $role)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('role') is-invalid @enderror" type="radio" name="role[]" value="{{ $role->name }}" id="check-{{ $role->id }}">
                                <label class="form-check-label" for="check-{{ $role->id }}">{{ $role->name }}</label>
                            </div>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        @endforeach
                    </div>
                        
                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" type="submit">Simpan</button>
                        <a href="{{ route('schedules.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi RFID Baru -->
<div class="modal fade" id="rfidModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kartu RFID Baru Terdeteksi</h5>
            </div>
            <div class="modal-body">
                <p>Kartu RFID <strong id="detectedRfidCard"></strong> belum terdaftar.</p>
                <p>Apakah Anda ingin mendaftarkan kartu ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="confirmRfid">Ya, Lanjutkan</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // WebSocket connection for real-time RFID detection
    const socket = new WebSocket('ws://your-websocket-server');

    socket.onmessage = function(event) {
        const data = JSON.parse(event.data);
        
        if (data.rfid_card) {
            // Show the modal with detected RFID card
            $('#detectedRfidCard').text(data.rfid_card);
            $('#rfidModal').modal('show');

            // When user confirms, set the RFID card in the input
            $('#confirmRfid').off('click').on('click', function() {
                $('#no_kartu').val(data.rfid_card);
                $('#rfidModal').modal('hide');
            });
        }
    };
});
</script>
@endsection
