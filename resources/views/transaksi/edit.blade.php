@extends('layouts.app')

@section('title', 'Edit Transaksi')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3"><i class="fas fa-edit"></i> Edit Transaksi</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-exchange-alt"></i> Form Edit Transaksi
                </div>
                <div class="card-body">
                    <form action="{{ route('transaksi.update', $transaksi->Id_transaksi) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group mb-3">
                            <label for="Status_sewa" class="form-label">Status Sewa</label>
                            <select class="form-select @error('Status_sewa') is-invalid @enderror" id="Status_sewa" name="Status_sewa" required>
                                <option value="Proses" {{ $transaksi->Status_sewa === 'Proses' ? 'selected' : '' }}>Proses</option>
                                <option value="Aktif" {{ $transaksi->Status_sewa === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Selesai" {{ $transaksi->Status_sewa === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Batal" {{ $transaksi->Status_sewa === 'Batal' ? 'selected' : '' }}>Batal</option>
                            </select>
                            @error('Status_sewa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Informasi Transaksi</label>
                            <div class="bg-light p-3 rounded">
                                <p><strong>ID Transaksi:</strong> {{ $transaksi->Id_transaksi }}</p>
                                <p><strong>User:</strong> {{ $transaksi->user->name }}</p>
                                <p><strong>Motor:</strong> {{ $transaksi->motor->Merk_motor }} - {{ $transaksi->motor->Warna_motor }}</p>
                                <p><strong>Tanggal Sewa:</strong> {{ $transaksi->Tanggal_sewa }}</p>
                                <p><strong>Tanggal Kembali:</strong> {{ $transaksi->Tanggal_kembali }}</p>
                                <p><strong>Total Biaya:</strong> Rp {{ number_format($transaksi->Total_biaya, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Update
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
