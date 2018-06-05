@extends('layouts.dashboard.master')

@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
Лог
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
          @foreach ($log_types as $log_type)
          <a href="{{ route('dashboard.show-log.get',['type' => $log_type->id]) }}" class="tag label label-info">{{ $log_type->full_name }}</a>
          @endforeach
        </div>

      </div>
      <br>
      @isset($logs)
      <div class="col-md-12">
        <div class="card card-plain">
          <div class="card-header">
            <h4 class="card-title">Журнал</h4>
            <p class="category">Событие: <b>{{ $current_type->full_name }}</b></p>
          </div>
          <div class="card-content table-responsive table-full-width">
            <table class="table table-hover">
              <thead>
                <tr><th>ID</th>
                  <th>Текст</th>
                  <th>Дата</th>
                </tr></thead>
                <tbody>
                  @foreach($logs as $log)
                  <tr>
                    <td>{{ $log->id }}</td>
                    <td>{{ $log->message }}</td>
                    <td>{{ $log->created_at }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <div class="text-center">
                <?php echo $logs->render(); ?>
              </div>
            </div>
          </div>
        </div>
        @endisset
      </div>
    </div>
    @include('includes.dashboard.footer')
  </div>
</div>


@endsection

