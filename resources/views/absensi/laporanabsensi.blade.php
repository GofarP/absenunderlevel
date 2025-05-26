@extends('layouts.partials.partials-dashboard.partials-dashboard')
@section('title', 'Laporan Absensi')
@section('page-heading', 'Laporan Absensi')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <form action="{{ route('absensi.print') }}" method="POST" target="_blank">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Laporan Absensi</h5>
                            <div class="form-group">
                                <label for="mulai_dari">Mulai Dari:</label>
                                <input type="date" class="form-control" name="mulai_dari">
                            </div>
                            <div class="form-group">
                                <label for="sampai_dengan">Sampai Dengan:</label>
                                <input type="date" class="form-control" name="sampai_dengan">
                            </div>
                            <button class="form-control btn btn-primary">Print</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
