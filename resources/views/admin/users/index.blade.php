@extends('layouts.admin')
@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Data User</h5>
    @if(Auth::user()->role !== 'kepsek')
    <a class="btn create-new btn-primary" href="{{ route('admin.users.create') }}">
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
          <th>Nama Lengkap</th>
          <th>Email</th>
          <th>Password</th>
          <th>Role</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach($users as $item)
        <tr>
          <td>{{$loop->iteration}}</td>
          <td>{{$item->name}}</td>
          <td>{{$item->email}}</td>
          <td>**********</td>
          <td>{{$item->role}}</td>
          <td>
            <div class="dropdown">
              <button
                type="button"
                class="btn p-0 dropdown-toggle hide-arrow shadow-none"
                data-bs-toggle="dropdown">
                <i class="icon-base ri ri-more-2-line icon-18px"></i>
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('admin.users.edit', $item->id) }}">
                  <i class="icon-base ri ri-pencil-line icon-18px me-1"></i>
                  Edit</a>
                <a href="{{ route('admin.users.destroy', $item->id) }}"
                  class="dropdown-item text-danger"
                  data-confirm-delete="true"
                  data-method="DELETE">
                    <i class="icon-base ri ri-delete-bin-6-line icon-18px me-1"></i>
                    Delete
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
                            
