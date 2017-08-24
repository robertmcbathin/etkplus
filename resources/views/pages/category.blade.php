@extends('layouts.master')
@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
{{ $category_name->name }}
@endsection
@section('content')
<div class="wrapper">

    <div class="page-header page-header-small filter pattern-image" style="background-image: url('../assets/img/sections/etkplus-bg2.jpg');">
        <div class="filter filter-danger"></div>
        <div class="content-center">
            <div class="container">
                <h2 class="presentation-subtitle text-center">{{ $category_name->name }}</h2>
                </div>
            </div>
        </div>
        <div class="filter filter-danger"></div>
        </div>
        <div class="section">
            <div class="container">
                <h3>Новые партнеры в нашей сети</h3>
                <br>
                <div class="row items-row">
                    @foreach ($partners as $partner)
                    <div class="col-md-4  col-sm-4">
                        <div class="card card-plain">

                            <div class="card-image">
                                <a href="{{ route('site.show-partner.get',['id' => $partner->id]) }}">
                                    <img src="{{ $partner->thumbnail }}" alt="{{ $partner->name }}" class="img-rounded img-responsive">
                                </a>
                                <div class="card-block">
                                    <a href="{{ route('site.show-partner.get',['id' => $partner->id]) }}">
                                        <div class="author">
                                            <img src="{{ $partner->logo }}" alt="{{ $partner->name }}" class="img-circle img-no-padding img-responsive img-raised">
                                        </div>
                                        <span class="name">{{ $partner->name }}</span>
                                    </a>
                                    <div class="meta"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="row items-row">
                    <div class="col-md-4 col-sm-4">
                        <div class="card card-plain text-center">
                            <div class="card-image">
                                <a href="#paper-kit">
                                    <img src="../assets/img/sections/por7o.jpg" alt="Rounded Image" class="img-rounded img-responsive">
                                </a>
                                <div class="card-block details-center">
                                    <a href="#paper-kit">
                                        <div class="author">
                                            <img src="../assets/img/faces/erik-lucatero-2.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                            <div class="text">
                                                <span class="name">Tom Hanks</span>
                                                <div class="meta">Drawn on 23 Jan</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <div class="card card-plain text-center">
                            <div class="card-image">
                                <a href="#paper-kit">
                                    <img src="../assets/img/sections/vincent-versluis.jpg" alt="Rounded Image" class="img-rounded img-responsive">
                                </a>
                                <div class="card-block details-center">
                                    <a href="#paper-kit">
                                        <div class="author">
                                            <img src="../assets/img/chet_faker_2.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                            <div class="text">
                                                <span class="name">Chet Faker</span>
                                                <div class="meta">Drawn on 20 Jan</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row items-row">
                    <div class="col-md-4 offset-md-1 col-sm-6">
                        <div class="card card-plain text-center">
                            <div class="card-image">
                                <a href="#paper-kit">
                                    <img src="../assets/img/sections/ilya-yakover.jpg" alt="Rounded Image" class="img-rounded img-responsive">
                                </a>
                                <div class="card-block details-center">
                                    <a href="#paper-kit">
                                        <div class="author">
                                            <img src="../assets/img/faces/ayo-ogunseinde-2.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                            <div class="text">
                                                <span class="name">Tom Hank</span>
                                                <div class="meta">Drawn on 23 Jan</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card card-plain text-center">
                            <div class="card-image">
                                <a href="#paper-kit">
                                    <img src="../assets/img/sections/miguel-perales.jpg" alt="Rounded Image" class="img-rounded img-responsive">
                                </a>
                                <div class="card-block details-center">
                                    <a href="#paper-kit">
                                        <div class="author">
                                            <img src="../assets/img/faces/clem-onojeghuo-2.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                            <div class="text">
                                                <span class="name">Tom Banks</span>
                                                <div class="meta">Drawn on 23 Jan</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 hidden-sm">
                        <div class="card card-plain text-center">
                            <div class="card-image">
                                <a href="#paper-kit">
                                    <img src="../assets/img/sections/neill-kumar.jpg" alt="Rounded Image" class="img-rounded img-responsive">
                                </a>
                                <div class="card-block details-center">
                                    <a href="#paper-kit">
                                        <div class="author">
                                            <img src="../assets/img/flume.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                            <div class="text">
                                                <span class="name">Flume</span>
                                                <div class="meta">Drawn on 4 Aug</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row items-row">
                    <div class="col-md-2 offset-md-1 col-sm-6">
                        <div class="card card-plain text-center">
                            <div class="card-image">
                                <a href="#paper-kit">
                                    <img src="../assets/img/sections/john-towner.jpg" alt="Rounded Image" class="img-rounded img-responsive">
                                </a>
                                <div class="card-block details-center">
                                    <a href="#paper-kit">
                                        <div class="author">
                                            <img src="../assets/img/placeholder.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                            <div class="text">
                                                <span class="name">Tom Hanks</span>
                                                <div class="meta">Drawn on 23 Jan</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="card card-plain text-center">
                            <div class="card-image">
                                <a href="#paper-kit">
                                    <img src="../assets/img/sections/leonard-cotte.jpg" alt="Rounded Image" class="img-rounded img-responsive">
                                </a>
                                <div class="card-block details-center">
                                    <a href="#paper-kit">
                                        <div class="author">
                                            <img src="../assets/img/placeholder.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                            <div class="text">
                                                <span class="name">Banks</span>
                                                <div class="meta">Drawn on 3 Mar</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="card card-plain text-center">
                            <div class="card-image">
                                <a href="#paper-kit">
                                    <img src="../assets/img/sections/anders-jilden.jpg" alt="Rounded Image" class="img-rounded img-responsive">
                                </a>
                                <div class="card-block details-center">
                                    <a href="#paper-kit">
                                        <div class="author">
                                            <img src="../assets/img/faces/erik-lucatero-2.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                            <div class="text">
                                                <span class="name">Tom Hanks</span>
                                                <div class="meta">Drawn on 23 Jan</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 offset-md-4 text-center">
                        <div class="preloader">
                            <div class="uil-reload-css" style=""><div></div></div> <h5>Loading More  </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection