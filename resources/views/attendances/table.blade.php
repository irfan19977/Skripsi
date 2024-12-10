<div class="table-responsive">
    <table class="table table-striped" id="sortable-table">
        <thead>
            <tr>
                <th class="text-center">No.</th>
                <th>NAMA SISWA</th>
                <th>PELAJARAN</th>
                <th>PENGAJAR</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Notes</th>
                @can('attendances.edit')
                    <th>Actions</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @forelse ($attendances as $attendance)
                <tr>
                    <td class="text-center">
                        {{ ($attendances->currentPage() - 1) * $attendances->perPage() + $loop->iteration }}
                    </td>
                    <td>{{ $attendance->student->name }}</td>
                    <td>{{ $attendance->subject->name }}</td>
                    <td>{{ $attendance->teacher->name }}</td>
                    <td>{{ $attendance->date }}</td>
                    <td>{{ $attendance->time }}</td>
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
                    @can('attendances.edit')
                        <td>
                            <a href="{{ route('attendances.edit', $attendance) }}" 
                                class="btn btn-primary btn-action mr-1" 
                                data-toggle="tooltip" 
                                title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>

                            <form id="delete-form-{{ $attendance->id }}" 
                                action="{{ route('attendances.destroy', $attendance) }}" 
                                method="POST" 
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        class="btn btn-danger btn-action" 
                                        data-toggle="tooltip" 
                                        title="Delete" 
                                        onclick="confirmDelete('{{ $attendance->id }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    @endcan
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No attendance records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>