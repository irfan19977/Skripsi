@extends('layouts.master')

@section('content')
<div class="row ">
    <div class="col-12 col-md-11 col-lg-11 mx-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Edit Kelas</h4>
                <!-- Tambahkan tombol tambah di kanan -->
                <button type="button" class="btn btn-info" onclick="history.back()">Kembali</button>            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('class.update', $classes->slug) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Nama Kelas</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            placeholder="Masukkan Mata pelajaran" value="{{ old('name', $classes->name) }}" autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Grade</label>
                        <input type="number" class="form-control @error('grade') is-invalid @enderror" name="grade"
                            placeholder="Masukkan Grade" value="{{ old('grade', $classes->grade) }}">
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
