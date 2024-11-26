@extends('layouts.master')

@section('content')
<div class="row ">
    <div class="col-12 col-md-11 col-lg-11 mx-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Tambah Permission</h4>
                <!-- Tambahkan tombol tambah di kanan -->
                <button type="button" class="btn btn-info" onclick="history.back()">Kembali</button>            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('permissions.store') }}">
                    @csrf

                    <div class="form-group">
                        <label>Nama Permission</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            placeholder="Masukkan Nama Permission" autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" class="form-control @error('keterangan') is-invalid @enderror"
                            name="keterangan" placeholder="Masukkan Keterangan" autofocus>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                        <button class="btn btn-secondary" type="reset">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
