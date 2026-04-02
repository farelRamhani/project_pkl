@extends('layouts.admin')
@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Surat Keluar</h5>
    <a class="btn create-new btn-primary" href="{{ route('admin.keluar.create') }}">
      <span class="d-flex align-items-center gap-2">
        <i class="icon-base ri ri-add-large-line"></i>
        <span class="d-none d-sm-inline-block">Add New Record</span>
      </span>
    </a>
  </div>

  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>No Surat</th>
          <th>Tgl Surat</th>
          <th>Tujuan</th>
          <th>Perihal</th>
          <th>File Surat</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>

      <tbody class="table-border-bottom-0">
        @foreach($suratKeluar as $item)
        <tr>
          <td>{{ $item->no_surat }}</td>
          <td>{{ $item->tgl_surat }}</td>
          <td>{{ $item->tujuan }}</td>
          <td>{{ $item->perihal }}</td>

          {{-- FILE SURAT (DIBENARKAN) --}}
          <td>
            @if($item->file_surat)
             <a
              href="{{ route('admin.keluar.show', $item->id) }}"
              target="_blank"
              class="btn btn-sm btn-info">
              <i class="ri-eye-line"></i> Lihat
            </a>



            @else
              <span class="text-muted">Tidak ada</span>
            @endif
          </td>

          <td>
            <span class="badge rounded-pill
              @if($item->status == 'diproses') bg-label-primary
              @elseif($item->status == 'didisposisi') bg-label-info
              @elseif($item->status == 'ditindaklanjuti') bg-label-warning
              @endif me-1">
              {{ $item->status }}
            </span>
          </td>

          <td>
            <div class="dropdown">
              <button
                type="button"
                class="btn p-0 dropdown-toggle hide-arrow shadow-none"
                data-bs-toggle="dropdown">
                <i class="icon-base ri ri-more-2-line icon-18px"></i>
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('admin.keluar.edit', $item->id) }}">
                  <i class="icon-base ri ri-pencil-line icon-18px me-1"></i> Edit
                </a>
                <a class="dropdown-item"
                   href="{{ route('admin.keluar.destroy', $item->id) }}"
                   data-confirm-delete="true">
                  <i class="icon-base ri ri-delete-bin-6-line icon-18px me-1"></i> Delete
                </a>
              </div>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
