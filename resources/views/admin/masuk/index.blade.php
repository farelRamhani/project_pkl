@extends('layouts.admin')
@section('content')

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Surat Masuk</h5>
    @if(Auth::user()->role !== 'kepsek')
    <a class="btn create-new btn-primary" href="{{ route('admin.masuk.create') }}">
      <span class="d-flex align-items-center gap-2">
        <i class="icon-base ri ri-add-large-line"></i>
        <span class="d-none d-sm-inline-block">Add New Record</span>
      </span>
    </a>
    @endif
  </div>

  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>No</th>
          <th>Tgl Surat</th>
          <th>Tgl Terima</th>
          <th>Pengirim</th>
          <th>Perihal</th>
          <th>File Surat</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>

      <tbody class="table-border-bottom-0">
        @foreach($suratMasuk as $item)
        <tr>
          <td>
            {{ ($suratMasuk instanceof \Illuminate\Pagination\LengthAwarePaginator)
                ? ($suratMasuk->currentPage() - 1) * $suratMasuk->perPage() + $loop->iteration
                : $loop->iteration
            }}
          </td>
          <td>{{ $item->tgl_surat }}</td>
          <td>{{ $item->tgl_terima }}</td>
          <td>{{ $item->pengirim }}</td>
          <td>{{ $item->perihal }}</td>
          <td>
            @if($item->file_surat)
              <a href="{{ route('surat.lihat', $item->id) }}" target="_blank" class="btn btn-sm btn-info">
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
              @endif
            me-1">
              {{ $item->status }}
            </span>
          </td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow shadow-none" data-bs-toggle="dropdown">
                <i class="icon-base ri ri-more-2-line icon-18px"></i>
              </button>
              <div class="dropdown-menu">
                @if(
                  ($item->status !== 'didisposisi' && Auth::user()->role === 'admin') ||
                  ($item->status !== 'diproses' && Auth::user()->role === 'kepsek')
                )
                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalDisposisi-{{ $item->id }}">
                  <i class="icon-base ri ri-mail-send-line icon-18px me-1"></i>
                  Disposisi
                </a>
                @endif

                <a class="dropdown-item" href="{{ route('admin.masuk.edit', $item->id) }}">
                  <i class="icon-base ri ri-pencil-line icon-18px me-1"></i>
                  Edit
                </a>

                <a class="dropdown-item" href="{{ route('admin.masuk.destroy', $item->id) }}" data-confirm-delete="true">
                  <i class="icon-base ri ri-delete-bin-6-line icon-18px me-1"></i>
                  Delete
                </a>
              </div>
            </div>
          </td>
        </tr>

        {{-- MODAL DISPOSISI --}}
        <div class="modal fade" id="modalDisposisi-{{ $item->id }}" tabindex="-1">
          <div class="modal-dialog" role="document">
            <form
              action="{{ Auth::user()->role === 'admin'
                ? route('admin.disposisi.store')
                : route('kepsek.disposisi.store') }}"
              method="POST">
              @csrf
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Disposisi</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                  <div class="mb-3">
                    <label class="form-label">No Surat</label>
                    <input type="text" class="form-control" value="{{ $item->no_surat }}" readonly>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Tujuan Disposisi</label>
                    <select class="form-select" name="user_id" required>
                      @if(Auth::user()->role === 'admin')
                        @foreach($listakun as $akun)
                          <option value="{{ $akun->id }}">{{ $akun->name }}</option>
                        @endforeach
                      @else
                        @foreach($listUser as $user)
                          <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Catatan Disposisi</label>
                    <textarea class="form-control" name="catatan_disposisi" required></textarea>
                  </div>

                  <input type="hidden" name="surat_masuk_id" value="{{ $item->id }}">
                  <input type="hidden" name="pengirim_id" value="{{ Auth::id() }}">
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        {{-- END MODAL --}}
        @endforeach
      </tbody>
    </table>
  </div>
</div>

@endsection
