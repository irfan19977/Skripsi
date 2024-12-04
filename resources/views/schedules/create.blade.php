@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Tambah Jadwal Pelajaran</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('schedules.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="subject_id">Mata Pelajaran</label>
                <select name="subject_id" class="form-control" required>
                    <option value="">Pilih Mata Pelajaran</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->code }} - {{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="teacher_id">Guru</label>
                <select name="teacher_id" class="form-control" required>
                    <option value="">Pilih Guru</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="class_room_id">Kelas</label>
                <select name="class_room_id" class="form-control" required>
                    <option value="">Pilih Kelas</option>
                    @foreach($classRooms as $classRoom)
                        <option value="{{ $classRoom->id }}">{{ $classRoom->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="day">Hari</label>
                <select name="day" class="form-control" required>
                    <option value="">Pilih Hari</option>
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                    <option value="Sabtu">Sabtu</option>
                </select>
            </div>

            <div class="form-group">
                <label for="start_time">Waktu Mulai</label>
                <input type="time" name="start_time" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="end_time">Waktu Selesai</label>
                <input type="time" name="end_time" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="academic_year">Tahun Akademik</label>
                <input type="text" name="academic_year" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('schedules.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
