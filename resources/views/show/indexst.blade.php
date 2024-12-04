@extends('layouts.master')

@section('content')
  <div class="card">
    <div class="card-header">
      <h4>User</h4>
      <div class="card-header-action">
        
        <form method="GET" action="{{ route('users.index') }}">
          <div class="input-group">
            <a href="{{ route('users.create') }}" class="btn btn-primary" data-toggle="tooltip" style="margin-right: 10px;" title="Tambah Data"><i class="fas fa-plus"></i></a>
            <input type="text" class="form-control" placeholder="Search" name="q">
            <div class="input-group-btn">
              <button class="btn btn-primary"><i class="fas fa-search"></i></button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped" id="sortable-table">
          <thead>
            <tr>
              <th class="text-center">No.</th>
              <th class="text-center">NISN</th>
              <th class="text-center">NAMA SISWA</th>
              <th class="text-center">KELAS</th>
              <th class="text-center">QR Code</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($students as $student)
              <tr>
                <td class="text-center">{{ ($students->currentPage() - 1) * $students->perPage() + $loop->iteration }}</td>
                <td class="text-center">{{ $student->nisn }}</td>
                <td>{{ $student->name }}</td>
                <td class="text-center">
                    {{ $student->classRoom->first()->name ?? 'Belum ada kelas' }}
                </td>
                <td class="text-center"> {!! $student->qr_code !!}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @if ($students->hasPages())
    <div class="card-footer text-center">
      <nav class="d-inline-block">
        <ul class="pagination mb-0">
            {{-- Previous Page Link --}}
            <li class="page-item {{ $students->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $students->previousPageUrl() }}" tabindex="-1">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </li>
    
            {{-- Pagination Elements --}}
            @foreach ($students->getUrlRange(1, $students->lastPage()) as $page => $url)
                <li class="page-item {{ $students->currentPage() == $page ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach
    
            {{-- Next Page Link --}}
            <li class="page-item {{ !$students->hasMorePages() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $students->nextPageUrl() }}">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </li>
        </ul>
      </nav>
    </div>
    @endif
  </div>
@endsection

