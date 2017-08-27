@extends('layouts.login')
@section('title')
Вход
@endsection
@section('keywords')

@endsection
@section('description')

@endsection
@section('content')
<div class="wrapper">
        <div class="page-header" style="background-image: url('../assets/img/sections/bruno-abatti.jpg');">
            <div class="filter"></div>
            <div class="container">
                    <div class="row">
                        <div class="col-md-4 offset-md-4 col-sm-6 offset-sm-3 col-10 offset-1 ">
                            <div class="card card-register">
                                <h3 class="card-title">Вход</h3>
                                <form class="register-form" method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control no-border" placeholder="Email">

                                    <label>Пароль</label>
                                    <input type="password" name="password" class="form-control no-border" placeholder="Пароль">
                                    <button type="submit"    class="btn btn-danger btn-block btn-round">Войти</button>
                                </form>
                                <div class="forgot">
                                    <a href="#paper-kit" class="btn btn-link btn-danger">Напомнить пароль</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
        </div>
    </div>
@endsection
