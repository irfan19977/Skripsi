@extends('layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Users</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('dashboard.index') }}">Dashboard</a></div>
          <div class="breadcrumb-item"><a href="#">Forms</a></div>
          <div class="breadcrumb-item">Users</div>
        </div>
      </div>
      
      <div class="section-body">
        <h2 class="section-title">Advanced Forms</h2>
        <p class="section-lead">We provide advanced input fields, such as date picker, color picker, and so on.</p>
            <div class="card">
              <div class="card-header">
                  <h4><i class="fas fa-unlock"></i> Users</h4>
              </div>

              <div class="card-body">
                <form action="{{ route('users.index') }}" method="GET">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            @can('users.create')
                                <div class="input-group-prepend">
                                    <a href="{{ route('users.create') }}" class="btn btn-primary" style="padding-top: 10px;"><i class="fa fa-plus-circle"></i> TAMBAH</a>
                                </div>
                            @endcan
                            <input type="text" class="form-control" name="q"
                                   placeholder="cari berdasarkan nama user">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> CARI
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col" style="text-align: center;width: 6%">NO.</th>
                            <th scope="col">NAMA USER</th>
                            <th scope="col">ROLE</th>
                            <th scope="col" style="width: 15%;text-align: center">AKSI</th>
                        </tr>
                        </thead>
                        {{-- <tbody>
                        @foreach ($users as $no => $user)
                            <tr>
                                <th scope="row" style="text-align: center">{{ ++$no + ($users->currentPage()-1) * $users->perPage() }}</th>
                                <td>{{ $user->name }}</td>
                                <td>
                                    @if(!empty($user->getRoleNames()))
                                        @foreach($user->getRoleNames() as $role)
                                            <label class="badge badge-success">{{ $role }}</label>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="text-center">
                                    @can('users.edit')
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                    @endcan
                                    
                                    @can('users.delete')
                                        <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $user->id }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody> --}}
                    </table>
                </div>
          </div>
      </div>
      
</section>

@endsection