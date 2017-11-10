@extends('layouts.login')
@section('title')
404 - Не найдено
@endsection
@section('keywords')

@endsection
@section('description')

@endsection
@section('content')
<div class="wrapper">
        <div class="page-header" style="background-image: url('../assets/img/etkplus-bg.jpg');">
            <div class="filter"></div>

        <div class="container">
            <div class="row">
                <h1 class="title"> &nbsp;404 <br>
                    <p class="error-msg">Страница не найдена</p>
                </h1>


            </div>
            <div class="container-cards">
                <div class="row">
                    <h5 class="discover-pages text-center">Попробуйте перейти куда-нибудь еще:</h5>
                    <br><br><br>
                </div>

                <div class="row">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card card-just-text">
                                    <div class="card-body text-center">
                                        <div class="card-icon"><a href="/"><i class="fa fa-building" aria-hidden="true"></i></a></div>
                                        <p class="card-description">На главную</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-hover-effect card-just-text">
                                    <div class="card-body text-center">
                                        <h4 class="card-icon"><a href="/login"><i class="fa fa-desktop" aria-hidden="true"></i></a></h4>
                                        <p class="card-description">Панель управления</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-hover-effect card-just-text">
                                    <div class="card-body text-center">
                                        <h4 class="card-icon"><a href="/categories"><i class="fa fa-list" aria-hidden="true"></i></a></h4>
                                        <p class="card-description">Партнерская сеть</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection
