@extends('layouts.app')

@section('title', 'Edit Motor')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3"><i class="fas fa-edit"></i> Edit Motor</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-motorcycle"></i> Form Edit Motor
                </div>
                <div class="card-body">
                    <form action="{{ route('motor.update', $motor->Id_motor) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group mb-3">
                            <label for="Id_motor" class="form-label">ID Motor</label>
                            <input type="text" class="form-control" id="Id_motor" value="{{ $motor->Id_motor }}" disabled>
                        </div>

                        <div class="form-group mb-3">
                            <label for="Merk_motor" class="form-label">Merk Motor</label>
                            <input type="text" class="form-control @error('Merk_motor') is-invalid @enderror" 
                                   id="Merk_motor" name="Merk_motor" value="{{ $motor->Merk_motor }}" required>
                            @error('Merk_motor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="Warna_motor" class="form-label">Warna Motor</label>
                            <input type="text" class="form-control @error('Warna_motor') is-invalid @enderror" 
                                   id="Warna_motor" name="Warna_motor" value="{{ $motor->Warna_motor }}" required>
                            @error('Warna_motor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="Tahun_motor" class="form-label">Tahun Motor</label>
                            <input type="text" class="form-control @error('Tahun_motor') is-invalid @enderror" 
                                   id="Tahun_motor" name="Tahun_motor" value="{{ $motor->Tahun_motor }}" required>
                            @error('Tahun_motor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="Harga" class="form-label">Harga/Hari (Rp)</label>
                            <input type="number" class="form-control @error('Harga') is-invalid @enderror" 
                                   id="Harga" name="Harga" value="{{ $motor->Harga }}" required>
                            @error('Harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Update
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
