@extends('layouts.mainlayout')
@section('content')
    <div class="container bg-white mt-3">
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000" style="height: 100px">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="..." class="d-block w-100" alt="lorem">
                </div>
                <div class="carousel-item">
                    <img src="..." class="d-block w-100" alt="ipsum">
                </div>
                <div class="carousel-item">
                    <img src="..." class="d-block w-100" alt="dolor">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true" style="filter: brightness(0);"></span>
                <span class="text-white">Informasi </span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true" style="filter: brightness(0);"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
@endsection
