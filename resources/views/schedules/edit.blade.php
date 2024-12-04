@extends('layouts.master')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<div class="card">
    <div class="card-header">
        <h4>Edit Jadwal Pelajaran</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('schedules.update', $schedule->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="subject_id">Mata Pelajaran</label>
                <select name="subject_id" class="form-control" required>
                    <option value="">Pilih Mata Pelajaran</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ $schedule->subject_id == $subject->id ? 'selected' : '' }}>
                            {{ $subject->code }} - {{ $subject->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="teacher_id">Guru</label>
                <select name="teacher_id" class="form-control" required>
                    <option value="">Pilih Guru</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ $schedule->teacher_id == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="class_room_id">Kelas</label>
                <select name="class_room_id" class="form-control" required>
                    <option value="">Pilih Kelas</option>
                    @foreach($classRooms as $classRoom)
                        <option value="{{ $classRoom->id }}" {{ $schedule->class_room_id == $classRoom->id ? 'selected' : '' }}>
                            {{ $classRoom->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="day">Hari</label>
                <select name="day" class="form-control" required>
                    <option value="">Pilih Hari</option>
                    <option value="Senin" {{ $schedule->day == 'Senin' ? 'selected' : '' }}>Senin</option>
                    <option value="Selasa" {{ $schedule->day == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                    <option value="Rabu" {{ $schedule->day == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                    <option value="Kamis" {{ $schedule->day == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                    <option value="Jumat" {{ $schedule->day == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                    <option value="Sabtu" {{ $schedule->day == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                </select>
            </div>

            <div class="form-group">
                <label for="start_time">Waktu Mulai</label>
                <input type="time" name="start_time" class="form-control" value="{{ $schedule->start_time }}" required>
            </div>

            <div class="form-group">
                <label for="end_time">Waktu Selesai</label>
                <input type="time" name="end_time" class="form-control" value="{{ $schedule->end_time }}" required>
            </div>

            <div class="form-group">
                <label for="academic_year">Tahun Akademik</label>
                <input type="text" name="academic_year" class="form-control" value="{{ $schedule->academic_year }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('schedules.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection