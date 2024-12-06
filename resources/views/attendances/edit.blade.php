@extends('layouts.master')

@section('content')
<div class="row ">
    <div class="col-12 col-md-11 col-lg-11 mx-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Edit Absensi</h4>
                <!-- Tambahkan tombol tambah di kanan -->
                <button type="button" class="btn btn-info" onclick="history.back()">Kembali</button>            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('attendances.update', $attendances->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>NISN</label>
                        <input type="text" class="form-control @error('nisn') is-invalid @enderror" name="nisn"
                            placeholder="Masukkan Mata pelajaran" value="{{ $attendances->student->nisn }}" readonly>
                        @error('nisn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>NAMA SISWA</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            placeholder="Masukkan Mata pelajaran" value="{{ $attendances->student->name }} - {{ $attendances->student->classRoom->first()->name }}" readonly>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>MATA PELAJARAN</label>
                        <input type="text" class="form-control @error('nisn') is-invalid @enderror" name="nisn"
                            placeholder="Masukkan Mata pelajaran" value="{{ $attendances->subject->name }}" readonly>
                        @error('nisn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>PENGAJAR</label>
                        <input type="text" class="form-control @error('nisn') is-invalid @enderror" name="nisn"
                            placeholder="Masukkan Mata Pelajaran" value="{{ $attendances->teacher->name }}" readonly>
                        @error('nisn')
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
