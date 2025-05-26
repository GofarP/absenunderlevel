<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Gaji</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        @media print {
            .hide-on-print {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <h3 class="text-center mt-3 mb-3">Laporan Gaji</h3>
    <p class="text-center">{{ \Carbon\Carbon::parse($mulai_dari)->format('d/m/Y') }} -
        {{ \Carbon\Carbon::parse($sampai_dengan)->format('d/m/Y') }}</p>

    <div class="text-center mb-3">
        <button class="btn btn-primary hide-on-print" onclick="window.print()">Cetak Laporan</button>
    </div>

    <div class=" table-responsive">
        <table class="table table-bordered">
            <thead>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>Gaji Harian </th>
                <th>Lembur</th>
            </thead>
            <tbody>
                @foreach ($data_laporan_gaji as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i:s') }}</td>
                        <td>{{ $item->absensi->users->name}}</td>
                        <td>{{ number_format($item->gaji_harian) }}</td>
                        <td>{{ number_format($item->lembur) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


</html>
