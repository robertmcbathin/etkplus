@extends('layouts.dashboard.master')

@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
Магазины
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
                    <a class="btn btn-danger btn-fill btn-wd btn-square" data-toggle="modal" data-target="#add-shop" >Добавить магазин</a>
                </div>
            </div>
            <br>
            <div class="col-md-12">

                <div class="card-content table-full-width">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Название</th>
                                <th>Полное название</th>
                                <th>Тип</th>
                                <th>Контрагент</th>
                                <th class="text-right">Добавлен</th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shops as $shop)
                            <tr>
                                <td>{{ $shop->id }}</td>
                                <td>{{ $shop->name }}</td>
                                <td>{{ $shop->fullname }}</td>
                                <td>{{ $shop->shop_type }}</td>
                                <td>
                                    @if($shop->company_id == null)
                                    Контрагент не назначен
                                    @else
                                        {{ $shop->company_name }}
                                    @endif
                                </td>
                                <td class="text-right">{{ $shop->created_at }}</td>
                                <td>
                                    <button class="btn btn-info  btn-square btn-fill" data-toggle="modal" data-target="#edit-shop-{{$shop->id}}">Изменить</button>

                                </td>
                                <td>
                                    <button class="btn btn-danger  btn-square btn-fill" data-toggle="modal" data-target="#delete-shop-{{$shop->id}}">Удалить</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                    <div class="text-center">
                        <?php echo $shops->render(); ?>
                    </div>

            </div>
        </div>
    </div>
    @include('includes.dashboard.footer')
</div>
</div>


@endsection
<div class="modal fade" id="add-shop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Добавить магазин</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{ route('dashboard.shop.add-shop.post') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <h5 class="text-center"></h5>
                    <div class="form-group">
                        <label class="control-label">
                            Название
                        </label>
                        <input class="form-control" type="text" name="name" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Полное название
                        </label>
                        <input class="form-control" type="text" name="fullname" placeholder="">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Описание
                        </label>
                        <input class="form-control" type="text" name="description" placeholder="">
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="type" title="Выберите тип" data-size="7" tabindex="-98">
                            <option class="bs-title-option" value="">Выберите тип*</option>
                            @foreach ($shop_types as $shop_type)
                            <option value="{{ $shop_type->id }}">{{ $shop_type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Минимальный заказ
                        </label>
                        <input class="form-control" type="text" name="min_sale" placeholder="5000" minlength="1" maxlength="6">
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="company_id" title="Выберите контрагента" data-size="7" tabindex="-98">
                            <option class="bs-title-option" value="">Выберите контрагента*</option>
                            @foreach ($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }} ( {{ $company->legal_name }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Партнер в системе ЕТКплюс (если есть)
                        </label>
                        <select class="form-control" name="partner_id" title="Выберите партнера" data-size="7" tabindex="-98">
                            <option class="bs-title-option" value="">Выберите партнера</option>
                            @foreach ($partners as $partner)
                            <option value="{{ $partner->id }}">{{ $partner->name }} ( {{ $partner->fullname }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="divider"></div>
                    <div class="right-side">
                        <button type="submit" class="btn btn-success btn-link btn-square btn-fill btn-fw">Добавить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@foreach($shops as $shop)
<div class="modal fade" id="edit-shop-{{$shop->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Изменить категорию</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{ route('dashboard.shop.edit-shop.post') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <h5 class="text-center"></h5>
                    <div class="form-group">
                        <label class="control-label">
                            Название
                        </label>
                        <input class="form-control" type="text" name="name" value="{{ $shop->name }}" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Полное название
                        </label>
                        <input class="form-control" type="text" name="fullname" value="{{ $shop->fullname }}" placeholder="">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Описание
                        </label>
                        <input class="form-control" type="text" name="description" value="{{ $shop->description }}" placeholder="">
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="type" title="Выберите тип" data-size="7" tabindex="-98">
                            <option class="bs-title-option" value="">Выберите тип*</option>
                            @foreach ($shop_types as $shop_type)
                            <option value="{{ $shop_type->id }}">{{ $shop_type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Минимальный заказ
                        </label>
                        <input class="form-control" type="text" name="min_sale" value="{{ $shop->min_sale }}" placeholder="5000" minlength="1" maxlength="6">
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="company_id" title="Выберите контрагента" data-size="7" tabindex="-98">
                            <option class="bs-title-option" value="{{ $shop->company_id }}">Выберите контрагента</option>
                            @foreach ($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }} ( {{ $company->legal_name }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Партнер в системе ЕТКплюс (если есть)
                        </label>
                        <select class="form-control" name="partner_id" title="Выберите партнера" data-size="7" tabindex="-98">
                            <option class="bs-title-option" value="{{ $shop->partner_id }}">Выберите партнера</option>
                            @foreach ($partners as $partner)
                            <option value="{{ $partner->id }}">{{ $partner->name }} ( {{ $partner->fullname }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="left-side">

                    </div>
                    <div class="divider"></div>
                    <div class="right-side">
                        <button type="submit" class="btn btn-info btn-link btn-fw btn-square btn-fill">Изменить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach($shops as $shop)
<div class="modal fade" id="delete-shop-{{$shop->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Удалить магазин?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{ route('dashboard.shop.delete-shop.post') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                </div>
                <div class="modal-footer">
                    <div class="left-side">

                    </div>
                    <div class="divider"></div>
                    <div class="right-side">
                        <button type="submit" class="btn btn-danger btn-link btn-fw btn-square btn-fill">Да, удалить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach