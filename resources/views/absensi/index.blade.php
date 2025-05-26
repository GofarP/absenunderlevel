@extends('layouts.partials.partials-dashboard.partials-dashboard')
@section('title', 'Absensi')
@section('page-heading', 'Data Absensi')
@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if ( Auth::user()->karyawan->first()?->jabatan?->nama!='Administrator')

        <div class="card">
            <div class="card-body text-center">
                <h3>Absensi Hari Ini </h3>
                @if ($sudah_absen)
                    <p class="mt-2">
                        Anda sudah absen hari ini. Selamat Bekerja!
                    </p>
                @else
                    <p class="mt-2">
                        Silakan lakukan absensi untuk tanggal
                        <strong>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</strong>.
                    </p>
                    <a href="{{ route('absensi.create') }}" class="btn btn-primary">Absen Disini</a>
                @endif


            </div>
        </div>
        @endif
        <div class="card mt-5">
            <div class="card-body">
                <div class="table-responsive">
                    <div class="table table-hover table-stripped">
                        @livewire('absensi.absensi-index')
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
