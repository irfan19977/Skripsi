@extends('layouts.master')

@section('content')
  <div class="card">
    <div class="card-header">
      <h4>Daftar Guru</h4>
      <div class="card-header-action">
        <form method="GET" action="{{ route('teacher.indextc') }}">
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
      <form id="print-cards-form" action="{{ route('teacher.print-cards-tc') }}" method="POST">
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
                <th class="text-center">NAMA Guru</th>
                <th class="text-center">ALAMAT</th>
                <th class="text-center">QR CODE</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($teachers as $teacher)
                <tr>
                  <td class="text-center">
                    <input type="checkbox" name="selected_teachers[]" value="{{ $teacher->id }}" class="teacher-checkbox">
                  </td>
                  <td class="text-center">{{ ($teachers->currentPage() - 1) * $teachers->perPage() + $loop->iteration }}</td>
                  <td class="text-center">{{ $teacher->no_kartu }}</td>
                  <td class="text-center">{{ $teacher->nisn }}</td>
                  <td>{{ $teacher->name }}</td>
                  <td>{{ $teacher->province }}</td>
                  <td class="text-center">
                    <div style="width: 90px; height: 90px; display: inline-block;">
                      {!! $teacher->qr_code !!}
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </form>
    </div>
    @if ($teachers->hasPages())
    <div class="card-footer text-center">
      <nav class="d-inline-block">
        <ul class="pagination mb-0">
          {{-- Previous Page Link --}}
          <li class="page-item {{ $teachers->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $teachers->previousPageUrl() }}" tabindex="-1">
              <i class="fas fa-chevron-left"></i>
            </a>
          </li>
  
          {{-- Pagination Elements --}}
          @foreach ($teachers->getUrlRange(1, $teachers->lastPage()) as $page => $url)
            <li class="page-item {{ $teachers->currentPage() == $page ? 'active' : '' }}">
              <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
          @endforeach
  
          {{-- Next Page Link --}}
          <li class="page-item {{ !$teachers->hasMorePages() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $teachers->nextPageUrl() }}">
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
      const teacherCheckboxes = document.querySelectorAll('.teacher-checkbox');
      const printSelectedCardsBtn = document.getElementById('print-selected-cards');
      const printCardsForm = document.getElementById('print-cards-form');

      // Select/Deselect all checkboxes
      selectAllCheckbox.addEventListener('change', function() {
          teacherCheckboxes.forEach(checkbox => {
              checkbox.checked = selectAllCheckbox.checked;
          });
          togglePrintButton();
      });

      // Handle individual checkbox changes
      teacherCheckboxes.forEach(checkbox => {
          checkbox.addEventListener('change', function() {
              // Check if all checkboxes are checked
              const allChecked = Array.from(teacherCheckboxes).every(cb => cb.checked);
              
              // Update 'select all' checkbox accordingly
              selectAllCheckbox.checked = allChecked;
              
              togglePrintButton();
          });
      });

      // Toggle print button visibility and state
      function togglePrintButton() {
          const selectedCheckboxes = document.querySelectorAll('.teacher-checkbox:checked');
          
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