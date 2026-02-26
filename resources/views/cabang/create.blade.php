@extends('layouts.partials.partials-dashboard.partials-dashboard')
@section('title', 'Cabang')
@section('page-heading', 'Tambah Cabang')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('cabang.store') }}" method="POST">
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
                            <label>lattitude</label>
                            <input type="number" class="form-control @error('lattitude') is-invalid @enderror"
                                name="lattitude" placeholder="Masukkan Garis Lintang" value="{{ old('lattitude') }}" />
                            @error('lattitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-12 mb-3">
                            <label>longitude</label>
                            <input type="number" name="longitude" id="longitude"
                                class="form-control @error('longitude') is-invalid @enderror" placeholder="Masukan Garis bujur"
                                step="any" value="{{ old('longitude') }}" required />
                            @error('longitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Simpan</button>

            </div>

            </form>
        </div>
    </div>
    </div>

@endsection
