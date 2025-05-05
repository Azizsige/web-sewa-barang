@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <h1>Edit Admin</h1>

  <form method="POST" action="{{ route('admin-users.update', $admin) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label for="name" class="form-label">Nama</label>
      <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $admin->name) }}" required>
      @error('name')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
        value="{{ old('email', $admin->email) }}" required>
      @error('email')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Password (kosongkan jika tidak ingin mengubah)</label>
      <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
      @error('password')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="role" class="form-label">Role</label>
      <input type="text" name="role" id="role" class="form-control" value="admin" readonly>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('admin-users.index') }}" class="btn btn-secondary">Batal</a>
  </form>
</div>
@endsection