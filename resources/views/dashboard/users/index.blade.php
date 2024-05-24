@extends('layouts.master')
@section('title', 'Manage User')

@section('content')
    <div class="container mt-lg-4 mb-lg-3">
        <div class="row bg-info rounded px-3 py-3 w-100">
            <div class="d-flex justify-content-between">
                <h2 class="fw-semibold">List User</h2>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('dashboard.users.add') }}" class="btn btn-md btn-dark fw-bold my-auto me-1">Tambah User</a>
                </div>
            </div>

            @if (Session::get('success'))
                <div class="alert alert-success mt-3">
                    {{ Session::get('success') }}
                </div>
            @endif

            @if (Session::get('error'))
                <div class="alert alert-danger mt-3">
                    {{ Session::get('error') }}
                </div>
            @endif

            <table class="table table-striped w-100 mt-3">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col" class="text-center">Nama</th>
                        <th scope="col" class="text-center">Gender</th>
                        <th scope="col" class="text-center">Umur</th>
                        <th scope="col" class="text-center">Tanggal Lahir</th>
                        <th scope="col" class="text-center">Alamat</th>
                        <th scope="col" class="text-center" style="width: 150px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $user->name }}</td>
                            @if ($user->gender == 'male')
                                <td class="text-center"><div
                                        class="rounded px-3 py-1 bg-success w-50 mx-auto">{{ $user->gender }}</div></td>
                            @else
                                <td class="text-center"><div
                                        class="rounded px-3 py-1 bg-dark text-white w-50 mx-auto">{{ $user->gender }}</div></td>
                            @endif
                            <td class="text-center">{{ $user->age }}</td>
                            <td class="text-center">{{ $user->birth }}</td>
                            <td class="text-center">{{ $user->address }}</td>
                            <td class="d-flex">
                                <a href="{{ route('dashboard.users.edit', ['id' => $user->id]) }}"
                                    class="btn btn-warning btn-sm">Update</a>
                                <form action="{{ route('dashboard.users.delete', ['id' => $user->id]) }}" method="POST"
                                    class="ms-1">
                                    @csrf()
                                    <button class="btn btn-sm btn-danger" type="submit" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection