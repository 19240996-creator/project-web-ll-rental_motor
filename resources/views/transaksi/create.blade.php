@extends('layouts.app')

@section('title', 'Buat Transaksi')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3"><i class="fas fa-plus-circle"></i> Buat Transaksi Baru</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-exchange-alt"></i> Form Input Transaksi
                </div>
                <div class="card-body">
                    <form action="{{ route('transaksi.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group mb-3">
                            <label for="Id_motor" class="form-label">Motor</label>
                            <select class="form-select @error('Id_motor') is-invalid @enderror" id="Id_motor" name="Id_motor" required>
                                <option selected disabled>-- Pilih Motor --</option>
                                @foreach ($motors as $motor)
                                    <option value="{{ $motor->Id_motor }}">
                                        {{ $motor->Merk_motor }} - {{ $motor->Warna_motor }} (Rp {{ number_format($motor->Harga, 0, ',', '.') }}/hari)
                                    </option>
                                @endforeach
                            </select>
                            @error('Id_motor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="Id_admin_rental_motor" class="form-label">Admin</label>
                            <select class="form-select @error('Id_admin_rental_motor') is-invalid @enderror" id="Id_admin_rental_motor" name="Id_admin_rental_motor" required>
                                <option selected disabled>-- Pilih Admin --</option>
                                @foreach ($admins as $admin)
                                    <option value="{{ $admin->Id_admin_rental_motor }}">{{ $admin->Nama_admin }}</option>
                                @endforeach
                            </select>
                            @error('Id_admin_rental_motor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="Tanggal_sewa" class="form-label">Tanggal Sewa</label>
                            <input type="date" class="form-control @error('Tanggal_sewa') is-invalid @enderror" 
                                   id="Tanggal_sewa" name="Tanggal_sewa" required>
                            @error('Tanggal_sewa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="Tanggal_kembali" class="form-label">Tanggal Kembali</label>
                            <input type="date" class="form-control @error('Tanggal_kembali') is-invalid @enderror" 
                                   id="Tanggal_kembali" name="Tanggal_kembali" required>
                            @error('Tanggal_kembali')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
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
