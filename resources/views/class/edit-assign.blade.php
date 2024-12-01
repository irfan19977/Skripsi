@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Edit Assign Siswa: {{ $class->name }} ({{ $class->grade }})</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('class.update-assign', $class->slug) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="academic_year" value="{{ date('Y') }}/{{ date('Y') + 1 }}">

            <div class="row">
                <!-- Siswa yang sudah terdaftar -->
                <div class="col-md-6 mb-4">
                    <h5>Siswa yang Sudah Terdaftar</h5>
                    <input type="text" id="search-assigned" class="form-control mb-3" placeholder="Cari siswa terdaftar...">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%">
                                        <input type="checkbox" id="check-all-assigned">
                                    </th>
                                    <th>NISN</th>
                                    <th>Nama</th>
                                </tr>
                            </thead>
                            <tbody id="assigned-table-body">
                                @forelse($assignedStudents as $student)
                                <tr class="assigned-row">
                                    <td>
                                        <input type="checkbox" name="remove_student_ids[]" 
                                               value="{{ $student->student->id }}" 
                                               class="assigned-checkbox">
                                    </td>
                                    <td>{{ $student->student->nisn }}</td>
                                    <td>{{ $student->student->name }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Tidak ada siswa terdaftar</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tambah siswa baru -->
                <div class="col-md-6">
                    <h5>Tambah Siswa Baru</h5>
                    <input type="text" id="search-available" class="form-control mb-3" placeholder="Cari siswa baru...">
                    <div class="selectgroup selectgroup-pills" id="available-students">
                        @forelse($availableStudents as $student)
                        <label class="selectgroup-item available-row mb-2">
                            <input type="checkbox" name="student_ids[]" 
                                   value="{{ $student->id }}" class="selectgroup-input">
                            <span class="selectgroup-button">
                                {{ $student->nisn }} - {{ $student->name }}
                            </span>
                        </label>
                        @empty
                        <div class="alert alert-info text-center">
                            Tidak ada siswa yang dapat ditambahkan.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success mt-3">Perbarui Daftar Siswa</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Pencarian siswa yang sudah terdaftar
document.getElementById('search-assigned').addEventListener('input', function() {
    let searchValue = this.value.toLowerCase();
    document.querySelectorAll('.assigned-row').forEach(row => {
        let text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchValue) ? '' : 'none';
    });
});

// Pencarian siswa baru
document.getElementById('search-available').addEventListener('input', function() {
    let searchValue = this.value.toLowerCase();
    document.querySelectorAll('.available-row').forEach(label => {
        let text = label.textContent.toLowerCase();
        label.style.display = text.includes(searchValue) ? '' : 'none';
    });
});

// Check all functionality
document.getElementById('check-all-assigned').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.assigned-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});
</script>
@endpush
