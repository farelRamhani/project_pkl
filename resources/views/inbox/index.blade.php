@extends('layouts.admin')
@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Inbox</h5>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>No Surat</th>
          <th>Tgl Surat</th>
          <th>Pengirim</th>
          <th>Perihal</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse($disposisi as $item)
        <tr>
          <td>{{$item->suratMasuk->no_surat}}</td>
          <td>{{$item->suratMasuk->tgl_surat}}</td>
          <td>{{$item->suratMasuk->pengirim}}</td>
          <td>{{$item->suratMasuk->perihal}}</td>
          <td>
            <div class="dropdown">
              <button
                type="button"
                class="btn p-0 dropdown-toggle hide-arrow shadow-none"
                data-bs-toggle="dropdown">
                <i class="icon-base ri ri-more-2-line icon-18px"></i>
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#basicModal-{{$item->id}}">
                  <i class="icon-base ri ri-mail-send-line icon-18px me-1"></i>
                  Detail
                </a>
              </div>
            </div>
          </td>
        @empty
<tr>
  <td colspan="5" class="text-center text-muted py-4">
    <i class="ri-information-line me-1"></i> Belum ada data surat masuk.
  </td>
</tr>
@endforelse

        </tr>
      
      </tbody>
    </table>
  </div>
</div>
@foreach($disposisi as $data)
<div class="modal fade" id="basicModal-{{$data->id}}" tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Detail Surat</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col mb-6 mt-2">
            <div class="form-floating form-floating-outline">
              <input type="text" id="nameBasic" class="form-control" placeholder="Enter Name" value="{{ $data->suratMasuk->no_surat}}" name="no_surat" readonly/> 
              <label for="nameBasic">No Surat</label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col mb-6 mt-2">
            <div class="form-floating form-floating-outline">
              <input type="text" id="nameBasic" class="form-control" placeholder="Enter Name" value="{{ $data->suratMasuk->tgl_surat}}" name="tgl_surat" readonly/> 
              <label for="nameBasic">Tanggal Surat</label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col mb-6 mt-2">
            <div class="form-floating form-floating-outline">
              <input type="text" id="nameBasic" class="form-control" placeholder="Enter Name" value="{{ $data->suratMasuk->pengirim}}" name="pengirim" readonly/> 
              <label for="nameBasic">Pengirim</label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col mb-6 mt-2">
            <div class="form-floating form-floating-outline">
              <input type="text" id="nameBasic" class="form-control" placeholder="Enter Name" value="{{ $data->suratMasuk->perihal}}" name="perihal" readonly/> 
              <label for="nameBasic">Perihal</label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col mb-6 mt-2">
            <a href="{{ route('suratMasuk.download', $data->surat_masuk_id) }}" class="btn btn-sm btn-primary">
              Download Surat
            </a>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <form action="{{ route('inbox.update', $data->suratMasuk->id) }}" method="POST">
          @csrf
          @method('PUT')
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          Close
        </button>
        <button type="submit" class="btn btn-primary">Tindak Lanjuti</button>
        </form>
      </div>
    </div>
  </div>
</div>
</form>
@endforeach
@endsection
                            
