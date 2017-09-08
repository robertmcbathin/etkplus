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
            @include('includes/notifications');
                <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Table with Switches</h4>
                                    <p class="category">With some subtitle</p>
                                </div>
                                <div class="card-content table-full-width">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Название</th>
                                                <th>Действие</th>
                                                <th class="text-right">Активность</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($partners as $partner)
                                            <tr>
                                                <td class="text-center">{{ $partner->id }}</td>
                                                <td>{{ $partner->name }}</td>
                                                <td>
                                                    <a href="#" rel="tooltip" title="" class="btn btn-success btn-simple btn-xs" data-original-title="Редактировать">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                    <a href="#" rel="tooltip" title="" class="btn btn-danger btn-simple btn-xs" data-original-title="Удалить" onclick="demo.showSwal('delete-partner')">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                                 <td class="text-right">
                                                    @if ($partner->is_active == 1)
                                                        <input type="checkbox" data-id="{{ $partner->id }}" class="switch-plain toggle-activate-partner" checked disabled>
                                                    @else
                                                        <input type="checkbox" data-id="{{ $partner->id }}"" class="switch-plain toggle-activate-partner" disabled>
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
            @include('includes.dashboard.footer')
        </div>
    </div>


    @endsection
<script>
  var token = '{{ Session::token() }}';
  var url = '{{ route('ajax.change_active_status') }}';
</script>