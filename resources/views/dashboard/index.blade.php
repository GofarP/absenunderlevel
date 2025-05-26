@extends('layouts.partials.partials-dashboard.partials-dashboard')
@section('title', 'Dashboard')
@section('page-heading', 'Selamat Datang ' . Auth::user()->name)
@section('content')
    @php
        $jabatan = Auth::user()->karyawan->first()?->jabatan?->nama;
    @endphp

    @if ($jabatan !== 'Administrator')
        <!-- Earnings (Monthly) Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Gaji Dan Lembur Bulan
                    {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</h6>
            </div>
            <div class="card-body">
                <div class="row">

                    <!-- Total Masuk Bulan -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Jumlah Masuk Bulan {{ \Carbon\Carbon::now()->translatedFormat('F') }}
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlah_masuk_bulan_ini }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Lembur -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Jumlah Lembur {{ \Carbon\Carbon::now()->translatedFormat('F') }}
                                        </div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                    {{ $jumlah_lembur_bulan_ini }}</div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Total Gaji -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Total Gaji {{ \Carbon\Carbon::now()->translatedFormat('F') }}
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ number_format($total_gaji_harian_bulan_ini) }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-coins fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Lembur Bulan -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Total Lembur {{ \Carbon\Carbon::now()->translatedFormat('F') }}
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ number_format($total_lembur_bulan_ini) }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-business-time fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gaji Bulan -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Gaji Bulan {{ \Carbon\Carbon::now()->translatedFormat('F') }}
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ number_format($total_gaji_bulan_ini) }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-wallet fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- End Card Body -->
        </div> <!-- End Main Card -->

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Gaji Dan Lembur Bulan
                    {{ \Carbon\Carbon::now()->subMonth()->translatedFormat('F Y') }}</h6>
            </div>
            <div class="card-body">
                <div class="row">

                    <!-- Total Masuk Bulan -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Jumlah Masuk Bulan {{ \Carbon\Carbon::now()->subMonth()->translatedFormat('F') }}
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlah_masuk_bulan_lalu }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Lembur -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Jumlah Lembur {{ \Carbon\Carbon::now()->subMonth()->translatedFormat('F') }}
                                        </div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                    {{ $jumlah_lembur_bulan_lalu }}</div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Total Gaji -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Total Gaji {{ \Carbon\Carbon::now()->subMonth()->translatedFormat('F') }}
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ number_format($total_gaji_harian_bulan_lalu) }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-coins fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Lembur Bulan -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Total Lembur {{ \Carbon\Carbon::now()->subMonth()->translatedFormat('F') }}
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ number_format($total_lembur_bulan_lalu) }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-business-time fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gaji Bulan -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Gaji Bulan {{ \Carbon\Carbon::now()->subMonth()->translatedFormat('F') }}
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ number_format($total_gaji_bulan_lalu) }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-wallet fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- End Card Body -->
        </div> <!-- End Main Card -->
    @endif

@endsection
