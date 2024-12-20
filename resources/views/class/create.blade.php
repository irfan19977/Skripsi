@extends('layouts.master')

@section('content')
<div class="row ">
    <div class="col-12 col-md-11 col-lg-11 mx-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Tambah Kelas</h4>
                <!-- Tambahkan tombol tambah di kanan -->
                <button type="button" class="btn btn-info" onclick="history.back()">Kembali</button>            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('class.store') }}">
                    @csrf

                    <div class="form-group">
                        <label>Program Studi</label>
                        <select name="prodi" class="form-control" required>
                            <option value="">--Pilih Program Studi--</option>
                            <option value="Akuntansi">Akuntansi</option>
                            <option value="Teknik Komputer dan Jaringan">Teknik Komputer dan Jaringan</option>
                            <option value="Design Komunikasi Visual">Design Komunikasi Visual</option>
                            <option value="Asisten Keperawatan">Asisten Keperawatan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Nama Kelas</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            placeholder="Masukkan Mata pelajaran" autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Grade</label>
                        <input type="number" class="form-control @error('grade') is-invalid @enderror" name="grade"
                            placeholder="Masukkan Grade">
                        @error('grade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" type="submit">Simpan</button>
                        <button class="btn btn-secondary" type="reset">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
