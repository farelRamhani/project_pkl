@extends('layouts.admin')
@section('content')

<style>
.stat-box{
  background:#fff;
  border-radius:16px;
  padding:20px;
  display:flex;
  align-items:center;
  gap:16px;
  box-shadow:0 8px 22px rgba(0,0,0,.08);
  transition:.3s;
}
.stat-box:hover{
  transform:translateY(-5px);
  box-shadow:0 14px 30px rgba(0,0,0,.14);
}
.stat-icon{
  width:54px;
  height:54px;
  border-radius:14px;
  display:flex;
  align-items:center;
  justify-content:center;
  color:#fff;
}
.stat-icon i{font-size:26px;}
.bg-masuk{background:#7c5cff;}
.bg-keluar{background:#2ecc71;}
.bg-arsip{background:#f1c40f;}
.bg-user{background:#3498db;}
.stat-text p{
  margin:0;
  font-size:14px;
  color:#6c757d;
}
.stat-text h4{
  margin:0;
  font-weight:700;
}
</style>

<div class="row gy-4">

{{-- ================= STATISTIK ================= --}}
@if(Auth::user()->role == 'admin')
<div class="col-12">
  <div class="card">
    <div class="card-header">
      <h5 class="mb-0">Statistik Data</h5>
    </div>
    <div class="card-body">
      <div class="row g-4">

        <div class="col-md-3 col-6">
          <div class="stat-box">
            <div class="stat-icon bg-masuk"><i class="ri-mail-line"></i></div>
            <div class="stat-text">
              <p>Surat Masuk</p>
              <h4>{{ $totalMasuk }}</h4>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-6">
          <div class="stat-box">
            <div class="stat-icon bg-keluar"><i class="ri-mail-send-line"></i></div>
            <div class="stat-text">
              <p>Surat Keluar</p>
              <h4>{{ $totalKeluar }}</h4>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-6">
          <div class="stat-box">
            <div class="stat-icon bg-arsip"><i class="ri-archive-line"></i></div>
            <div class="stat-text">
              <p>Arsip</p>
              <h4>{{ $totalArsip }}</h4>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-6">
          <div class="stat-box">
            <div class="stat-icon bg-user"><i class="ri-group-line"></i></div>
            <div class="stat-text">
              <p>Pengguna</p>
              <h4>{{ $totalUsers }}</h4>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endif

{{-- ================= TABEL (2 KOLOM) ================= --}}
<div class="col-md-6">

  {{-- SURAT MASUK --}}
  <div class="card h-100">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Surat Masuk Terbaru</h5>
      <select class="form-select form-select-sm w-auto"
              onchange="filterTable(this, 'tableMasuk', 3)">
        <option value="">Semua</option>
        <option value="diproses">Diproses</option>
        <option value="didisposisi">Didisposisi</option>
        <option value="ditindaklanjuti">Ditindaklanjuti</option>
      </select>
    </div>

    <div class="table-responsive">
      <table class="table table-hover align-middle" id="tableMasuk">
        <thead class="table-light">
          <tr>
            <th>No Surat</th>
            <th>Pengirim</th>
            <th>Perihal</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($suratMasuk->take(5) as $data)
          <tr>
            <td>{{ $data->no_surat }}</td>
            <td>{{ $data->pengirim }}</td>
            <td>{{ $data->perihal }}</td>
            <td>
              <span class="badge rounded-pill
                @if($data->status=='diproses') bg-primary
                @elseif($data->status=='didisposisi') bg-info
                @elseif($data->status=='ditindaklanjuti') bg-warning
                @endif">
                {{ $data->status }}
              </span>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="col-md-6">

  {{-- SURAT KELUAR --}}
  <div class="card h-100">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Surat Keluar Terbaru</h5>
      <select class="form-select form-select-sm w-auto"
              onchange="filterTable(this, 'tableKeluar', 3)">
        <option value="">Semua</option>
        <option value="draft">Draft</option>
        <option value="terkirim">Terkirim</option>
      </select>
    </div>

    <div class="table-responsive">
      <table class="table table-hover align-middle" id="tableKeluar">
        <thead class="table-light">
          <tr>
            <th>No Surat</th>
            <th>Tujuan</th>
            <th>Perihal</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($suratKeluar->take(5) as $data)
          <tr>
            <td>{{ $data->no_surat }}</td>
            <td>{{ $data->tujuan }}</td>
            <td>{{ $data->perihal }}</td>
            <td>
              <span class="badge rounded-pill
                @if($data->status=='draft') bg-info
                @elseif($data->status=='terkirim') bg-success
                @endif">
                {{ $data->status }}
              </span>
            </td>
          </tr> 
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

</div>

{{-- ================= SCRIPT FILTER ================= --}}
<script>
function filterTable(select, tableId, colIndex) {
  const filter = select.value.toLowerCase();
  const rows = document.querySelectorAll(`#${tableId} tbody tr`);

  rows.forEach(row => {
    const cell = row.cells[colIndex].innerText.toLowerCase();
    row.style.display = filter === '' || cell.includes(filter)
      ? ''
      : 'none';
  });
}
</script>

@endsection
