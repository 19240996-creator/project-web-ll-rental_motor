@extends('layouts.app')

@section('title', 'Data Admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3"><i class="fas fa-user-tie"></i> Data Admin</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Admin
            </a>
        </div>
    </div>

    <div class="table-container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Admin</th>
                    <th>Nama</th>
                    <th>No Telepon</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($admins as $key => $admin)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td><strong>{{ $admin->Id_admin_rental_motor }}</strong></td>
                        <td>{{ $admin->Nama_admin }}</td>
                        <td>{{ $admin->No_telp }}</td>
                        <td>{{ $admin->Alamat }}</td>
                        <td>
                            <a href="{{ route('admin.edit', $admin->Id_admin_rental_motor) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.destroy', $admin->Id_admin_rental_motor) }}" method="POST" style="display:inline;">
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
                        <td colspan="6" class="text-center text-muted">Tidak ada data admin</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
