@extends('layouts.app')

@section('title', 'Edit Admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3"><i class="fas fa-edit"></i> Edit Admin</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-tie"></i> Form Edit Admin
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.update', $admin->Id_admin_rental_motor) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group mb-3">
                            <label for="Id_admin_rental_motor" class="form-label">ID Admin</label>
                            <input type="text" class="form-control" id="Id_admin_rental_motor" value="{{ $admin->Id_admin_rental_motor }}" disabled>
                        </div>

                        <div class="form-group mb-3">
                            <label for="Nama_admin" class="form-label">Nama Admin</label>
                            <input type="text" class="form-control @error('Nama_admin') is-invalid @enderror" 
                                   id="Nama_admin" name="Nama_admin" value="{{ $admin->Nama_admin }}" required>
                            @error('Nama_admin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="No_telp" class="form-label">No Telepon</label>
                            <input type="text" class="form-control @error('No_telp') is-invalid @enderror" 
                                   id="No_telp" name="No_telp" value="{{ $admin->No_telp }}" required>
                            @error('No_telp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="Alamat" class="form-label">Alamat</label>
                            <textarea class="form-control @error('Alamat') is-invalid @enderror" 
                                      id="Alamat" name="Alamat" rows="4" required>{{ $admin->Alamat }}</textarea>
                            @error('Alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Update
                            </button>
                            <a href="{{ route('admin.index') }}" class="btn btn-secondary">
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
