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
                    <a class="btn btn-danger btn-fill btn-wd" data-toggle="modal" data-target="#add-tariff" >Добавить рассылку</a>
                </div>

            </div>
            <br>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Созданные рассылки</h4>
                        <p class="category">Доступно адресов для рассылки: 218</p>
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
                            <div class="panel panel-border panel-default">
                                <a data-toggle="collapse" href="#collapseThree">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            Распродажа коллекции весна-лето
                                            <i class="fa fa-chevron-down"></i>
                                        </h4>
                                    </div>
                                </a>
                                <div id="collapseThree" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                    </div>
                                </div>
                            </div>
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

<script>

</script>