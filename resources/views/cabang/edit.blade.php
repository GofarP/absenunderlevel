@extends('layouts.partials.partials-dashboard.partials-dashboard')
@section('title', 'Cabang')
@section('page-heading', 'Edit Cabang')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('cabang.update', $cabang->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group col-12 mb-3">
                            <label for="nama">Nama:</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
                                placeholder="Masukkan nama" value="{{ old('nama', $cabang->nama) }}">
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-12 mb-3">
                            <label>lattitude</label>
                            <input type="number" name="lattitude" id="lattitude"
                                class="form-control @error('lattitude') is-invalid @enderror" placeholder="Contoh: 0.923180"
                                step="any" value="{{ old('lattitude', $cabang->lattitude) }}" required>
                            @error('lattitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-12 mb-3">
                            <label>longitude</label>
                            <input type="number" name="longitude" id="longitude"
                                class="form-control @error('longitude') is-invalid @enderror" placeholder="Contoh: 0.923180"
                                step="any" value="{{ old('longitude', $cabang->longitude) }}" required>
                            @error('longitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-warning w-100">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
