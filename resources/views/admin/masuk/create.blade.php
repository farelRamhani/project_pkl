@extends('layouts.admin')
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Form Surat Masuk</h5>
      <a href="{{ route('admin.masuk.index') }}" class="btn btn-outline-secondary">
        <i class="ri ri-arrow-left-line me-1"></i> Kembali
      </a>
    </div>

    <div class="card-body demo-vertical-spacing demo-only-element">
      <form action="{{ route('admin.masuk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- NO SURAT OTOMATIS --}}
        <div class="form-floating form-floating-outline mb-6">
          <input
            type="number"
            class="form-control"
            id="no_surat"
            name="no_surat"
            value="{{ $noSurat }}"
            readonly
          />
          <label for="no_surat">No Surat</label>
        </div>

        <div class="form-floating form-floating-outline mb-6">
          <input type="date" class="form-control" id="tgl_surat" name="tgl_surat" required />
          <label for="tgl_surat">Tanggal Surat</label>
        </div>

        <div class="form-floating form-floating-outline mb-6">
          <input type="date" class="form-control" id="tgl_terima" name="tgl_terima" required />
          <label for="tgl_terima">Tanggal Terima</label>
        </div>

        <div class="form-floating form-floating-outline mb-6">
          <input
            type="text"
            class="form-control"
            id="pengirim"
            name="pengirim"
            placeholder="PT.XXX / Mr.XX / Mrs.XX"
            required
          />
          <label for="pengirim">Pengirim</label>
        </div>

        <div class="form-floating form-floating-outline mb-6">
          <textarea
            class="form-control h-px-100"
            id="perihal"
            name="perihal"
            placeholder="Perihal Surat"
            required
          ></textarea>
          <label for="perihal">Perihal Surat</label>
        </div>

        <div class="form-floating form-floating-outline mb-6">
          <input
            type="file"
            class="form-control"
            id="file_surat"
            name="file_surat"
            accept=".pdf,.doc,.docx"
            required
          />
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
