@extends('layouts.dashboard.master')

@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
Выплата агентам
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
                            <h4 class="card-title">Выплата агентам</h4>
                        </div>
                        <div class="card-content">
                            <div class="row">
                                <div class="left-vertical-tabs">
                                    <ul class="nav nav-stacked" role="tablist">
                                        <li class="active">
                                            <a href="#to-pay" role="tab" data-toggle="tab" aria-expanded="false">
                                             К выплате
                                         </a>
                                     </li>
                                     <li class="">
                                        <a href="#history" role="tab" data-toggle="tab" aria-expanded="true">
                                         История выплат
                                     </a>
                                 </li>
                             </ul>
                         </div>
                         <div class="right-text-tabs">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="to-pay">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Сумма, накопленная к выплате</h4>
                                        </div>
                                        <div class="card-content table-responsive table-full-width">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr><th>ID</th>
                                                        <th>ФИО</th>
                                                        <th>Должность</th>
                                                        <th>Остаток</th>
                                                        <th></th>
                                                    </tr></thead>
                                                    <tbody>
                                                        @foreach ($accounts as $account)
                                                        <tr>
                                                            <td>{{ $account->id }}</td>
                                                            <td>{{ $account->name }}</td>
                                                            <td>{{ $account->post }}</td>
                                                            <td>{{ $account->value }}</td>
                                                            <td><button class="btn btn-danger" data-toggle="modal" data-target="#pay-to-agent-{{ $account->user_id }}">Выплатить</button></td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="history">
                                        <p>The first thing you notice when you hold the phone is how great it feels in your hand. The cover glass curves down around the sides to meet the anodized aluminum enclosure in a remarkable, simplified design. </p>
                                        <p>There are no distinct edges. No gaps. Just a smooth, seamless bond of metal and glass that feels like one continuous surface.</p>
                                    </div>
                                </div>
                            </div>
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
@foreach ($accounts as $account)
<div class="modal fade" id="pay-to-agent-{{ $account->user_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Выплатить</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('dashboard.pay-salary.post') }}" method="POST">
                <div class="modal-body"> 
                  <div class="form-group">
                      <label class="control-label">
                          Сумма, которая будет выплачена
                      </label>
                      {{ csrf_field() }}
                      <input type="hidden" value="{{ $account->user_id }}" name="user_id">
                      <input class="form-control" type="text" name="to_pay" placeholder="1000" required>
                  </div>
              </div>
              <div class="modal-footer">
                <div class="left-side">
                    <div class="right-side">
                        <button type="submit" class="btn btn-danger btn-link">Оплачено</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
@endforeach