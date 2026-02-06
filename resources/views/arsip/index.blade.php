@extends('layouts.admin')
@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Arsip</h5>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>No Surat</th>
          <th>Tgl Surat</th>
          <th>Pengirim</th>
          <th>Perihal</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach($disposisi as $item)
        <tr>
          <td>{{$item->suratMasuk->no_surat}}</td>
          <td>{{$item->suratMasuk->tgl_surat}}</td>
          <td>{{$item->suratMasuk->pengirim}}</td>
          <td>{{$item->suratMasuk->perihal}}</td>
          <td>
            <span class="badge rounded-pill @if($item->suratMasuk->status == 'diproses') bg-label-primary @elseif($item->suratMasuk->status == 'didisposisi') bg-label-info @elseif($item->suratMasuk->status == 'ditindaklanjuti') bg-label-warning @endif  me-1">{{$item->suratMasuk->status}}</span>
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
                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#basicModal-{{$item->id}}">
                  <i class="icon-base ri ri-mail-send-line icon-18px me-1"></i>
                  Detail
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
            <a href="{{ route('suratMasuk.download', $item->id) }}" class="btn btn-sm btn-info">
                <i class="ri-download-line"></i> Download
            </a>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          Close
        </button>
      </div>
    </div>
  </div>
</div>
</form>
@endforeach 
@endsection
                            
