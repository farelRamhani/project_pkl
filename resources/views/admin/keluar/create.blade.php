@extends('layouts.admin')
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Form Controls</h5>
      <a href="{{ route('admin.keluar.index') }}" class="btn btn-outline-secondary">
        <i class="ri ri-arrow-left-line me-1"></i> Kembali
      </a>
    </div>

    <div class="card-body demo-vertical-spacing demo-only-element">
      <form action="{{ route('admin.keluar.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-floating form-floating-outline mb-6">
          <input
            type="text"
            class="form-control"
            id="exampleFormControlInput1"
            placeholder="0000/XXX/00/0000" name="no_surat" />
          <label for="exampleFormControlInput1">No Surat</label>
        </div>

        <div class="form-floating form-floating-outline mb-6">
          <input type="date" class="form-control" id="tgl_surat" name="tgl_surat" />
          <label for="tgl_surat">Tanggal Surat</label>
        </div>

        <div class="form-floating form-floating-outline mb-6">
          <input type="text" class="form-control" id="tujuan" name="tujuan" />
          <label for="tujuan">Tujuan</label>
        </div>

        <div class="form-floating form-floating-outline mb-6">
          <textarea class="form-control h-px-100" id="perihal" placeholder="Perihal"
            name="perihal"></textarea>
          <label for="perihal">Perihal</label>
        </div>

        <div class="form-floating form-floating-outline mb-6">
          <input type="file" class="form-control" id="file_surat" name="file_surat" />
          <label for="file_surat">File Surat</label>
        </div>
        
        <div class="form-floating form-floating-outline mb-6">
          <select class="form-control form-select" name="status" id="jenisInput">
            <option value="draft">draft</option>
            <option value="terkirim">Terkirim</option>
          </select>
          <label for="jenisInput">File Surat</label>
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
