@extends('layouts.dashboard.master')

@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
Чат
@endsection
@section('content')
<div class="wrapper">
    @include('includes.dashboard.sidebar')
    <div class="main-panel">
        @include('includes.dashboard.top_nav')
        <div class="content">
            <div class="container-fluid">
                @include('includes/notifications')
                @isset($partner_id)

                @endisset
                <div class="col-md-12">
                    <div class="card card-chat">
                                <div class="card-header">
                                    <h4 class="card-title">Чат</h4>
                                    <p class="category">With Tania Andrew</p>
                                </div>
                                <div class="card-content" style="overflow-y: scroll;">
                                    <ol class="chat">
                                        <li class="other">
                                            <div class="avatar">
                                              <img src="../../assets/img/faces/face-2.jpg" alt="crash">
                                          </div>
                                            <div class="msg">
                                                <p>
                                                    Hola!
                                                    How are you?
                                                </p>
                                                <div class="card-footer">
                                                    <i class="ti-check"></i>
                                                    <h6>11:20</h6>
                                                </div>
                                          </div>
                                        </li>
                                        <li class="self">
                                            <div class="msg">
                                                <p>
                                                    Puff...
                                                    I'm alright. How are you?
                                                </p>
                                                <div class="card-footer">
                                                    <i class="ti-check"></i>
                                                    <h6>11:22</h6>
                                                </div>
                                            </div>
                                            <div class="avatar">
                                                <img src="../../assets/img/default-avatar.png" alt="crash">
                                            </div>
                                        </li>
                                        <li class="other">
                                            <div class="avatar">
                                                <img src="../../assets/img/faces/face-2.jpg" alt="crash">
                                            </div>
                                            <div class="msg">
                                                <p>
                                                    I'm ok too!
                                                </p>
                                                <div class="card-footer">
                                                    <i class="ti-check"></i>
                                                    <h6>11:24</h6>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="self">
                                            <div class="msg">
                                                <p>
                                                    Well, it was nice hearing from you.
                                                </p>
                                                <div class="card-footer">
                                                    <i class="ti-check"></i>
                                                    <h6>11:25</h6>
                                                </div>
                                            </div>
                                            <div class="no-avatar"></div>
                                        </li>
                                        <li class="self">
                                            <div class="msg">
                                                <p>
                                                    OK, bye-bye
                                                    See you!
                                                </p>
                                                <div class="card-footer">
                                                    <i class="ti-check"></i>
                                                    <h6>11:25</h6>
                                                </div>
                                            </div>
                                            <div class="avatar">
                                                <img src="../../assets/img/default-avatar.png" alt="crash">
                                            </div>
                                        </li>
                                                                                <li class="self">
                                            <div class="msg">
                                                <p>
                                                    Well, it was nice hearing from you.
                                                </p>
                                                <div class="card-footer">
                                                    <i class="ti-check"></i>
                                                    <h6>11:25</h6>
                                                </div>
                                            </div>
                                            <div class="no-avatar"></div>
                                        </li>
                                        <li class="self">
                                            <div class="msg">
                                                <p>
                                                    OK, bye-bye
                                                    See you!
                                                </p>
                                                <div class="card-footer">
                                                    <i class="ti-check"></i>
                                                    <h6>11:25</h6>
                                                </div>
                                            </div>
                                            <div class="avatar">
                                                <img src="../../assets/img/default-avatar.png" alt="crash">
                                            </div>
                                        </li>
                                                                                <li class="self">
                                            <div class="msg">
                                                <p>
                                                    Well, it was nice hearing from you.
                                                </p>
                                                <div class="card-footer">
                                                    <i class="ti-check"></i>
                                                    <h6>11:25</h6>
                                                </div>
                                            </div>
                                            <div class="no-avatar"></div>
                                        </li>
                                        <li class="self">
                                            <div class="msg">
                                                <p>
                                                    OK, bye-bye
                                                    See you!
                                                </p>
                                                <div class="card-footer">
                                                    <i class="ti-check"></i>
                                                    <h6>11:25</h6>
                                                </div>
                                            </div>
                                            <div class="avatar">
                                                <img src="../../assets/img/default-avatar.png" alt="crash">
                                            </div>
                                        </li>
                                                                                <li class="self">
                                            <div class="msg">
                                                <p>
                                                    Well, it was nice hearing from you.
                                                </p>
                                                <div class="card-footer">
                                                    <i class="ti-check"></i>
                                                    <h6>11:25</h6>
                                                </div>
                                            </div>
                                            <div class="no-avatar"></div>
                                        </li>
                                        <li class="self">
                                            <div class="msg">
                                                <p>
                                                    OK, bye-bye
                                                    See you!
                                                </p>
                                                <div class="card-footer">
                                                    <i class="ti-check"></i>
                                                    <h6>11:25</h6>
                                                </div>
                                            </div>
                                            <div class="avatar">
                                                <img src="../../assets/img/default-avatar.png" alt="crash">
                                            </div>
                                        </li>
                                                                                <li class="self">
                                            <div class="msg">
                                                <p>
                                                    Well, it was nice hearing from you.
                                                </p>
                                                <div class="card-footer">
                                                    <i class="ti-check"></i>
                                                    <h6>11:25</h6>
                                                </div>
                                            </div>
                                            <div class="no-avatar"></div>
                                        </li>
                                        <li class="self">
                                            <div class="msg">
                                                <p>
                                                    OK, bye-bye
                                                    See you!
                                                </p>
                                                <div class="card-footer">
                                                    <i class="ti-check"></i>
                                                    <h6>11:25</h6>
                                                </div>
                                            </div>
                                            <div class="avatar">
                                                <img src="../../assets/img/default-avatar.png" alt="crash">
                                            </div>
                                        </li>
                                                                                <li class="self">
                                            <div class="msg">
                                                <p>
                                                    Well, it was nice hearing from you.
                                                </p>
                                                <div class="card-footer">
                                                    <i class="ti-check"></i>
                                                    <h6>11:25</h6>
                                                </div>
                                            </div>
                                            <div class="no-avatar"></div>
                                        </li>
                                        <li class="self">
                                            <div class="msg">
                                                <p>
                                                    OK, bye-bye
                                                    See you!
                                                </p>
                                                <div class="card-footer">
                                                    <i class="ti-check"></i>
                                                    <h6>11:25</h6>
                                                </div>
                                            </div>
                                            <div class="avatar">
                                                <img src="../../assets/img/default-avatar.png" alt="crash">
                                            </div>
                                        </li>
                                    </ol>
                                    <hr>
                                    <div class="send-message">
                                        <div class="avatar">
                                            <img src="https://etk21.ru/{{ Auth::user()->profile_image }}" />
                                        </div>
                                        <input class="form-control textarea" type="text" placeholder="Введите сообщение">
                                        <div class="send-button">
                                            <button class="btn btn-primary btn-fill"><i class="fa fa-share"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                </div>
        </div>
    </div>
    @include('includes.dashboard.footer')
</div>
</div>


@endsection