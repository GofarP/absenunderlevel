@extends('layouts.partials.partials-dashboard.partials-dashboard')
@section('title', 'Dashboard')
@section('page-heading', 'Selamat Datang ' . Auth::user()->name)
@section('content')
    @php
        $jabatan = Auth::user()->karyawan->first()?->jabatan?->nama;
    @endphp

    @if ($jabatan !== 'Administrator')
        <div class="row">
            
            <div class="col-xl-6 col-md-6 mb-4"> 
                <div class="card shadow h-100">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Bulan Ini ({{ \Carbon\Carbon::now()->translatedFormat('F') }})
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Masuk
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $jumlah_masuk_bulan_ini }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Bulan Lalu ({{ \Carbon\Carbon::now()->subMonth()->translatedFormat('F') }})
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Total Masuk
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $jumlah_masuk_bulan_lalu }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-history fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endif
@endsection