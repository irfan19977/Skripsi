@extends('layouts.master')

@section('content')
  <div class="card">
    <div class="card-header">
      <h4>Jadwal Pelajaran</h4>
      <div class="card-header-action">
        <form method="GET" action="{{ route('schedules.index') }}">
          <div class="input-group">
            <a href="{{ route('schedules.create') }}" class="btn btn-primary" data-toggle="tooltip" style="margin-right: 10px;" title="Tambah Data"><i class="fas fa-plus"></i></a>
            <input type="text" class="form-control" placeholder="Cari Jadwal" name="q">
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
              <th>Pelajaran</th>
              <th>Guru</th>
              <th>Kelas</th>
              <th>Hari</th>
              <th>Jam Mulai</th>
              <th>Jam Selesai</th>
              @can('schedules.edit')
                <th>Aksi</th>
              @endcan
            </tr>
          </thead>
          <tbody>
            @foreach ($schedules as $schedule)
              <tr>
                <td class="text-center">{{ ($schedules->currentPage() - 1) * $schedules->perPage() + $loop->iteration }}</td>
                <td>{{ $schedule->subject->name }}</td>
                <td>{{ $schedule->teacher->name }}</td>
                <td>{{ $schedule->classRoom->name }}</td>
                <td>{{ $schedule->day }}</td>
                <td>{{ $schedule->start_time }}</td>
                <td>{{ $schedule->end_time }}</td>
                @can('schedules.edit')
                  <td class="text-center">
                    <a href="{{ route('schedules.edit', $schedule->id) }}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit">
                      <i class="fas fa-pencil-alt"></i>
                    </a>
                    <a href="{{ route('schedules.show', $schedule->id) }}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Lihat">
                      <i class="fas fa-eye"></i>
                    </a>
                    <form id="delete-form-{{ $schedule->id }}" action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="button" class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete" onclick="confirmDelete('{{ $schedule->id }}')">
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

    {{-- Pagination --}}
    @if ($schedules->hasPages())
      <div class="card-footer text-center">
        <nav class="d-inline-block">
          {{ $schedules->links() }}
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
      
      const currentPage = {{ $schedules->currentPage() }};
      const perPage = {{ $schedules->perPage() }};
      
      rows.forEach((row, index) => {
        const numberCell = row.querySelector('td:first-child');
        if (numberCell) {
          numberCell.textContent = (currentPage - 1) * perPage + index + 1;
        }
      });
    }
  
  </script>
@endsection
