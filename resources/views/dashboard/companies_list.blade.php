@extends('layouts.dashboard.master')

@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
Контрагенты
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
                    <a class="btn btn-danger btn-fill btn-wd btn-square" data-toggle="modal" data-target="#add-company">Добавить контрагента</a>
                </div>
            </div>
                <br>
                            <div class="col-md-12">
                <div class="card" id="partner-list-results">
                    <div class="card-header">
                        <h4 class="card-title">Список контрагентов</h4>
                    </div>
                    <div class="card-content table-full-width">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Название</th>
                                    <th>Наименование полное</th>
                                    <th>Физический адрес</th>
                                    <th>Юридический адрес</th>
                                    <th>ИНН</th>
                                    <th>КПП</th>
                                    <th>ОГРН</th>
                                    <th class="text-right"></th>
                                    <th class="text-right"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($companies as $company)
                                <tr>
                                    <td class="text-center">{{ $company->id }}</td>
                                    <td>{{ $company->name }}</td>
                                    <td>{{ $company->legal_name }}</td>
                                    <td>{{ $company->physical_address }}</td>
                                    <td>{{ $company->legal_address }}</td>
                                    <td>{{ $company->inn }}</td>
                                    <td>{{ $company->kpp }}</td>
                                    <td>{{ $company->ogrn }}</td>
                                    <td>
                                        <button class="btn btn-info  btn-square btn-fill" data-toggle="modal" data-target="#edit-company-{{$company->id}}">Изменить</button>
                                    
                                </td>
                                <td>
                                    <button class="btn btn-danger  btn-square btn-fill" data-toggle="modal" data-target="#delete-company-{{$company->id}}">Удалить</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        <?php echo $companies->render(); ?>
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

<div class="modal fade" id="add-company" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Добавить контрагента</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{ route('dashboard.add-company.post') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <h5 class="text-center"></h5>
                    <div class="form-group">
                        <label class="control-label">
                            Название
                        </label>
                        <input class="form-control" type="text" name="name" placeholder="Произвольное название" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Юридическое наименование
                        </label>
                        <input class="form-control" type="text" name="legal_name" placeholder="Юридическое наименование" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Юридический адрес
                        </label>
                        <input class="form-control" type="text" name="legal_address" placeholder="Юридический адрес" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Физический адрес
                        </label>
                        <input class="form-control" type="text" name="physical_address" placeholder="Физический адрес" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            ИНН
                        </label>
                        <input class="form-control" type="text" name="inn" placeholder="" minlength="10" maxlength="12" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            КПП
                        </label>
                        <input class="form-control" type="text" name="kpp" placeholder="213001001"  minlength="9" maxlength="9">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            ОГРН
                        </label>
                        <input class="form-control" type="text" name="ogrn" placeholder="" required minlength="1" maxlength="20">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Расчетный счет
                        </label>
                        <input class="form-control" type="text" name="checking_account" placeholder="">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            БИК
                        </label>
                        <input class="form-control" type="text" name="bik" placeholder="">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Корр. счет
                        </label>
                        <input class="form-control" type="text" name="corr_account" placeholder="">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="left-side">

                    </div>
                    <div class="divider"></div>
                    <div class="right-side">
                        <button type="submit" class="btn btn-success btn-link btn-fw btn-square btn-fill">Добавить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@foreach($companies as $company)
<div class="modal fade" id="edit-company-{{$company->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Изменить данные контрагента</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{ route('dashboard.edit-company.post') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="company_id" value="{{ $company->id }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <h5 class="text-center"></h5>
                    <div class="form-group">
                        <label class="control-label">
                            Название
                        </label>
                        <input class="form-control" type="text" name="name" placeholder="Произвольное название" value="{{ $company->name }}" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Юридическое наименование
                        </label>
                        <input class="form-control" type="text" name="legal_name" placeholder="Юридическое наименование" value="{{ $company->legal_name }}" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Юридический адрес
                        </label>
                        <input class="form-control" type="text" name="legal_address" placeholder="Юридический адрес" value="{{ $company->legal_address }}" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Физический адрес
                        </label>
                        <input class="form-control" type="text" name="physical_address" placeholder="Физический адрес" value="{{ $company->physical_address }}" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            ИНН
                        </label>
                        <input class="form-control" type="text" name="inn" placeholder="" minlength="10" maxlength="12" value="{{ $company->inn }}" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            КПП
                        </label>
                        <input class="form-control" type="text" name="kpp" placeholder="213001001"  minlength="9" value="{{ $company->kpp }}" maxlength="9">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            ОГРН
                        </label>
                        <input class="form-control" type="text" name="ogrn" placeholder="" required minlength="1" maxlength="20" value="{{ $company->ogrn }}">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Расчетный счет
                        </label>
                        <input class="form-control" type="text" name="checking_account" placeholder="" value="{{ $company->checking_account }}">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            БИК
                        </label>
                        <input class="form-control" type="text" name="bik" placeholder="" value="{{ $company->bik }}">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Корр. счет
                        </label>
                        <input class="form-control" type="text" name="corr_account" placeholder="" value="{{ $company->corr_account }}">
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

@foreach($companies as $company)
<div class="modal fade" id="delete-company-{{$company->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Удалить контрагента?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{ route('dashboard.delete-company.post') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="company_id" value="{{ $company->id }}">
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
