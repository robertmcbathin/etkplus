@extends('layouts.dashboard.master')

@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
Список предприятий
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
                    <a class="btn btn-danger btn-fill btn-wd btn-square" href="{{ route('dashboard.agent.create-partner.get') }}">Добавить предприятие</a>
                </div>

            </div>
            <br>
            <div class="col-md-12">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    <input type="text" id='search-partner-list' value="" class="form-control" placeholder="Название предприятия">
                </div>
                <div class="card" id="partner-list-results">
                    <div class="card-header">
                        <h4 class="card-title">Список предприятий</h4>
                    </div>
                    <div class="card-content table-full-width">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Название</th>
                                    <th>Номер договора</th>
                                    <th>Выписать счет</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($partners as $partner)
                                <tr>
                                    <td class="text-center">{{ $partner->id }}</td>
                                    <td><a href="{{ route('dashboard.agent.partner-page.get', ['partner_id' => $partner->id]) }}">{{ $partner->name }}</a></td>
                                    <td>{{ $partner->contract_id }}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-fill btn-wd btn-square" data-toggle="modal" data-target="#connection-bill-{{ $partner->id }}">Счет за подключение</button>
                                        <button type="button" class="btn btn-danger btn-fill btn-wd btn-square" data-toggle="modal" data-target="#service-bill-{{ $partner->id }}">Счет на услуги</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-center">
                            <?php echo $partners->render(); ?>
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

<script>
  var token = '{{ Session::token() }}';
  var searchPartnerListUrl = '{{ route('ajax.agent.search-partner-list.post') }}';
</script>

@foreach($partners as $partner)
<div class="modal fade" id="connection-bill-{{ $partner->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-notice">
        <div class="modal-content">
            <div class="modal-header no-border-header">
                <h5 class="modal-title" id="myModalLabel">Выписать счет за подключение</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <form action="{{ route('dashboard.agent.create-connection-invoice.post') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="partner_id" value="{{ $partner->id }}">
                    <div class="instruction">
                        <div class="row">
                            <p>Будет выписан счет на оплату за подключение к системе по договору № {{ $partner->contract_id }} для предприятия {{ $partner->fullname }} по заданному в тарифе значению</p>
                        </div>
                        <hr>
                        <div class="row">
                            <button type="submit" id="index-bill-submit" class="btn btn-success btn-fill btn-round btn-square" style="width:100%;">Выписать счет</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach($partners as $partner)
<div class="modal fade" id="service-bill-{{ $partner->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-notice">
        <div class="modal-content">
            <div class="modal-header no-border-header">
                <h5 class="modal-title" id="myModalLabel">Выписать счет за услуги</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <form action="{{ route('dashboard.agent.create-service-invoice.post') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="partner_id" value="{{ $partner->id }}">
                    <div class="instruction">
                        <div class="row">
                            <p>Будет выписан счет на оплату услуг системы по договору № {{ $partner->contract_id }} для предприятия {{ $partner->fullname }} </p>
                        </div>
                    <div class="row">
                         <p>Сумма пополнения</p>
                     </div>
                     <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" name="value" value="" placeholder="" minlength="" maxlength="" class="form-control" required>
                            </div>
                        </div>
                    </div>
                        <hr>
                        <div class="row">
                            <button type="submit" id="index-bill-submit" class="btn btn-success btn-fill btn-round btn-square" style="width:100%;">Выписать счет</button>
                        </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endforeach