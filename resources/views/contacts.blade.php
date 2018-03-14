@extends('layouts.master')
@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
Контакты
@endsection
@section('content')
<div class="header-wrapper">

    <div class="page-header page-header-xs filter pattern-image" style="background-image: url('../assets/img/etkplus-bg.jpg');">
        <div class="filter filter-info"></div>
        <div class="content-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-center">
                        <h1 class="title">Контакты</h1>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="wrapper">
    <div class="section">
        <div class="container">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 ml-auto mr-auto">
                        <div class="card card-contact no-transition">
                            <h3 class="card-title text-center">Свяжитесь с нами</h3>
                            <div class="row">
                                <div class="col-md-5 ml-auto">
                                    <div class="card-body">
                                        <div class="info info-horizontal">
                                            <div class="icon icon-info">
                                                <i class="nc-icon nc-pin-3" aria-hidden="true"></i>
                                            </div>
                                            <div class="description">
                                                <h4 class="info-title">Адрес</h4>
                                                <p> 428028, г. Чебоксары, пр-кт Тракторостроителей, 6б<br>
                                                    2 этаж
                                                </p>
                                            </div>
                                        </div>
                                        <div class="info info-horizontal">
                                            <div class="icon icon-danger">
                                                <i class="nc-icon nc-badge" aria-hidden="true"></i>
                                            </div>
                                            <div class="description">
                                                <h4 class="info-title">Телефон</h4>
                                                <p> (8352) 36-03-30,<br>
                                                    36-33-30<br>
                                                    Пн - Пт, 8:00-17:00
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 mr-auto">
                                    <form role="form" id="contact-form" method="post">
                                        <div class="card-body">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Как Вас зовут?</label>
                                                <input type="text" name="name" class="form-control" placeholder="Ваше имя">
                                            </div>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Email</label>
                                                <input type="email" name="email" class="form-control" placeholder="Email">
                                            </div>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Сообщение</label>
                                                <textarea name="message" class="form-control" id="message" rows="6" placeholder="Введите Ваше сообщение"></textarea>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="submit" class="btn btn-danger pull-right">Отправить
                                                    </button>
                                                </div><br><br>
                                                </div>
                                            </div>
                                        </form>
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