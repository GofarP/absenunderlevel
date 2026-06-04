<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi - Lava Cheese</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body {
            background-color: #fff;
            color: #212529;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        .kop-border-bottom {
            border-bottom: 4px solid #000 !important;
            padding-bottom: 8px;
        }
        .kop-line-thin {
            border-bottom: 1px solid #000 !important;
            margin-top: 2px;
            margin-bottom: 25px;
        }

        /* Desain Judul Laporan yang Lebih Tegas */
        .judul-laporan {
            letter-spacing: 1.5px;
            color: #111;
            font-weight: 700;
        }

        /* Kapsul Tanggal Periode yang Lebih Proper */
        .periode-box {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 30px;
            padding: 6px 20px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #495057;
            font-weight: 600;
        }

        /* Tombol Cetak Cantik */
        .btn-cetak {
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        /* Format text tabel agar seimbang */
        .table th {
            font-size: 14px;
            letter-spacing: 0.5px;
            padding: 12px 8px !important;
        }
        .table td {
            font-size: 14px;
            padding: 10px 8px !important;
        }

        @media print {
            .hide-on-print {
                display: none !important;
            }
            @page {
                size: A4;
                margin: 1.5cm;
            }
            body {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .periode-box {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        
        <div class="row align-items-center kop-border-bottom">
            <div class="col-2 text-center">
                <img src="{{ asset('lavacheese_black.png') }}" alt="Logo Lava Cheese" class="img-fluid" style="max-height: 90px; object-fit: contain;">
            </div>
            
            <div class="col-10 text-center pe-5">
                <h2 class="fw-bold mb-0" style="letter-spacing: 2px;">LAVA CHEESE</h2>
                <p class="text-uppercase fw-bold my-1" style="font-size: 13px; color: #555;">Restoran & Cafe</p>
                <p class="mb-1" style="font-size: 13px; line-height: 1.4;">
                    Melayu Kota Piring, Kec. Tanjungpinang Timur, Kota Tanjung Pinang, Kepulauan Riau 29122
                </p>
                <p class="mb-0" style="font-size: 13px;">
                    <strong>Telepon:</strong> 0811-6666-943
                </p>
            </div>
        </div>
        <div class="kop-line-thin"></div>


        <div class="text-center mb-4">
            <h3 class="text-uppercase judul-laporan mb-2">Laporan Absensi</h3>
            
            <div class="d-block mb-3">
                <div class="periode-box">
                    <i class="bi bi-calendar3 text-primary"></i>
                    <span>
                        {{ \Carbon\Carbon::parse($mulai_dari)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($sampai_dengan)->format('d/m/Y') }}
                    </span>
                </div>
            </div>

            <div class="hide-on-print">
                <button class="btn btn-primary btn-cetak shadow-sm" onclick="window.print()">
                    <i class="bi bi-printer-fill me-2"></i>Cetak Laporan
                </button>
            </div>
        </div>


        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Status Absensi</th>
                        <th>Jenis Absensi</th>
                        <th>Lembur</th>
                        <th>Shift</th>
                        <th>Jam Masuk</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_laporan_absensi as $item)
                        <tr>
                            <td class="text-center fw-bold text-muted">{{ $loop->iteration }}</td>
                            <td class="fw-bold text-dark">{{ $item->users->name }}</td>
                            <td class="text-center">
                                <span class="badge {{ $item->statusabsensi->nama == 'Hadir' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ $item->statusabsensi->nama ?? '-' }}
                                </span>
                            </td>
                            <td class="text-center">{{ $item->jenisabsensi->nama ?? '-' }}</td>
                            <td class="text-center">{{ $item->lembur == 1 ? 'Ya' : 'Tidak' }}</td>
                            <td class="text-center">{{ $item->users->karyawan->first()?->shift?->nama ?? '-' }}</td>
                            <td class="text-center text-secondary font-monospace">{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        <div class="row mt-5 pt-4">
            <div class="col-8"></div>
            <div class="col-4 text-center" style="font-size: 14px;">
                <p class="mb-1 text-secondary">Tanjungpinang, {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
                <p class="fw-bold mb-5 pb-4 text-dark">Manager Lava Cheese,</p>
                <p class="fw-bold text-dark text-underline mb-0" style="text-decoration: underline;">
                    ( .................................... )
                </p>
            </div>
        </div>

    </div>
</body>

</html>