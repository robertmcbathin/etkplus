@extends('layouts.dashboard.master')

@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
Категории
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
                    <a class="btn btn-danger btn-fill btn-wd btn-square" data-toggle="modal" data-target="#add-category" >Добавить категорию</a>
                </div>
            </div>
            <br>
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Категории</h4>
                        <p class="category">по уровням</p>
                    </div>
                    <div class="card-content">
                       <div id="acordeon">
                        <div class="panel-group" id="accordion">


                            @foreach ($levels as $level)
                            <div class="panel panel-border panel-default">
                                <a data-toggle="collapse" href="#collapse-{{ $level->level }}" class="collapsed" aria-expanded="false">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            Категории уровня {{ $level->level }}
                                            <i class="ti-angle-down"></i>
                                        </h4>
                                    </div>
                                </a>
                                <div id="collapse-{{ $level->level }}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                    <div class="panel-body">
                                        <div class="card-content table-full-width">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th>Заголовок</th>
                                                        <th>Описание</th>
                                                        <th>Родительская категория</th>
                                                        <th class="text-right">Создано</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($categories as $category)
                                                    @if ($category->level == $level->level)
                                                    <tr>
                                                        <td>{{ $category->id  }}</td>
                                                        <td>{{ $category->title }}</td>
                                                        <td>{{ $category->description }}</td>
                                                        <td>{{ $category->parent }}</td>
                                                        <td class="text-right">{{ $category->created_at }}</td>
                                                        <td>
                                                            <button class="btn btn-info  btn-square btn-fill" data-toggle="modal" data-target="#edit-category-{{$category->id}}">Изменить</button>

                                                        </td>
                                                        <td>
                                                            <button class="btn btn-danger  btn-square btn-fill" data-toggle="modal" data-target="#delete-category-{{$category->id}}">Удалить</button>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
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
<div class="modal fade" id="add-category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Добавить категорию</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{ route('dashboard.shop.add-category.post') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <h5 class="text-center"></h5>
                    <div class="form-group">
                        <label class="control-label">
                            Название
                        </label>
                        <input class="form-control" type="text" name="title" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Описание
                        </label>
                        <input class="form-control" type="text" name="description" placeholder="">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Уровень
                        </label>
                        <input class="form-control" type="text" name="level" placeholder="Если это корневая категория, то поставить 1, если имеет предка, то ничего ставить не нужно" minlength="1" maxlength="2">
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="parent_id" title="Выберите родительскую категорию" data-size="7" tabindex="-98">
                            <option class="bs-title-option" value="">Выберите родительскую категорию</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }} (уровень {{ $category->level }})</option>
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

@foreach($categories as $category)
<div class="modal fade" id="edit-category-{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Изменить категорию</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{ route('dashboard.shop.edit-category.post') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="category_id" value="{{ $category->id }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <h5 class="text-center"></h5>
                    <div class="form-group">
                        <label class="control-label">
                            Название
                        </label>
                        <input class="form-control" type="text" name="title" placeholder="" required value="{{ $category->title }}">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Описание
                        </label>
                        <input class="form-control" type="text" name="description" placeholder="" value="{{ $category->description }}">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Уровень
                        </label>
                        <input class="form-control" type="text" name="level" placeholder="Если это корневая категория, то поставить 1, если имеет предка, то ничего ставить не нужно" minlength="1" maxlength="2" value="{{ $category->level }}">
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="parent_id" title="Выберите родительскую категорию" data-size="7" tabindex="-98">
                            <option class="bs-title-option" value="{{ $category->id }}">Выберите родительскую категорию</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }} (уровень {{ $category->level }})</option>
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

@foreach($categories as $category)
<div class="modal fade" id="delete-category-{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Удалить категорию?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{ route('dashboard.shop.delete-category.post') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="category_id" value="{{ $category->id }}">
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