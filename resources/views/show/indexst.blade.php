@extends('layouts.master')

@section('content')
  <div class="card">
    <div class="card-header">
      <h4>DAFTAR SISWA</h4>
      <div class="card-header-action">
        <form method="GET" action="{{ route('student.indexst') }}">
          <div class="input-group">
            <button type="button" id="print-selected-cards" class="btn btn-primary mr-2" style="display: none;" disabled>
              <i class="fas fa-print"></i> Cetak Kartu Terpilih
            </button>
            <input type="text" class="form-control" placeholder="Search" name="q">
            <div class="input-group-btn">
              <button class="btn btn-primary"><i class="fas fa-search"></i></button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="card-body p-0">
      <form id="print-cards-form" action="{{ route('student.print-cards') }}" method="POST">
        @csrf
        <div class="table-responsive">
          <table class="table table-striped" id="sortable-table">
            <thead>
              <tr>
                <th class="text-center">
                  <input type="checkbox" id="select-all-checkbox">
                </th>
                <th class="text-center">NO.</th>
                <th class="text-center">NO. KARTU</th>
                <th class="text-center">NISN</th>
                <th class="text-center">NAMA SISWA</th>
                <th class="text-center">KELAS</th>
                <th class="text-center">ALAMAT</th>
                <th class="text-center">QR CODE</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($students as $student)
                <tr>
                  <td class="text-center">
                    <input type="checkbox" name="selected_students[]" value="{{ $student->id }}" class="student-checkbox">
                  </td>
                  <td class="text-center">{{ ($students->currentPage() - 1) * $students->perPage() + $loop->iteration }}</td>
                  <td class="text-center">{{ $student->no_kartu }}</td>
                  <td class="text-center">{{ $student->nisn }}</td>
                  <td>{{ $student->name }}</td>
                  <td class="text-center">
                    {{ $student->classRoom->first()->name ?? 'Belum ada kelas' }}
                  </td>
                  <td>
                    @php
                        $city = ucwords(strtolower($student->city_name ?? '-'));
                        $district = ucwords(strtolower($student->district_name ?? '-'));
                        $village = ucwords(strtolower($student->village_name ?? '-'));
                    @endphp
                    @if ($city !== '-' && $district !== '-' && $village !== '-')
                        {{ "$city, Kec. $district, Dsn. $village" }}
                    @else
                        Belum ada alamat
                    @endif
                </td>  
              <td class="text-center">
                    <div style="width: 90px; height: 90px; display: inline-block;">
                      {!! $student->qr_code !!}
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </form>
    </div>
    @if ($students->hasPages())
    <div class="card-footer text-center">
      <nav class="d-inline-block">
        <ul class="pagination mb-0">
          {{-- Previous Page Link --}}
          <li class="page-item {{ $students->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $students->previousPageUrl() }}" tabindex="-1">
              <i class="fas fa-chevron-left"></i>
            </a>
          </li>
  
          {{-- Pagination Elements --}}
          @foreach ($students->getUrlRange(1, $students->lastPage()) as $page => $url)
            <li class="page-item {{ $students->currentPage() == $page ? 'active' : '' }}">
              <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
          @endforeach
  
          {{-- Next Page Link --}}
          <li class="page-item {{ !$students->hasMorePages() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $students->nextPageUrl() }}">
              <i class="fas fa-chevron-right"></i>
            </a>
          </li>
        </ul>
      </nav>
    </div>
    @endif
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const selectAllCheckbox = document.getElementById('select-all-checkbox');
      const studentCheckboxes = document.querySelectorAll('.student-checkbox');
      const printSelectedCardsBtn = document.getElementById('print-selected-cards');
      const printCardsForm = document.getElementById('print-cards-form');

      // Select/Deselect all checkboxes
      selectAllCheckbox.addEventListener('change', function() {
          studentCheckboxes.forEach(checkbox => {
              checkbox.checked = selectAllCheckbox.checked;
          });
          togglePrintButton();
      });

      // Handle individual checkbox changes
      studentCheckboxes.forEach(checkbox => {
          checkbox.addEventListener('change', function() {
              // Check if all checkboxes are checked
              const allChecked = Array.from(studentCheckboxes).every(cb => cb.checked);
              
              // Update 'select all' checkbox accordingly
              selectAllCheckbox.checked = allChecked;
              
              togglePrintButton();
          });
      });

      // Toggle print button visibility and state
      function togglePrintButton() {
          const selectedCheckboxes = document.querySelectorAll('.student-checkbox:checked');
          
          // Always show and enable button if any checkbox is checked
          if (selectedCheckboxes.length > 0) {
              printSelectedCardsBtn.style.display = 'inline-block';
              printSelectedCardsBtn.disabled = false;
          } else {
              printSelectedCardsBtn.style.display = 'none';
              printSelectedCardsBtn.disabled = true;
          }
      }

      // Print selected cards
      printSelectedCardsBtn.addEventListener('click', function() {
          printCardsForm.submit();
      });
    });
  </script>
@endsection