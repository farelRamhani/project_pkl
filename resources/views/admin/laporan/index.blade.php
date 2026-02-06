@extends('layouts.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Laporan Surat Masuk & Keluar</h5>

      <form method="GET" action="{{ route('admin.laporan.index') }}" class="d-flex gap-2">
        <input type="date" name="from" class="form-control form-control-sm" value="{{ request('from') }}">
        <input type="date" name="to" class="form-control form-control-sm" value="{{ request('to') }}">
        <select name="jenis" class="form-select form-select-sm">
          <option value="">Semua</option>
          <option value="masuk" {{ request('jenis') == 'masuk' ? 'selected' : '' }}>Surat Masuk</option>
          <option value="keluar" {{ request('jenis') == 'keluar' ? 'selected' : '' }}>Surat Keluar</option>
        </select>
        <button class="btn btn-primary btn-sm">Tampilkan</button>
        <button type="submit" name="cetak" value="1" class="btn btn-outline-secondary btn-sm">Cetak</button>
      </form>
    </div>

    <div class="card-body table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Jenis</th>
            <th>No Surat</th>
            <th>Pengirim / Tujuan</th>
            <th>Perihal</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($laporan as $row)
            <tr>
              <td>{{ $row->tanggal }}</td>
              <td>{{ ucfirst($row->jenis) }}</td>
              <td>{{ $row->no_surat }}</td>
              <td>{{ $row->pengirim_tujuan }}</td>
              <td>{{ $row->perihal }}</td>
              <td>
                <span class="badge 
                  @if($row->status == 'diproses') bg-primary
                  @elseif($row->status == 'didisposisi') bg-info
                  @elseif($row->status == 'ditindaklanjuti') bg-warning
                  @elseif($row->status == 'terkirim') bg-success
                  @endif
                ">{{ $row->status }}</span>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-muted">Tidak ada data</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection
