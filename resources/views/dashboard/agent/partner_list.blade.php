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
                    <input type="text" id='search-partner-list' value="" class="form-control" placeholder="Название или номер договора">
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
                                    <th>Блокировка</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($partners as $partner)
                                <tr>
                                    <td class="text-center">{{ $partner->id }}</td>
                                    <td><a href="{{ route('dashboard.agent.partner-page.get', ['partner_id' => $partner->id]) }}">{{ $partner->name }}</a></td>
                                    <td>{{ $partner->contract_id }}</td>
                                    <td>
                                        @if ($partner->blocked_by_payment == 0)
                                        <div class="checkbox">
                                            <input id="checkbox4" type="checkbox"  disabled>
                                            <label for="checkbox4">
                                                Активен
                                            </label>
                                        </div>
                                        @elseif ($partner->is_blocked == 1)
                                        <div class="checkbox">
                                            <input id="checkbox4" type="checkbox" checked disabled>
                                            <label for="checkbox4">
                                                Блокирован
                                            </label>
                                        </div>
                                        @endif
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