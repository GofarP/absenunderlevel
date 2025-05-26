@extends('layouts.partials.partials-dashboard.partials-dashboard')
@section('title', 'Status Absensi')
@section('page-heading', 'Data Status Absensi')
@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <div class="table table-hover table-stripped">
                        @livewire('status-absensi.statusabsensi-index')
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
