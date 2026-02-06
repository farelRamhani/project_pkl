@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-6">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Surat Masuk</h5>
          </div>
          <div class="table-responsive text-nowrap">
            <table class="table">
              <thead>
                <tr>
                    <th>No Surat</th>
                    <th>Tgl Surat</th>
                    <th>Tgl Terima</th>
                    <th>Pengirim</th>
                    <th>Perihal</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach($suratMasuk as $item)
                <tr>
                    <td>{{$item->no_surat}}</td>
                    <td>{{$item->tgl_surat}}</td>
                    <td>{{$item->tgl_terima}}</td>
                    <td>{{$item->pengirim}}</td>
                    <td>{{$item->perihal}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Surat Keluar</h5>
          </div>
          <div class="table-responsive text-nowrap">
            <table class="table">
              <thead>
                <tr>
                    <th>No Surat</th>
                    <th>Tgl Surat</th>
                    <th>Tujuan</th>
                    <th>Perihal</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach($suratKeluar as $item)
                <tr>
                    <td>{{$item->no_surat}}</td>
                    <td>{{$item->tgl_surat}}</td>
                    <td>{{$item->tujuan}}</td>
                    <td>{{$item->perihal}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
    </div>
</div>
@endsection
                            
