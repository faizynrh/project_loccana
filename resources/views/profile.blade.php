@extends('layouts.app')
@section('content')
    <div id="main-content">
        @php
            $username = Session::get('user_info')['username'];
            $initial = strtoupper(substr($username, 0, 1));
            $colors = ['#FF5733', '#33A1FF', '#FF33A8', '#33FF57', '#A833FF', '#FFC733'];
            $bgColor = $colors[ord($initial) % count($colors)];
        @endphp

        <div class="row">
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-body text-center">
                        <div class="position-relative mx-auto mb-4">
                            <div class="profile-picture-container position-relative"
                                style="width: 180px; height: 180px; margin: 0 auto;">
                                <div id="default-profile"
                                    class="rounded-circle shadow d-flex align-items-center justify-content-center"
                                    style="width: 180px; height: 180px; background-color: {{ $bgColor }};
                                    font-size: 65px; font-weight: bold; color: white; cursor: pointer;">
                                    {{ $initial }}
                                </div>
                                <img id="profile-image" class="rounded-circle shadow object-fit-cover"
                                    style="width: 180px; height: 180px; display: none; cursor: pointer;"
                                    alt="Profile Picture">
                                <div id="profile-overlay"
                                    class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 rounded-circle d-none">
                                    <div class="d-flex flex-column h-100 justify-content-center align-items-center">
                                        <button class="btn btn-sm btn-light mb-2" id="btn-change-photo">
                                            <i class="bi bi-camera-fill me-1"></i> Ganti Foto
                                        </button>
                                        <button class="btn btn-sm btn-danger" id="btn-remove-photo">
                                            <i class="bi bi-trash-fill me-1"></i> Hapus Foto
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <input type="file" id="profile_picture" name="profile_picture" accept="image/*"
                                class="d-none">
                        </div>

                        <h4 class="mb-1">{{ $username }}</h4>
                        <p class="text-muted mb-3">Admin</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Informasi Profil</h5>
                    </div>
                    <div class="card-body">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <input type="text" id="name" name="name" value="{{ $username }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" id="username" name="username" value="{{ $username }}"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="email" id="email" name="email" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Telepon</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                        <input type="text" id="phone" name="phone" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                    <textarea id="address" name="address" class="form-control" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="row" id="password-section">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password Baru</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                        <input type="password" id="password" name="password" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-check-circle"></i></span>
                                        <input type="password" id="confirm_password" name="confirm_password"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <button type="submit" class="btn btn-primary"> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            const $profileContainer = $('.profile-picture-container');
            const $defaultProfile = $('#default-profile');
            const $profileImage = $('#profile-image');
            const $profileOverlay = $('#profile-overlay');
            const $fileInput = $('#profile_picture');
            const $btnChangePhoto = $('#btn-change-photo');
            const $btnRemovePhoto = $('#btn-remove-photo');

            $profileContainer.on('mouseenter', function() {
                $profileOverlay.removeClass('d-none');
            });

            $profileContainer.on('mouseleave', function() {
                $profileOverlay.addClass('d-none');
            });

            $btnChangePhoto.on('click', function() {
                $fileInput.trigger('click');
            });

            $fileInput.on('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        $profileImage.attr('src', e.target.result);
                        $profileImage.show();
                        $defaultProfile.hide();
                    }

                    reader.readAsDataURL(this.files[0]);
                }
            });

            $btnRemovePhoto.on('click', function() {
                $fileInput.val('');
                $profileImage.attr('src', '');
                $profileImage.hide();
                $defaultProfile.show();
                $profileOverlay.addClass('d-none');
            });

            $profileContainer.on('click', function(e) {
                if (!$(e.target).is($btnChangePhoto) && !$(e.target).is($btnRemovePhoto)) {
                    $profileOverlay.toggleClass('d-none');
                }
            });
        });
    </script>
@endpush
