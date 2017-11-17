@extends('layouts.dashboard.master')

@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
{{ $partner->name }}
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
                    <button class="btn btn-danger btn-fill btn-wd btn-square" data-toggle="modal" data-target="#create-operator">Добавить оператора</button>
                </div>

            </div>
            <br>
            <div class="row">
             <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Список операторов</h4>
                    </div>
                    <div class="card-content table-responsive table-full-width">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Имя</th>
                                    <th>Должность</th>
                                    <th>email</th>
                                    <th class="text-right"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($operators as $operator)
                                <tr>
                                    <td class="text-center">{{ $operator->id }}</td>
                                    <td class="text-right"><a href="{{ route('dashboard.partner.show-operator.get', ['operator_id' => $operator->id]) }}">{{ $operator->name }} {{ $operator->lastname }}</a></td>
                                    <td>{{ $operator->post}}</td>
                                    <td>{{ $operator->email }}</td>
                                    <td class="td-actions text-right">
                                        <a href="#" data-toggle="modal" data-target="#change-operator-password-{{ $operator->id }}" rel="tooltip" title="" class="btn btn-success btn-simple btn-xs" data-original-title="Изменить пароль">
                                            <i class="fa fa-lock"></i>
                                        </a>
                                        <a href="#" data-toggle="modal" data-target="#edit-operator-{{ $operator->id }}" rel="tooltip" title="" class="btn btn-success btn-simple btn-xs" data-original-title="Редактировать">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @if ($operator->role_id > 21)
                                        <a href="#" rel="tooltip" title="" data-toggle="modal" data-target="#delete-operator-{{ $operator->id }}" class="btn btn-danger btn-simple btn-xs" data-original-title="Удалить">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    @include('includes.dashboard.footer')
</div>

<div class="modal fade" id="create-operator" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Создать оператора</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <div class="col-md-12">
                    <div class="card">
                        <form method="POST" action="{{ route('dashboard.partner.create-operator.post') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="partner_id" value="{{ $partner->id }}">
                            <div class="card-content">
                                <div class="form-group">
                                    <label>Имя</label>
                                    <input type="text" placeholder="Василий" class="form-control" maxlength="100" minlength="1" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label>Фамилия</label>
                                    <input type="text" placeholder="Петров" class="form-control" maxlength="100" minlength="1" name="lastname" required>
                                </div>
                                <div class="form-group">
                                    <label>Должность</label>
                                    <input type="text" name="post" placeholder="Кассир" class="form-control" minlength="1" maxlength="100" required>
                                </div>
                                <div class="form-group">
                                    <label>email</label>
                                    <input type="email" name="email" class="form-control" placeholder="example@mail.com" required>
                                    <span class="help-block">E-mail будет использоваться для входа в систему</span>
                                </div>
                                <div class="form-group">
                                    <label>Пароль</label>
                                    <input type="text" name="password" placeholder="" class="form-control" minlength="1" maxlength="100" required>
                                    <span class="help-block">Отнеситесь к созданию пароля серьезно, чтобы избежать несанкционированных операций</span>
                                </div>
                                <button type="submit" class="btn btn-fill btn-success btn-fw btn-square">Добавить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="left-side">
                    <button type="button" class="btn btn-default btn-link btn-simple" data-dismiss="modal">Отмена</button>
                </div>
            </div>
        </div>
    </div>
</div>
@foreach ($operators as $operator)
<div class="modal fade" id="delete-operator-{{ $operator->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm ">
        <div class="modal-content">
            <div class="modal-header no-border-header">
                <div></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body text-center">
                <h5>Удалить оператора?</h5>
            </div>
            <div class="modal-footer">
                <div class="left-side">
                    <button type="button" class="btn btn-default btn-link btn-simple" data-dismiss="modal">Нет</button>
                </div>
                <div class="divider"></div>
                <div class="right-side">
                    <form action="{{ route('dashboard.partner.delete-operator.post') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="operator_id" value="{{ $operator->id }}">
                        <button type="submit" class="btn btn-danger btn-link btn-fill btn-square">Да</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach ($operators as $operator)
<div class="modal fade" id="edit-operator-{{ $operator->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Изменить данные оператора</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <div class="col-md-12">
                    <div class="card">
                        <form method="POST" action="{{ route('dashboard.partner.edit-operator.post') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="operator_id" value="{{ $operator->id }}">
                            <div class="card-content">
                                <div class="form-group">
                                    <label>Имя и Фамилия</label>
                                    <input type="text" placeholder="Василий Петров" class="form-control" maxlength="100" minlength="1" name="name" value="{{ $operator->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Должность</label>
                                    <input type="text" name="post" placeholder="Кассир" class="form-control" value="{{ $operator->post }}" minlength="1" maxlength="100" required>
                                </div>
                                <div class="form-group">
                                    <label>email</label>
                                    <input type="email" name="email" class="form-control" placeholder="example@mail.com" value="{{ $operator->email }}" required>
                                    <span class="help-block">E-mail будет использоваться для входа в систему</span>
                                </div>
                                <button type="submit" class="btn btn-fill btn-info btn-square btn-fw">Изменить данные</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="left-side">
                    <button type="button" class="btn btn-default btn-link btn-simple" data-dismiss="modal">Отмена</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach ($operators as $operator)
<div class="modal fade" id="change-operator-password-{{ $operator->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Изменить пароль</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <div class="col-md-12">
                    <div class="card">
                        <form method="POST" action="{{ route('dashboard.partner.edit-operator-password.post') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="operator_id" value="{{ $operator->id }}">
                            <div class="card-content">
                                <div class="form-group">
                                    <label>Новый пароль</label>
                                    <input type="text" placeholder="" class="form-control" maxlength="100" minlength="1" name="password" required>
                                    <span class="help-block">Новый пароль будет отправлен на электронную почту оператора</span>
                                </div>
                                <button type="submit" class="btn btn-fill btn-info btn-square btn-fw">Изменить пароль</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="left-side">
                    <button type="button" class="btn btn-default btn-link btn-simple" data-dismiss="modal">Отмена</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach