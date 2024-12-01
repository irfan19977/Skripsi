@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Daftar Siswa di Kelas: {{ $class->name }} ({{ $class->grade }})</h4>
    </div>
    <div class="card-body">
        @if($students->isEmpty())
            <div class="alert alert-info text-center">
                Tidak ada siswa terdaftar di kelas ini.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>NISN</th>
                            <th>Nama</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $studentClass)
                        <tr>
                            <td>{{ $studentClass->student->nisn }}</td>
                            <td>{{ $studentClass->student->name }}</td>
                            <td>{{ $studentClass->student->email }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        <a href="{{ route('class.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</div>
@endsection
