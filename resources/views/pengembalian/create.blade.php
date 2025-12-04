@extends('layouts.app')

@section('title', 'Catat Pengembalian')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3"><i class="fas fa-plus-circle"></i> Catat Pengembalian</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-undo"></i> Form Input Pengembalian
                </div>
                <div class="card-body">
                    <form action="{{ route('pengembalian.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group mb-3">
                            <label for="Id_pengembalian" class="form-label">ID Pengembalian</label>
                            <input type="text" class="form-control @error('Id_pengembalian') is-invalid @enderror" 
                                   id="Id_pengembalian" name="Id_pengembalian" placeholder="Contoh: PGM001" required>
                            @error('Id_pengembalian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="Id_transaksi" class="form-label">Transaksi</label>
                            <select class="form-select @error('Id_transaksi') is-invalid @enderror" id="Id_transaksi" name="Id_transaksi" required>
                                <option selected disabled>-- Pilih Transaksi --</option>
                                @foreach ($transaksis as $transaksi)
                                    <option value="{{ $transaksi->Id_transaksi }}">
                                        {{ $transaksi->Id_transaksi }} - {{ $transaksi->user->name }} ({{ $transaksi->motor->Merk_motor }})
                                    </option>
                                @endforeach
                            </select>
                            @error('Id_transaksi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="Tanggal_pengembalian" class="form-label">Tanggal Pengembalian</label>
                            <input type="date" class="form-control @error('Tanggal_pengembalian') is-invalid @enderror" 
                                   id="Tanggal_pengembalian" name="Tanggal_pengembalian" required>
                            @error('Tanggal_pengembalian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="Biaya_keterlambatan" class="form-label">Biaya Keterlambatan (Rp)</label>
                            <input type="number" class="form-control @error('Biaya_keterlambatan') is-invalid @enderror" 
                                   id="Biaya_keterlambatan" name="Biaya_keterlambatan" value="0" min="0">
                            @error('Biaya_keterlambatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="Catatan" class="form-label">Catatan</label>
                            <textarea class="form-control @error('Catatan') is-invalid @enderror" 
                                      id="Catatan" name="Catatan" rows="3" placeholder="Catatan tambahan (opsional)"></textarea>
                            @error('Catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <a href="{{ route('pengembalian.index') }}" class="btn btn-secondary">
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
