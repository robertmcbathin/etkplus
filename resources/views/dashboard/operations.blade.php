@extends('layouts.dashboard.master')

@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
Операции
@endsection
@section('content')
<div class="wrapper">
    @include('includes.dashboard.sidebar')
    <div class="main-panel">
        @include('includes.dashboard.top_nav')
        <div class="content">
            <div class="container-fluid">
                @include('includes/notifications')
                <div class="col-md-12">


                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Операции</h4>
                            <div class="columns columns-right pull-right">
                                <a class="btn btn-default" href="{{ route('dashboard.show-visits-list-by-param.get',['sort_param' => 'amount']) }}" type="button" name="refresh" title="По объему услуг"><i class="glyphicon fa fa-sort-amount-desc"></i></a>
                                <button class="btn btn-default" type="button" name="toggle" title="Toggle"><i class="glyphicon fa fa-th-list"></i></button>
                                <div class="keep-open btn-group" title="Columns">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="glyphicon fa fa-columns"></i> <span class="caret"></span></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><label><input type="checkbox" data-field="id" value="1" checked="checked"> ID</label></li>
                                        <li><label><input type="checkbox" data-field="name" value="2" checked="checked"> Name</label></li>
                                        <li><label><input type="checkbox" data-field="salary" value="3" checked="checked"> Salary</label></li>
                                        <li><label><input type="checkbox" data-field="country" value="4" checked="checked"> Country</label></li>
                                        <li><label><input type="checkbox" data-field="city" value="5" checked="checked"> City</label></li>
                                        <li><label><input type="checkbox" data-field="actions" value="6" checked="checked"> Actions</label></li></ul>
                                    </div>
                            </div>
                        </div>
                        <div class="card-content table-full-width">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Предприятие</th>
                                        <th>Номер карты</th>
                                        <th class="text-right">Счет</th>
                                        <th class="text-right">Скидка</th>
                                        <th class="text-right">Бонус</th>
                                        <th class="text-right">Кэшбэк</th>
                                        <th class="text-right">Дата</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($visits as $visit)
                                    <tr>
                                        <td class="text-center">{{ $visit->id }}</td>
                                        <td><a href="{{ route('dashboard.partner-page.get', ['partner_id' => $visit->partner_id]) }}">{{ $visit->partner_name }}</a></td>
                                        <td><a href="">{{ $visit->card_number }}</a></td>
                                        <td class="text-right">{{ $visit->bill }}</td>
                                        <td class="text-right">{{ $visit->discount }}</td>
                                        <td class="text-right">{{ $visit->bonus }}</td>
                                        <td class="text-right">{{ $visit->cashback }}</td>
                                        <td class="text-right">{{ $visit->created_at }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-center">
                                <?php echo $visits->render(); ?>
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
