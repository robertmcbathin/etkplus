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
                                    <td></td>
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
