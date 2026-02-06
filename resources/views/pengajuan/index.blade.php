@extends('layouts.admin')
@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Data Surat yang diajukan</h5>
    @if(Auth::user()->role == 'user')
    <a class="btn create-new btn-primary" href="{{ route('pengajuan.create') }}">
      <span class="d-flex align-items-center gap-2">
        <i class="icon-base ri ri-add-large-line"></i>
        <span class="d-none d-sm-inline-block">Tambah Pengajuan</span>
      </span>
    </a>
    @endif
  </div>

  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>Tujuan</th>
          <th>Tgl Input Pengajuan</th>
          <th>Perihal</th>
          <th>Status</th>
          @if(in_array(Auth::user()->role, ['admin', 'kepsek']))
          <th>Actions</th>
          @endif
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse($pengajuan as $item)
        <tr>
          <td>{{ $item->tujuan_surat }}</td>
          <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
          <td>{{ $item->perihal }}</td>
          <td>
            <span class="badge rounded-pill 
              @if($item->status == 'menunggu') bg-label-info
              @elseif($item->status == 'disetujui') bg-label-success
              @elseif($item->status == 'ditolak') bg-label-danger
              @else bg-label-secondary @endif">
              {{ ucfirst($item->status) }}
            </span>
          </td>

          @if(in_array(Auth::user()->role, ['admin', 'kepsek']))
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow shadow-none" data-bs-toggle="dropdown">
                <i class="icon-base ri ri-more-2-line icon-18px"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#basicModal-{{ $item->id }}">
                  <i class="ri ri-mail-send-line me-1"></i> Detail & Ubah Status
                </a>
              </div>
            </div>
          </td>
          @endif
        </tr>
        @empty
        <tr>
          <td colspan="{{ in_array(Auth::user()->role, ['admin', 'kepsek']) ? '5' : '4' }}" class="text-center text-muted py-4">
            <i class="ri-information-line me-1"></i> Belum ada data pengajuan surat.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Detail & Ubah Status (hanya untuk admin/kepsek) -->
@if(in_array(Auth::user()->role, ['admin', 'kepsek']))
@foreach($pengajuan as $data)
<div class="modal fade" id="basicModal-{{ $data->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Pengajuan Surat</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.pengajuan.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" value="{{ $data->status }}" readonly>
                <label>Status Saat Ini</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" value="{{ $data->user->name ?? '—' }}" readonly>
                <label>Pengirim</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" value="{{ $data->created_at->format('d/m/Y H:i') }}" readonly>
                <label>Tanggal Pengajuan</label>
              </div>
            </div>
            <div class="col-12">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" value="{{ $data->perihal }}" readonly>
                <label>Perihal</label>
              </div>
            </div>
            <div class="col-12">
              <a href="{{ route('pengajuan.download', $data->id) }}" class="btn btn-sm btn-primary">
                <i class="ri-download-line"></i> Download Surat
              </a>
            </div>
            <div class="col-12">
              <div class="form-floating form-floating-outline">
                <select class="form-select" name="status" required>
                  <option value="" disabled>Pilih Status Baru</option>
                  <option value="disetujui">Disetujui</option>
                  <option value="ditolak">Ditolak</option>
                </select>
                <label>Ubah Status</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan Status</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach
@endif

@endsection