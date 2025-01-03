@extends('layouts.master')

@section('content')
<div class="container-fluid">
    {{-- Filter Form --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('attendances.index') }}">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <select name="subject_id" class="form-control">
                                    <option value="">All Subjects</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}"
                                            {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-control">
                                    <option value="">All Statuses</option>
                                    @foreach($statuses as $key => $status)
                                        <option value="{{ $key }}"
                                            {{ request('status') == $key ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="date" class="form-control"
                                    value="{{ request('date') }}">
                            </div>
                            <div class="col-md-3 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary mr-2">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                @can('attendances.create') 
                                    <button type="button" class="btn btn-success" data-toggle="modal" 
                                        data-target="#qrScanModal"><i class="fas fa-qrcode"></i> Scan QR
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>   

    {{-- Attendance Records --}}
    <div class="card">
        <div class="card-header">
            <h4>Absensi Siswa</h4>
            <div class="card-header-action">
              
              <form method="GET" action="{{ route('class.index') }}">
                <div class="input-group">
                  @can('attendances.create')
                      <a href="{{ route('attendances.create') }}" class="btn btn-primary" data-toggle="tooltip" style="margin-right: 10px;" title="Tambah Data"><i class="fas fa-plus"></i></a>
                  @endcan
                  <input type="text" class="form-control" placeholder="Search" name="q">
                  <div class="input-group-btn">
                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                  </div>
                </div>
              </form>
            </div>
        </div>
        <div class="card-body p-0">
            @include('attendances.table')
        </div>

        {{-- Pagination --}}
        @if ($attendances->hasPages())
        <div class="card-footer text-center">
            <nav class="d-inline-block">
                <ul class="pagination mb-0">
                    {{-- Previous Page Link --}}
                    <li class="page-item {{ $attendances->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $attendances->previousPageUrl() }}" tabindex="-1">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
            
                    {{-- Pagination Elements --}}
                    @foreach ($attendances->getUrlRange(1, $attendances->lastPage()) as $page => $url)
                        <li class="page-item {{ $attendances->currentPage() == $page ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach
            
                    {{-- Next Page Link --}}
                    <li class="page-item {{ !$attendances->hasMorePages() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $attendances->nextPageUrl() }}">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        @endif
    </div>
</div>

@endsection

@push('script')
    <script>
        function confirmDelete(id) {
            swal({
                title: "Are you sure?",
                text: "This record will be permanently deleted!",
                icon: "warning",
                buttons: [
                    'Cancel',
                    'Yes, Delete'
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
                                title: "Deleted!",
                                text: "The record has been deleted.",
                                icon: "success",
                                timer: 3000,
                                buttons: false
                            }).then(() => {
                                // Remove table row
                                const rowToRemove = document.querySelector(`#delete-form-${id}`).closest('tr');
                                rowToRemove.remove();

                                // Renumber table rows
                                renumberTableRows();
                            });
                        } else {
                            swal("Failed", "An error occurred while deleting the record.", "error");
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        swal("Failed", "An error occurred while deleting the record.", "error");
                    });
                }
            });
        }

        function renumberTableRows() {
            const tableBody = document.querySelector('#sortable-table tbody');
            const rows = tableBody.querySelectorAll('tr');
            
            const currentPage = {{ $attendances->currentPage() }};
            const perPage = {{ $attendances->perPage() }};
            
            rows.forEach((row, index) => {
                const numberCell = row.querySelector('td:first-child');
                if (numberCell && row.querySelector('td:first-child').textContent !== 'No attendance records found.') {
                    numberCell.textContent = (currentPage - 1) * perPage + index + 1;
                }
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.min.js"></script>
    <script>
        const video = document.getElementById('video');
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');
    
        // Fungsi untuk memulai kamera
        function startCamera() {
            navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
                .then(stream => {
                    video.srcObject = stream;
                    video.play();
                    requestAnimationFrame(scanQR);
                })
                .catch(err => {
                    console.error("Error accessing the camera: ", err);
                    alert('Tidak dapat mengakses kamera. Pastikan izin kamera sudah diberikan.');
                });
        }
    
        function scanQR() {
            if (video.readyState === video.HAVE_ENOUGH_DATA) {
                canvas.height = video.videoHeight;
                canvas.width = video.videoWidth;
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                
                const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                const code = jsQR(imageData.data, imageData.width, imageData.height);
                
                if (code) {
                    // Stop video stream
                    const stream = video.srcObject;
                    const tracks = stream.getTracks();
                    tracks.forEach(track => track.stop());
                    video.srcObject = null;
                    
                    // Extract NISN from QR code
                    const nisn = extractNISN(code.data);
                    
                    if (nisn) {
                        sendAttendance(nisn);
                    } else {
                        alert('QR Code tidak valid');
                        $('#qrScanModal').modal('hide');
                    }
                } else {
                    requestAnimationFrame(scanQR);
                }
            } else {
                requestAnimationFrame(scanQR);
            }
        }
    
        function extractNISN(qrData) {
            // Assuming QR code is in format "NISN: 1234567890"
            const match = qrData.match(/NISN:\s*(\d+)/);
            return match ? match[1] : null;
        }
    
        function sendAttendance(nisn) {
            fetch('{{ route('attendances.scan-qr') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ nisn: nisn })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    swal({
                        title: "Absensi Berhasil!",
                        text: `${data.student.name} - ${data.student.class}\nMata Pelajaran: ${data.student.subject}\nPengajar: ${data.student.teacher}`,
                        icon: "success",
                        timer: 3000,
                        buttons: false
                    }).then(() => {
                // Reload halaman setelah sweet alert ditutup
                window.location.reload();
            });
                } else {
                    swal({
                        title: "Absensi Gagal",
                        text: data.message,
                        icon: "error"
                    });
                }
                $('#qrScanModal').modal('hide');
            })
            .catch(error => {
                console.error('Error:', error);
                swal({
                    title: "Kesalahan",
                    text: "Terjadi kesalahan saat melakukan absensi",
                    icon: "error"
                });
                $('#qrScanModal').modal('hide');
            });
        }
    
        // Event listener untuk membuka modal
        $('#qrScanModal').on('show.bs.modal', function () {
            startCamera();
        });
    
        // Event listener untuk menutup modal
        $('#qrScanModal').on('hidden.bs.modal', function () {
            const stream = video.srcObject;
            if (stream) {
                const tracks = stream.getTracks();
                tracks.forEach(track => track.stop());
            }
            video.srcObject = null;
        });
    </script>
@endpush