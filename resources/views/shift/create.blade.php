@extends('layouts.partials.partials-dashboard.partials-dashboard')
@section('title', 'Shift')
@section('page-heading', 'Tambah Shift')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('shift.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-12 mb-3">
                            <label for="name">Nama:</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
                                placeholder="Masukkan nama" value="{{ old('nama') }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-12 mb-3">
                            <label for="mulai_dari">Mulai Dari:</label>
                            <input type="time" name="mulai_dari" class="form-control" value="{{ old('mulai_dari') }}">
                            @error('mulai_dari')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-12 mb-3">
                            <label for="sampai_dengan">Sampai Dengan:</label>
                            <input type="time" name="sampai_dengan" class="form-control" value="{{ old('sampai_dengan') }}">
                            @error('mulai_dari')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>

@endsection
