{{-- @extends('layouts.master')

@section('content')
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h4>Multi Select</h4>
      <!-- Tambahkan tombol tambah di kanan -->
      @can('permissions.create')
        <a href="{{ route('permissions.create') }}" class="btn btn-success">Tambah</a>
      @endcan
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <button id="delete-selected" class="btn btn-danger mb-3" style="display: none;">Hapus Checklist yang Dicentang</button>
        <table class="table table-striped" id="table-2">
          <thead>
            <tr>
              <th class="text-center pt-3">
                <div class="custom-checkbox custom-checkbox-table custom-control">
                  <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad"
                    class="custom-control-input" id="checkbox-all">
                  <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                </div>
              </th>
              <th>Nama Permission</th>
              <th>Keterangan</th>
              <th>Tanggal</th>
              @can('permissions.edit')
                <th>Aksi</th>
              @endcan
            </tr>
          </thead>
          <tbody>
            @foreach ($permissions as $permission)
            <tr>
              <td class="text-center pt-2">
                <div class="custom-checkbox custom-control">
                  <!-- Gunakan ID unik untuk setiap checkbox -->
                  <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input"
                    id="checkbox-{{ $permission->id }}">
                  <label for="checkbox-{{ $permission->id }}" class="custom-control-label">&nbsp;</label>
                </div>
              </td>
              <td>{{ $permission->name }}</td>
              <td>{{ $permission->keterangan }}</td>
              <td>{{ $permission->created_at }}</td>
              @can('permissions.edit')
                <td>
                  <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit">
                    <i class="fas fa-pencil-alt"></i>
                  </a>

                  <form id="delete-form-{{ $permission->id }}" action="{{ route('permissions.destroy', $permission->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete" onclick="confirmDelete('{{ $permission->id }}')">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                  
                </td>
              @endcan
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection --}}

@extends('layouts.master')

@section('content')
  <div class="card">
    <div class="card-header">
      <h4>Permissions</h4>
      <div class="card-header-action">
        
        <form method="GET" action="{{ route('permissions.index') }}">
          <div class="input-group">
            <a href="{{ route('permissions.create') }}" class="btn btn-primary" data-toggle="tooltip" style="margin-right: 10px;" title="Tambah Data"><i class="fas fa-plus"></i></a>
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
              <th >Nama Permission</th>
              @can('permissions.edit')
                <th>Aksi</th>
              @endcan
            </tr>
          </thead>
          <tbody>
            @foreach ($permissions as $permission)
              <tr>
                <td class="text-center">{{ ($permissions->currentPage() - 1) * $permissions->perPage() + $loop->iteration }}</td>
                <td>{{ $permission->name }}</td>
                @can('permissions.edit')
                  <td>
                    <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit">
                      <i class="fas fa-pencil-alt"></i>
                    </a>

                    <form id="delete-form-{{ $permission->id }}" action="{{ route('permissions.destroy', $permission->id) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="button" class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete" onclick="confirmDelete('{{ $permission->id }}')">
                        <i class="fas fa-trash"></i>
                      </button>
                    </form>
                    
                  </td>
                @endcan
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @if ($permissions->hasPages())
    <div class="card-footer text-center">
      <nav class="d-inline-block">
        <ul class="pagination mb-0">
            {{-- Previous Page Link --}}
            <li class="page-item {{ $permissions->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $permissions->previousPageUrl() }}" tabindex="-1">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </li>
    
            {{-- Pagination Elements --}}
            @foreach ($permissions->getUrlRange(1, $permissions->lastPage()) as $page => $url)
                <li class="page-item {{ $permissions->currentPage() == $page ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach
    
            {{-- Next Page Link --}}
            <li class="page-item {{ !$permissions->hasMorePages() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $permissions->nextPageUrl() }}">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </li>
        </ul>
      </nav>
    </div>
    @endif
  </div>
  
  <script>
    function confirmDelete(id) {
      swal({
        title: "Apakah Anda Yakin?",
        text: "Data ini akan dihapus secara permanen!",
        icon: "warning",
        buttons: [
          'Tidak',
          'Ya, Hapus'
        ],
        dangerMode: true,
      }).then(function(isConfirm) {
        if (isConfirm) {
          const form = document.getElementById(`delete-form-${id}`);
          const url = form.action;

          fetch(url, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
              _method: 'DELETE'
            })
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              swal({
                title: "Berhasil!",
                text: "Data berhasil dihapus.",
                icon: "success",
                timer: 3000,
                buttons: false
              }).then(() => {
                // Hapus baris tabel
                const rowToRemove = document.querySelector(`#delete-form-${id}`).closest('tr');
                rowToRemove.remove();

                // Perbarui nomor urut
                renumberTableRows();
              });
            } else {
              swal("Gagal", "Terjadi kesalahan saat menghapus data.", "error");
            }
          })
          .catch(error => {
            console.error("Error:", error);
            swal("Gagal", "Terjadi kesalahan saat menghapus data.", "error");
          });
        }
      });
    }

    function renumberTableRows() {
      const tableBody = document.querySelector('#sortable-table tbody');
      const rows = tableBody.querySelectorAll('tr');
      
      const currentPage = {{ $permissions->currentPage() }};
      const perPage = {{ $permissions->perPage() }};
      
      rows.forEach((row, index) => {
        const numberCell = row.querySelector('td:first-child');
        if (numberCell) {
          numberCell.textContent = (currentPage - 1) * perPage + index + 1;
        }
      });
    }
  
  </script>
  
@endsection

