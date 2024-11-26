@extends('layouts.master')

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
  
  <script>
    const deleteButton = document.getElementById('delete-selected');
    const checkboxes = document.querySelectorAll('input[data-checkboxes="mygroup"]');
    const selectAllCheckbox = document.getElementById('checkbox-all');
  
    // Fungsi untuk mengecek berapa banyak checkbox yang dicentang
    function updateDeleteButtonVisibility() {
      const selected = Array.from(checkboxes).filter(checkbox => checkbox.checked);
      deleteButton.style.display = selected.length > 1 ? 'block' : 'none';
    }
  
    // Event listener untuk semua checkbox
    checkboxes.forEach(checkbox => {
      checkbox.addEventListener('change', updateDeleteButtonVisibility);
    });
  
    // Event listener untuk "Select All"
    selectAllCheckbox.addEventListener('change', function() {
      checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
      });
      updateDeleteButtonVisibility();
    });
  
    // Event listener untuk tombol hapus
    deleteButton.addEventListener('click', function() {
      const selected = Array.from(checkboxes)
        .filter(checkbox => checkbox.checked)
        .map(checkbox => checkbox.value);
  
      if (selected.length > 0 && confirm('Apakah Anda yakin ingin menghapus checklist yang dipilih?')) {
        // Kirim data ke server menggunakan AJAX atau form
        fetch('/delete-permissions', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
          },
          body: JSON.stringify({ ids: selected }),
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            location.reload(); // Refresh halaman setelah penghapusan berhasil
          } else {
            alert('Terjadi kesalahan saat menghapus data.');
          }
        });
      }
    });
  </script>
@endsection
