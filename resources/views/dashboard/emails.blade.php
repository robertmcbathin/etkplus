@extends('layouts.dashboard.master')

@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
Рассылки
@endsection
@section('content')
<div class="wrapper">
    @include('includes.dashboard.sidebar')
    <div class="main-panel">
        @include('includes.dashboard.top_nav')
        <div class="content">
            <div class="container-fluid">
                @include('includes/notifications')
                <div class="row">
                 <div class="col-md-12">
                    <a class="btn btn-danger btn-fill btn-wd btn-square" data-toggle="modal" data-target="#add-distribution" >Добавить рассылку</a>
                </div>

            </div>
            <br>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Созданные рассылки</h4>
                        <p class="category">Доступно адресов для рассылки: {{ $recipients_count }}</p>
                    </div>
                    <div class="card-content">
                       <div id="acordeon">
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-border panel-default">
                                <a data-toggle="collapse" href="#collapseOne">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            Акция к новому году
                                            <i class="fa fa-chevron-down"></i>
                                        </h4>
                                    </div>
                                </a>
                                <div id="collapseOne" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <h6>Дата создания</h6>
                                        <i>5.11.2017</i>
                                        <h6>Текст</h6>
                                        <p>Дорогой клиент! В честь скорого наступления 2018 года мы предлагаем Вам поучаствовать в нашей распродаже! Специально для Вас скидка 25% при покупке от 1000 рублей и 200 бонусных баллов на счет!</p> 
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h6>Статус</h6>
                                                <span class="label label-warning">Черновик</span>
                                            </div>  
                                            <div class="col-md-4">
                                                <h6>Подтверждение</h6>
                                                <span class="label label-info">На модерации</span>
                                                <p class="text-muted">Ожидает подтверждения менеджером</p>
                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <button class="btn btn-success btn-fill btn-wd" style="float:right;">Отправить</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-border panel-default">
                                <a data-toggle="collapse" href="#collapseTwo">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            Поступление нового товара
                                            <i class="fa fa-chevron-down"></i>
                                        </h4>
                                    </div>
                                </a>
                                <div id="collapseTwo" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                    </div>
                                </div>
                            </div>
                            @foreach($distributions as $distribution)
                            <div class="panel panel-border panel-default">
                                <a data-toggle="collapse" href="#collapse-{{ $distribution->id }}">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            {{ $distribution->title }}
                                            <i class="fa fa-chevron-down"></i>
                                        </h4>
                                    </div>
                                </a>
                                <div id="collapse-{{ $distribution->id }}" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <h6>Дата создания</h6>
                                        <i>{{ $distribution->created_at }}</i>
                                        <h6>Текст</h6>
                                        <p>{{ $distribution->text }}</p> 
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h6>Статус</h6>
                                                <span class="label label-warning">Черновик</span>
                                            </div>  
                                            <div class="col-md-4">
                                                <h6>Подтверждение</h6>
                                                <span class="label label-info">На модерации</span>
                                                <p class="text-muted">Ожидает подтверждения менеджером</p>
                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <form action="{{ route('dashboard.send-email-distribution.post') }}" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="distribution_id" value="{{ $distribution->id }}">
                                                <button class="btn btn-success btn-fill btn-wd" type="submit">Отправить</button>
                                            </form>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div><!--  end acordeon -->
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes.dashboard.footer')
</div>
</div>


@endsection

<div class="modal fade" id="add-distribution" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center" id="exampleModalLabel">Создание рассылки</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <p>Рассылка будет отправлена на {{ $recipients_count }} адресов.</p>
                <form action="{{ route('dashboard.partner.add-invoice.post') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <fieldset>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Название</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="text" name="name" placeholder="" minlength="1" maxlength="100" required>
                                                </div>
                                            </div>
                                        </fieldset><br>
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Текст</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" placeholder="" name="text" rows="3"></textarea>
                            </div>
                        </div>
                    </fieldset>


                </div>
                <div class="modal-footer">
                    <div class="divider"></div>
                    <div class="right-side">
                        <button type="submit" class="btn btn-success btn-link btn-fill btn-square btn-fw">Создать</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>