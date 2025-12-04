@extends('layouts.app')

@section('title', 'Tambah Motor')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3"><i class="fas fa-plus-circle"></i> Tambah Motor Baru</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-motorcycle"></i> Form Input Motor
                </div>
                <div class="card-body">
                    <form action="{{ route('motor.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group mb-3">
                            <label for="Id_motor" class="form-label">ID Motor</label>
                            <input type="text" class="form-control @error('Id_motor') is-invalid @enderror" 
                                   id="Id_motor" name="Id_motor" placeholder="Contoh: MTR001" required>
                            @error('Id_motor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="Merk_motor" class="form-label">Merk Motor</label>
                            <input type="text" class="form-control @error('Merk_motor') is-invalid @enderror" 
                                   id="Merk_motor" name="Merk_motor" placeholder="Contoh: Honda" required>
                            @error('Merk_motor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="Warna_motor" class="form-label">Warna Motor</label>
                            <input type="text" class="form-control @error('Warna_motor') is-invalid @enderror" 
                                   id="Warna_motor" name="Warna_motor" placeholder="Contoh: Merah" required>
                            @error('Warna_motor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="Plat_nomor" class="form-label">Plat Nomor</label>
                            <input type="text" class="form-control @error('Plat_nomor') is-invalid @enderror" 
                                   id="Plat_nomor" name="Plat_nomor" placeholder="Contoh: B 1234 XYZ" required>
                            @error('Plat_nomor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="Tahun_motor" class="form-label">Tahun Motor</label>
                            <input type="text" class="form-control @error('Tahun_motor') is-invalid @enderror" 
                                   id="Tahun_motor" name="Tahun_motor" placeholder="Contoh: 2023" required>
                            @error('Tahun_motor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="Harga" class="form-label">Harga/Hari (Rp)</label>
                            <input type="number" class="form-control @error('Harga') is-invalid @enderror" 
                                   id="Harga" name="Harga" placeholder="Contoh: 100000" required>
                            @error('Harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <a href="{{ route('motor.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
