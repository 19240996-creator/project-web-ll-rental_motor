@extends('layouts.app')

@section('title', 'Data Transaksi')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3"><i class="fas fa-exchange-alt"></i> Data Transaksi</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('transaksi.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Buat Transaksi
            </a>
        </div>
    </div>

    <div class="table-container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Transaksi</th>
                    <th>User</th>
                    <th>Motor</th>
                    <th>Admin</th>
                    <th>Tgl Sewa</th>
                    <th>Tgl Kembali</th>
                    <th>Biaya</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksis as $key => $transaksi)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td><strong>{{ $transaksi->Id_transaksi }}</strong></td>
                        <td>{{ $transaksi->user->name ?? '-' }}</td>
                        <td>{{ $transaksi->motor->Merk_motor ?? '-' }} - {{ $transaksi->motor->Warna_motor ?? '-' }}</td>
                        <td>{{ $transaksi->admin->Nama_admin ?? '-' }}</td>
                        <td>{{ $transaksi->Tanggal_sewa }}</td>
                        <td>{{ $transaksi->Tanggal_kembali }}</td>
                        <td>Rp {{ number_format($transaksi->Total_biaya, 0, ',', '.') }}</td>
                        <td>
                            @if ($transaksi->Status_sewa === 'Proses')
                                <span class="badge badge-secondary">Proses</span>
                            @elseif ($transaksi->Status_sewa === 'Aktif')
                                <span class="badge badge-info">Aktif</span>
                            @elseif ($transaksi->Status_sewa === 'Selesai')
                                <span class="badge badge-success">Selesai</span>
                            @else
                                <span class="badge badge-danger">Batal</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('transaksi.edit', $transaksi->Id_transaksi) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('transaksi.destroy', $transaksi->Id_transaksi) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted">Tidak ada data transaksi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
