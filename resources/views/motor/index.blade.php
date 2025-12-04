@extends('layouts.app')

@section('title', 'Data Motor')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3"><i class="fas fa-motorcycle"></i> Data Motor</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('motor.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Motor
            </a>
        </div>
    </div>

    <div class="table-container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Motor</th>
                    <th>Merk</th>
                    <th>Warna</th>
                    <th>Plat Nomor</th>
                    <th>Tahun</th>
                    <th>Harga/Hari</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($motors as $key => $motor)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td><strong>{{ $motor->Id_motor }}</strong></td>
                        <td>{{ $motor->Merk_motor }}</td>
                        <td>{{ $motor->Warna_motor }}</td>
                        <td>{{ $motor->Plat_nomor ?? '-' }}</td>
                        <td>{{ $motor->Tahun_motor }}</td>
                        <td>Rp {{ number_format($motor->Harga, 0, ',', '.') }}</td>
                        <td>
                            @if ($motor->Status_motor === 'Tersedia')
                                <span class="badge badge-success">Tersedia</span>
                            @elseif ($motor->Status_motor === 'Disewa')
                                <span class="badge badge-danger">Disewa</span>
                            @else
                                <span class="badge badge-warning">Maintenance</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('motor.edit', $motor->Id_motor) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('motor.destroy', $motor->Id_motor) }}" method="POST" style="display:inline;">
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
                        <td colspan="9" class="text-center text-muted">Tidak ada data motor</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
