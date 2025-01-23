@extends('layouts.app')
@section('content')
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Add UOM</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Add UOM Management
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Harap isi data yang telah ditandai dengan <span
                                class="text-danger bg-light px-1">*</span>, dan
                            masukkan data
                            dengan benar.</h6>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <form action="{{ route('uom.update', $uom['id']) }}" method="POST" id="updateForm">
                            @csrf
                            @method('PUT')
                            <div class="form-container">
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <label for="account_code" class="form-label fw-bold mb-0">Uom <span
                                                class="text-danger"></span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="UoM" name="uom_name" class="form-control"
                                            value="{{ $uom['name'] }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <label for="account_code" class="form-label fw-bold mb-0">Simbol UoM <span
                                                class="text-danger"></span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="Simbol" class="form-control" name="uom_code"
                                            {{-- {{ $uom['symbol'] }} --}} value="" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <label for="account_code" class="form-label fw-bold mb-0">Keterangan UoM <span
                                                class="text-danger"></span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <textarea cols="30" rows="4" name="description" class="form-control" readonly>{{ $uom['description'] }}</textarea>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <a href="{{ route('uom.index') }}" class="btn btn-secondary ms-2">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
