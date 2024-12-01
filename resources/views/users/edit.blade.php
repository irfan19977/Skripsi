@extends('layouts.master')

@section('content')
<div class="row ">
    <div class="col-12 col-md-11 col-lg-11 mx-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Tambah User</h4>
                <!-- Tambahkan tombol tambah di kanan -->
                <button type="button" class="btn btn-info" onclick="history.back()">Kembali</button>            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>No. Kartu</label>
                        <input type="number" class="form-control @error('no_kartu') is-invalid @enderror" name="no_kartu"
                            placeholder="Masukkan Nama User" value="{{ old('no_kartu', $user->no_kartu) }}" >
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
