@extends('layouts.master')

@section('content')
  <div class="card">
    <div class="card-header">
      <h4>Roles</h4>
      <div class="card-header-action">
        
        <form method="GET" action="{{ route('roles.index') }}">
          <div class="input-group">
            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
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
              <th>Nama Roles</th>
              <th class="w-50">Permission</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($roles as $role)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $role->name }}</td>
                <td>
                  @foreach ($role->getPermissionNames() as $permission) 
                    <div class="badge badge-success mb-1 mr-1 mt-1">{{ $permission }}</div>
                  @endforeach
                </td>
                @can('roles.edit')
                  <td>
                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit">
                      <i class="fas fa-pencil-alt"></i>
                    </a>

                    <form id="delete-form-{{ $role->id }}" action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="button" class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete" onclick="confirmDelete('{{ $role->id }}')">
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
    @if ($roles->hasPages())
    <div class="card-footer text-center">
      <nav class="d-inline-block">
        <ul class="pagination mb-0">
            {{-- Previous Page Link --}}
            <li class="page-item {{ $roles->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $roles->previousPageUrl() }}" tabindex="-1">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </li>
    
            {{-- Pagination Elements --}}
            @foreach ($roles->getUrlRange(1, $roles->lastPage()) as $page => $url)
                <li class="page-item {{ $roles->currentPage() == $page ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach
    
            {{-- Next Page Link --}}
            <li class="page-item {{ !$roles->hasMorePages() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $roles->nextPageUrl() }}">
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
          // Lakukan request AJAX untuk menghapus data
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
              // Tampilkan SweetAlert berhasil
              swal({
                title: "Berhasil!",
                text: "Data berhasil dihapus.",
                icon: "success",
                timer: 3000,
                buttons: false
              }).then(() => {
                // Hapus baris tabel tanpa reload
                document.querySelector(`#delete-form-${id}`).closest('tr').remove();
              });
            } else {
              // Tampilkan pesan gagal
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
  </script>
  
@endsection
