@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Assign Siswa ke Kelas: {{ $classes->name }} ({{ $classes->grade }})</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('class.simpan-assign') }}" method="POST">
            @csrf
            <input type="hidden" name="class_id" value="{{ $classes->id }}">
            
            <div class="form-group">
                <label>Tahun Akademik</label>
                <input type="text" name="academic_year" class="form-control" 
                       value="{{ date('Y') }}/{{ date('Y') + 1 }}" required>
            </div>

            <div class="form-group">
                <label>Pilih Siswa</label>
                <div class="selectgroup selectgroup-pills">
                    @forelse($students as $student)
                    <label class="selectgroup-item">
                        <input type="checkbox" name="student_ids[]" 
                               value="{{ $student->id }}" class="selectgroup-input">
                        <span class="selectgroup-button">{{ $student->nisn }} - {{ $student->name }}</span>
                    </label>
                    @empty
                    <div class="alert alert-info">
                        Tidak ada siswa yang dapat di-assign.
                    </div>
                    @endforelse
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Assign Siswa</button>
        </form>
    </div>
</div>
@endsection