@extends('layouts.mainlayout')

@section('content')
    <div class="container mt-5">
        <div class="text-center" style="padding-top: 20px;">
            <h2>My Profile</h2>
        </div>

        <div class="text-center" style="margin-bottom: 40px;">
            <img src="assets/images/profile.jpg" alt="Profile Picture" class="rounded-circle" style="width:350px;">
        </div>

        <form action="#" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Foto Upload -->
            <div class="form-group mb-4">
                <input type="file" id="profile_picture" width="10px" name="profile_picture" class="form-control">
            </div>

            <!-- Nama & Username sejajar -->
            <div class="form-group d-flex mb-4">
                <div class="mr-3" style="flex: 1; padding-right: 15px;">
                    <label for="name">Nama</label>
                    <input type="text" id="name" name="name"
                        value="{{ Session::get('user_info')['username'] ?? 'Guest' }}" class="form-control">
                </div>
                <div style="flex: 1; padding-left: 15px;">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username"
                        value="{{ Session::get('user_info')['username'] ?? 'Guest' }}" class="form-control">
                </div>
            </div>

            <!-- Email & Telepon sejajar -->
            <div class="form-group d-flex mb-4">
                <div class="mr-3" style="flex: 1; padding-right: 15px;">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control">
                </div>
                <div style="flex: 1; padding-left: 15px;">
                    <label for="phone">Telepon</label>
                    <input type="text" id="phone" name="phone" class="form-control">
                </div>
            </div>

            <!-- Alamat -->
            <div class="form-group mb-4">
                <label for="address">Alamat</label>
                <textarea id="address" name="address" class="form-control" rows="4"></textarea>
            </div>

            <!-- Password & Konfirmasi Password sejajar -->
            <div class="form-group d-flex mb-4">
                <div class="mr-3" style="flex: 1; padding-right: 15px;">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control">
                </div>
                <div style="flex: 1; padding-left: 15px;">
                    <label for="confirm_password">Konfirmasi Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control">
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-4" style="float: right">Save</button>
        </form>
    </div>
@endsection
