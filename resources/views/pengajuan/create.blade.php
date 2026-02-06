@extends('layouts.admin')
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Form Controls</h5>
      <a href="{{ route('pengajuan.index') }}" class="btn btn-outline-secondary">
        <i class="ri ri-arrow-left-line me-1"></i> Kembali
      </a>
    </div>
    <div class="card-body demo-vertical-spacing demo-only-element">
      <form action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-floating form-floating-outline mb-6">
          <input type="text" class="form-control" placeholder="PT.XXX / Mr.XX / Mrs.XX"
            id="pengirim" value="{{ Auth::user()->name }}" readonly/>
          <label for="pengirim">Pengirim</label>
        </div>
        <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
        <div class="form-floating form-floating-outline mb-6">
          <input type="text" class="form-control" placeholder="PT.XXX / Mr.XX / Mrs.XX"
            id="pengirim" name="tujuan" />
          <label for="pengirim">Tujuan</label>
        </div>

        <div class="form-floating form-floating-outline mb-6">
          <textarea class="form-control h-px-100" id="perihal" placeholder="Perihal Surat"
            name="perihal"></textarea>
          <label for="perihal">Perihal Surat</label>
        </div>

        <div class="form-floating form-floating-outline mb-6">
          <input type="file" class="form-control" id="file_surat" name="file_surat" />
          <label for="file_surat">File Surat</label>
        </div>
        
        <div class="mt-3 text-end">
          <button type="submit" class="btn btn-primary">
            <i class="ri ri-save-line me-1"></i> Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
