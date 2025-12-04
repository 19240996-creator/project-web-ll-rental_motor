@extends('layouts.app')

@section('title', 'Data Pengembalian')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3"><i class="fas fa-undo"></i> Data Pengembalian</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('pengembalian.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Catat Pengembalian
            </a>
        </div>
    </div>

    <div class="table-container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Pengembalian</th>
                    <th>ID Transaksi</th>
                    <th>Tanggal Pengembalian</th>
                    <th>Biaya Keterlambatan</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengembalians as $key => $pengembalian)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td><strong>{{ $pengembalian->Id_pengembalian }}</strong></td>
                        <td>{{ $pengembalian->Id_transaksi }}</td>
                        <td>{{ $pengembalian->Tanggal_pengembalian }}</td>
                        <td>Rp {{ number_format($pengembalian->Biaya_keterlambatan, 0, ',', '.') }}</td>
                        <td>{{ $pengembalian->Catatan ?? '-' }}</td>
                        <td>
                            <form action="{{ route('pengembalian.destroy', $pengembalian->Id_pengembalian) }}" method="POST" style="display:inline;">
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
                        <td colspan="7" class="text-center text-muted">Tidak ada data pengembalian</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
