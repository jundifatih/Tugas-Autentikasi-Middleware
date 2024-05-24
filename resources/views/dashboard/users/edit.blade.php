@extends('layouts.master')
@section('title', 'Edit User')

@section('content')
    <div class="container">
        @if (Session::get('error'))
            <div class="row">
                <div class="col-md-4 offset-4 mt-2 py-2 rounded bg-danger text-white fw-bold">
                    {{ Session::get('error') }}
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-4 offset-4 rounded bg-info mt-3 py-3">
                <h2 class="text-center fw-bold" style="font-size: 20px">Edit Data USer {{ $user->id }}</h2>
                <form class="mt-3"
                    action="{{ route('dashboard.users.update', ['id' => $user->id]) }}"
                    method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="mb-1">
                        <label for="exampleFormControlInput1" class="form-label fw-semibold">Nama User</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            placeholder="Masukkan nama user" value="{{ old('name') ? old('name') : $user->name }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-1">
                        <label for="exampleFormControlInput1" class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            placeholder="Masukkan email user" value="{{ old('email') ? old('email') : $user->email }}">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-1">
                        <label for="exampleFormControlInput1" class="form-label fw-semibold">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                            placeholder="Masukkan password user" value="{{ old('password') }}">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-1">
                        <label for="exampleFormControlInput1" class="form-label fw-semibold">Role</label>
                        <select class="form-select @error('role') is-invalid @enderror" name="role">
                            <option selected disabled>Select Role</option>
                            <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : ($user->role == 'superadmin' ? 'selected' : '') }}>SuperAdmin</option>
                            <option value="user" {{ old('role') == 'user' ? 'selected' : ($user->role == 'user' ? 'selected' : '') }}>User</option>
                        </select>
                        @error('role')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-1">
                        <label for="exampleFormControlInput1" class="form-label fw-semibold">Gender</label>
                        <select class="form-select @error('gender') is-invalid @enderror" name="gender">
                            <option selected disabled>Select Gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : ($user->gender == 'male' ? 'selected' : '') }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : ($user->gender == 'female' ? 'selected' : '') }}>Female</option>
                        </select>
                        @error('gender')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-1">
                        <label for="exampleFormControlInput1" class="form-label fw-semibold">Age</label>
                        <input type="number" class="form-control @error('age') is-invalid @enderror" name="age"
                            placeholder="Masukkan umur user" value="{{ old('age') ? old('age') : $user->age }}">
                        @error('age')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-1">
                        <label for="exampleFormControlInput1" class="form-label fw-semibold">Birth</label>
                        <input type="date" class="form-control @error('birth') is-invalid @enderror" name="birth"
                            placeholder="Masukkan tanggal lahir user" value="{{ old('birth') ? old('birth') : $user->birth }}">
                        @error('birth')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-1">
                        <label for="exampleFormControlInput1" class="form-label fw-semibold">Address</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" name="address"
                            placeholder="Masukkan alamat user" value="{{ old('address') ? old('address') : $user->address }}">
                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="d-flex">
                        <div class="mx-auto">
                            <a href="{{ route('dashboard.products') }}" class="btn btn-warning me-2">
                                Kembali</a>
                            <button class="btn btn-dark mx-auto" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection