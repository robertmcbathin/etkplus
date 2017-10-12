@extends('layouts.dashboard.master')

@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
Пользователи
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
                    <a class="btn btn-danger btn-fill btn-wd" data-toggle="modal" data-target="#add-user" >Добавить пользователя</a>
                </div>

            </div>
            <br>
            <div class="col-md-12">
                <div class="card" id="partner-list-results">
                    <div class="card-header">
                        <h4 class="card-title">Пользователи</h4>
                    </div>
                    <div class="card-content table-full-width">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>ФИО</th>
                                    <th>Должность</th>
                                    <th>Email</th>
                                    <th>Телефон</th>
                                    <th>Пароль</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td class="text-center">{{ $user->id }}</td>
                                    <td><a href="{{ route('dashboard.partner-page.get', ['partner_id' => $user->id]) }}">{{ $user->name }}</a></td>
                                    <td>{{ $user->post }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->temp_password }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.dashboard.footer')
</div>
</div>


@endsection
<div class="modal fade" id="add-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Добавить пользователя</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{ route('dashboard.add-user.post') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <h5 class="text-center"></h5>
                    <div class="form-group">
                        <label class="control-label">
                            ФИО
                        </label>
                        <input class="form-control" type="text" name="name" placeholder="Пилкин Артем Андреевич" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Уровень доступа
                        </label>
                        <select class="form-control" name="role_id" title="Должность" data-size="7" tabindex="-98">
                            <option class="bs-title-option" value="">Уровень доступа</option>
                            <option value="13">Бухгалтер</option>
                            <option value="14">Модератор</option>
                            <option value="13">Менеджер по продажам</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Должность
                        </label>
                        <input class="form-control" type="text" name="post" placeholder="Менеджер" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Email
                        </label>
                        <input class="form-control" type="email" name="email" placeholder="example@mail.com" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Номер телефона
                        </label>
                        <input class="form-control" type="text" name="phone" placeholder="+79008007090" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Пароль
                        </label>
                        <input class="form-control" type="text" name="password" placeholder="123456" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="left-side">
                        <button type="button" class="btn btn-default btn-link" data-dismiss="modal">Отмена</button>
                    </div>
                    <div class="divider"></div>
                    <div class="right-side">
                        <button type="submit" class="btn btn-success btn-link">Добавить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

</script>