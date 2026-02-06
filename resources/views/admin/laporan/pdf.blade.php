<!DOCTYPE html>
<html>
<head>
    <title>Laporan Surat</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h3>Laporan Surat Masuk & Keluar</h3>
    <table>
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
            @foreach($laporan as $row)
            <tr>
                <td>{{ $row->tanggal }}</td>
                <td>{{ ucfirst($row->jenis) }}</td>
                <td>{{ $row->no_surat }}</td>
                <td>{{ $row->pengirim_tujuan }}</td>
                <td>{{ $row->perihal }}</td>
                <td>{{ $row->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
