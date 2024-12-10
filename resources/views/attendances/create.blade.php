@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header">
        <h4> Catatan Kehadiran</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('attendances.store') }}">
            @csrf

            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">NISN</label>
                <div class="col-sm-12 col-md-7">
                    <div class="input-group">
                        <input type="text" name="nisn" id="nisn" class="form-control" 
                               value="{{ isset($attendance) ? $attendance->student->nisn : old('nisn') }}"
                               placeholder="Masukkan NISN Siswa" required>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary" id="findStudentBtn">Cari Siswa</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Siswa</label>
                <div class="col-sm-12 col-md-7">
                    <select name="student_id" id="studentSelect" class="form-control" required>
                        <option value="" disabled selected>Pilih Siswa</option> <!-- Opsi default -->
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" 
                                {{ (isset($attendance) && $attendance->student_id == $student->id) ? 'selected' : '' }}>
                                {{ $student->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>            

            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Mata Pelajaran</label>
                <div class="col-sm-12 col-md-7">
                    <select name="subject_id" class="form-control selectric" required>
                        <option value="" disabled selected>Pilih Mata Pelajaran</option> <!-- Opsi default -->
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" 
                                {{ (isset($attendance) && $attendance->subject_id == $subject->id) ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Guru</label>
                <div class="col-sm-12 col-md-7">
                    <select name="teacher_id" class="form-control selectric" required>
                        <option value="" disabled selected>Pilih Guru</option> <!-- Opsi default -->
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" 
                                {{ (isset($attendance) && $attendance->teacher_id == $teacher->id) ? 'selected' : '' }}>
                                {{ $teacher->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal</label>
                <div class="col-sm-12 col-md-7">
                    <input type="date" name="date" class="form-control" 
                        value="{{ isset($attendance) ? $attendance->date : $currentDate }}" required>
                </div>
            </div>
            
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jam</label>
                <div class="col-sm-12 col-md-7">
                    <input type="time" name="time" class="form-control" 
                        value="{{ isset($attendance) ? $attendance->time : $currentTime }}" required>
                </div>
            </div>            

            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>
                <div class="col-sm-12 col-md-7">
                    <select name="status" class="form-control selectric" required>
                        <option value="hadir" {{ isset($attendance) && $attendance->status == 'hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="izin" {{ isset($attendance) && $attendance->status == 'izin' ? 'selected' : '' }}>Izin</option>
                        <option value="sakit" {{ isset($attendance) && $attendance->status == 'sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="alpha" {{ isset($attendance) && $attendance->status == 'alpha' ? 'selected' : '' }}>Alpha</option>
                    </select>
                </div>
            </div>

            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Catatan</label>
                <div class="col-sm-12 col-md-7">
                    <select name="status" class="form-control selectric" required>
                        <option value="kartu hilang" {{ isset($attendance) && $attendance->status == 'kartu hilang' ? 'selected' : '' }}>Kartu Hilang</option>
                        <option value="kartu tertinggal" {{ isset($attendance) && $attendance->status == 'kartu tertinggal' ? 'selected' : '' }}>Kartu Tertinggal</option>
                    </select>
                </div>
            </div>

            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                <div class="col-sm-12 col-md-7">
                    <button type="submit" class="btn btn-primary">
                        {{ isset($attendance) ? 'Update' : 'Tambah' }} Catatan Kehadiran
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#findStudentBtn').on('click', function() {
            const nisn = $('#nisn').val().trim();
            
            if (!nisn) {
                swal({
                    title: "Peringatan",
                    text: "Silakan masukkan NISN",
                    icon: "warning",
                    button: "OK"
                });
                return;
            }

            // Remove hardcoded time and day
            $.ajax({
                url: `/students/find-by-nisn/${nisn}`,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    // Populate student select
                    $('#studentSelect').html(`
                        <option value="${data.id}" selected>
                            ${data.name} (${data.class_name})
                        </option>
                    `);

                    // Automatically populate subject
                    $(`select[name="subject_id"]`).val(data.subject_id);

                    // Automatically populate teacher
                    $(`select[name="teacher_id"]`).val(data.teacher_id);

                    // Show success message
                    swal({
                        title: "Berhasil",
                        text: `Siswa ditemukan: ${data.name}\nMapel: ${data.subject_name}\nGuru: ${data.teacher_name}`,
                        icon: "success",
                        button: "OK"
                    });
                },
                error: function(xhr) {
                    console.error('Error:', xhr);
                    
                    // Show error message using SweetAlert
                    swal({
                        title: "Kesalahan",
                        text: xhr.responseJSON ? xhr.responseJSON.message : 'Siswa tidak ditemukan',
                        icon: "error",
                        button: "OK"
                    });
                }
            });
        });
    });
    
</script>

@endsection