@extends('layouts.master')
@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
Партнерская сеть
@endsection
@section('content')
<div class="wrapper">

    <div class="page-header page-header-small filter pattern-image" style="background-image: url('../assets/img/sections/etkplus-bg2.jpg');">
        <div class="filter filter-danger"></div>
        <div class="content-center">
            <div class="container">
                <h2 class="presentation-subtitle text-center">Партнерская сеть</h3>
                </div>
            </div>
        </div>
        <div class="filter filter-danger"></div>
        </div>
            <div class="container">
            <div class="info-areas">
                                <div class="row">
                    @foreach ($categories as $category)
                    <div class="col-md-3">
                     <div class="info">
                        <div class="icon">
                        <a href="{{ route('site.show-category.get', ['id' => $category->id]) }}">
                            <i class="material-icons">{{ $category->icon }}</i>
                        </a>
                        </div>
                        <div class="description">
                        <a href="{{ route('site.show-category.get', ['id' => $category->id]) }}">
                                <h4 class="info-title"> {{ $category->name }} </h4>
                                </a>
                            <p>{{ $category->description }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            </div>

        </div>
</div>
@endsection