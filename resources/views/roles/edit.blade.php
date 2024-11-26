@extends('layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Roles</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('dashboard.index') }}">Dashboard</a></div>
          <div class="breadcrumb-item"><a href="#">Forms</a></div>
          <div class="breadcrumb-item">Create Roles</div>
        </div>
      </div>
      
      <div class="section-body">
        <h2 class="section-title">Advanced Forms</h2>
        <p class="section-lead">We provide advanced input fields, such as date picker, color picker, and so on.</p>

            <div class="card">
              <div class="card-header">
                  <h4><i class="fas fa-unlock"></i> Create Roles</h4>
              </div>

              <div class="card-body">
                <form action="{{ route('roles.update', $role->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>NAMA ROLE</label>
                        <input type="text" name="name" value="{{ old('name', $role->name) }}" placeholder="Masukkan Nama Role"
                            class="form-control @error('title') is-invalid @enderror">

                        @error('name')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">PERMISSIONS</label>
                        
                        @foreach ($permissions as $permission)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="check-{{ $permission->id }}" @if($role->permissions->contains($permission)) checked @endif>
                            <label class="form-check-label" for="check-{{ $permission->id }}">
                                {{ $permission->name }}
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i>
                        UPDATE</button>
                    <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button>

                </form>
                </div>
        </div>
      </div>
      
</section>
@endsection