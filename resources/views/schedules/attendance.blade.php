@extends('layouts.master')

@section('content')
@hasanyrole('student')
    <div class="section-header">
        <h1>Absensi Untuk {{ $schedule->subject->name }}</h1>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Detail Pelajaran</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Subject:</strong> {{ $schedule->subject->name }}<br>
                        <strong>Day:</strong> {{ $schedule->day }}<br>
                        <strong>Time:</strong> {{ $schedule->start_time }} - {{ $schedule->end_time }}
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Absensi {{ Auth::user()->name }}</h4>
                    <!-- Tambahkan tombol tambah di kanan -->
                    <button type="button" class="btn btn-info" onclick="history.back()">Kembali</button>            
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendances as $attendance)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($attendance->date)->translatedFormat('d F Y') }}</td>
                                    <td>
                                        @if ($attendance->status == 'hadir')
                                            <span class="badge badge-success">{{ $attendance->status_label }}</span>
                                        @elseif ($attendance->status == 'izin')
                                            <span class="badge badge-info">{{ $attendance->status_label }}</span>
                                        @elseif ($attendance->status == 'sakit')
                                            <span class="badge badge-warning">{{ $attendance->status_label }}</span>
                                        @else
                                            <span class="badge badge-danger">{{ $attendance->status_label }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $attendance->notes ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No attendance records found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endhasanyrole

@hasanyrole('teacher')
    <div class="section-header">
        <h1>Absensi Untuk {{ $schedule->subject->name }}</h1>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Detail Pelajaran & Kehadiran</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h5>Detail Pelajaran</h5>
                        <div class="border p-3 rounded">
                            <strong>Pengajar:</strong> {{ $schedule->teacher->name }}<br>
                            <strong>Mata Pelajaran:</strong> {{ $schedule->subject->name }}<br>
                            <strong>Kelas:</strong> {{ $schedule->classRoom->name }}<br>
                            <strong>Hari:</strong> {{ $schedule->day }}<br>
                            <strong>Waktu:</strong> {{ $schedule->start_time }} - {{ $schedule->end_time }}
                        </div>
                    </div>
                </div>
{{--                 
                <div class="row">
                    <div class="col-md-12">
                        <h5>Ringkasan Kehadiran</h5>
                        <div class="row">
                            @php
                                $totalStudents = $students->count();
                                $statusCounts = $attendances->groupBy('status')
                                    ->map->count()
                                    ->toArray();
                            @endphp
                            <div class="col-md-3">
                                <div class="alert alert-success">
                                    Hadir: {{ $statusCounts['hadir'] ?? 0 }} 
                                    ({{ $totalStudents > 0 ? number_format(($statusCounts['hadir'] ?? 0) / $totalStudents * 100, 2) : 0 }}%)
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="alert alert-warning">
                                    Izin: {{ $statusCounts['izin'] ?? 0 }} 
                                    ({{ $totalStudents > 0 ? number_format(($statusCounts['izin'] ?? 0) / $totalStudents * 100, 2) : 0 }}%)
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="alert alert-info">
                                    Sakit: {{ $statusCounts['sakit'] ?? 0 }} 
                                    ({{ $totalStudents > 0 ? number_format(($statusCounts['sakit'] ?? 0) / $totalStudents * 100, 2) : 0 }}%)
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="alert alert-danger">
                                    Alpha: {{ $statusCounts['alpha'] ?? 0 }} 
                                    ({{ $totalStudents > 0 ? number_format(($statusCounts['alpha'] ?? 0) / $totalStudents * 100, 2) : 0 }}%)
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Daftar Absensi {{ $schedule->subject->name }} - {{  $schedule->classRoom->name }}</h4>
                <div>
                    <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#tambahAbsensiModal">
                        Tambah Absensi
                    </button>
                    <button type="button" class="btn btn-info" onclick="history.back()">Kembali</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="attendance-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NISN</th>
                                <th>Nama</th>
                                <th>Total Pertemuan</th>
                                <th>Kehadiran</th>
                                <th>Persentase</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $index => $student)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $student->nisn }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->total_meetings }}</td>
                                    <td>{{ $student->present_count }}</td>
                                    <td>{{ $student->attendance_percentage }}%</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-primary" onclick="detailAbsensi({{ $student->id }})">
                                                Detail
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada siswa ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        @push('scripts')
        <script>
        function detailAbsensi(studentId) {
            // Implementasi modal atau halaman detail absensi per siswa
            // Misalnya: 
            window.location.href = `/attendance/detail/${studentId}/schedule/{{ $schedule->id }}`;
        }
        </script>
        @endpush
    </div>

@endhasanyrole
@endsection