@extends('layouts.admin')
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Form Controls</h5>
      <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
        <i class="ri ri-arrow-left-line me-1"></i> Kembali
      </a>
    </div>

    <div class="card-body demo-vertical-spacing demo-only-element">
      @if ($errors->any())
          <div class="alert alert-danger">
              <strong>Waduh, ada yang salah bro:</strong>
              <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif

      <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-floating form-floating-outline mb-6">
          <input
            type="text"
            class="form-control"
            id="exampleFormControlInput1"
            placeholder="Nama Lengkap" name="name" />
          <label for="exampleFormControlInput1">Nama Lengkap</label>
        </div>
        <div class="form-floating form-floating-outline mb-6">
          <input
            type="email"
            class="form-control"
            id="exampleFormControlInput1"
            placeholder="Email" name="email" />
          <label for="exampleFormControlInput1">Email</label>
        </div>
        <div class="form-floating form-floating-outline mb-6">
          <input
            type="password"
            class="form-control"
            id="exampleFormControlInput1"
            placeholder="Password" name="password" />
          <label for="exampleFormControlInput1">Password</label>
        </div>
        <div class="form-floating form-floating-outline mb-6">
          <input
            type="password"
            class="form-control"
            id="exampleFormControlInput1"
            placeholder="Confirm Password" name="password_confirmation" />
          <label for="exampleFormControlInput1">Confirm Password</label>
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
