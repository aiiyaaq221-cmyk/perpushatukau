@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/profil.css') }}">
@endsection


@section('content')

<div class="profile-container">

    <div class="page-header-card">
        <div>
            <h2 class="page-title">
                👤 Profil Admin
            </h2>
            <p class="page-subtitle">
                Kelola informasi akun administrator
            </p>
        </div>
    </div>

    <div class="row">

        <!-- FOTO -->
        <div class="col-lg-4 mb-4">
            <div class="profile-card">

                <div class="profile-image-wrapper">

                    @if(auth()->user()->foto)
                        <img src="{{ asset('storage/'.auth()->user()->foto) }}"
                             class="profile-image">
                    @else
                        <img src="{{ asset('images/default-user.png') }}"
                             class="profile-image">
                    @endif

                </div>

                <h4 class="mt-3 fw-bold">
                    {{ auth()->user()->name }}
                </h4>

                <p class="text-muted">
                    Administrator
                </p>

                <form action="{{ route('profil.update') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <input type="file"
                           name="foto"
                           class="form-control modern-input mb-3">

                    <button class="btn btn-upload">
                        Upload Foto Baru
                    </button>

            </div>
        </div>

        <!-- INFORMASI -->
        <div class="col-lg-8">
            <div class="profile-card">

                <h5 class="section-title">
                    Informasi Profil
                </h5>

                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text"
                           name="name"
                           value="{{ auth()->user()->name }}"
                           class="form-control modern-input">
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email"
                           name="email"
                           value="{{ auth()->user()->email }}"
                           class="form-control modern-input">
                </div>

                <button class="btn btn-save-profile">
                    Simpan Perubahan
                </button>

                </form>

            </div>

            <!-- PASSWORD -->
            <div class="profile-card mt-4">

                <h5 class="section-title">
                    Ubah Kata Sandi
                </h5>

                <form action="{{ route('profil.password') }}"
                      method="POST">

                    @csrf

                    <div class="mb-3">
                        <label>Password Lama</label>
                        <input type="password"
                               name="password_lama"
                               class="form-control modern-input">
                    </div>

                    <div class="mb-3">
                        <label>Password Baru</label>
                        <input type="password"
                               name="password_baru"
                               class="form-control modern-input">
                    </div>

                    <div class="mb-3">
                        <label>Konfirmasi Password Baru</label>
                        <input type="password"
                               name="password_baru_confirmation"
                               class="form-control modern-input">
                    </div>

                    <button class="btn btn-change-password">
                        Ubah Password
                    </button>

                </form>

            </div>
        </div>

    </div>

</div>

@endsection