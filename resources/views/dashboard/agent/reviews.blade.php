@extends('layouts.dashboard.master')

@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
Отзывы
@endsection
@section('content')
<div class="wrapper">
    @include('includes.dashboard.sidebar')
    <div class="main-panel">
        @include('includes.dashboard.top_nav')
        <div class="content">
            <div class="container-fluid">
                @include('includes/notifications')
                <div class="col-lg-12 hidden-xs hidden-md hidden-sm">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Отзывы</h4>
                        </div>
                        <div class="card-content table-full-width">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Предприятие</th>
                                        <th>Пользователь</th>
                                        <th class="text-right">Рейтинг</th>
                                        <th class="text-right">Заголовок</th>
                                        <th class="text-right">Текст</th>
                                        <th class="text-right">Публикация</th>
                                        <th class="text-right">Создано</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reviews as $review)
                                    <tr>
                                        <td>{{ $review->id  }}</td>
                                        <td>{{ $review->partnername }}</td>
                                        <td>{{ $review->username }}</td>
                                        <td class="text-right"><i class="fa fa-star"></i> {{ $review->rating }}</td>
                                        <td class="text-right">{{ $review->title }}</td>
                                        <td class="text-right">{{ $review->description }}</td>
                                        <td class="text-right">
                                            @if($review->published == 1)
                                            <form action="{{ route('dashboard.agent.disapprove-review.post') }}" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="review_id" value="{{ $review->id }}">
                                                <input type="hidden" name="approved_by" value="{{ Auth::user()->id }}">
                                                <button class="btn btn-wd btn-success btn-square" type="submit"><span class="btn-label">
                                                    <i class="fa fa-check"></i>
                                                </span> Опубликовано</button>
                                            </form>
                                            @elseif($review->published == 0)
                                            <form action="{{ route('dashboard.agent.approve-review.post') }}" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="review_id" value="{{ $review->id }}">
                                                <input type="hidden" name="approved_by" value="{{ Auth::user()->id }}">
                                                <button class="btn btn-danger btn-fill btn-wd btn-square" type="submit">Опубликовать</button>
                                            </form>
                                            @endif
                                        </td>
                                        <td class="text-right">{{ $review->created_at }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-center">
                                <?php echo $reviews->render(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 hidden-lg">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Операции</h4>
                        </div>
                        <div class="card-content">
                            <div class="bootstrap-table">
                                <div class="fixed-table-container" style="padding-bottom:0px;">
                                    <div class="fixed-table-body">
                                        <table class="table table-hover">
                                            <tbody>
                                                @foreach ($reviews as $review)
                                                <tr>
                                                    <td colspan="9">
                                                        <div class="card-view"><span class="title" style="">#</span><span class="value pull-right">{{ $review->id }}</span>
                                                        </div>
                                                        <div class="card-view"><span class="title" style="">Предприятие</span><span class="value pull-right">{{ $review->partnername }}</span>
                                                        </div>
                                                        <div class="card-view"><span class="title" style="">Пользователь</span><span class="value pull-right">{{ $review->username }}</span>
                                                        </div>
                                                        <div class="card-view"><span class="title" style="">Рейтинг</span><span class="value pull-right"><i class="fa fa-star"></i> {{ $review->rating }}</span>
                                                        </div>
                                                        <div class="card-view"><span class="title" style="">Заголовок</span><span class="value pull-right">{{ $review->title }}</span>
                                                        </div>
                                                        <div class="card-view"><span class="title" style="">Текст</span><span class="value pull-right">{{ $review->description }}</span>
                                                        <div class="card-view"><span class="title" style="">Публикация</span><span class="value pull-right">                                            @if($review->published == 1)
                                            <form action="{{ route('dashboard.agent.disapprove-review.post') }}" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="review_id" value="{{ $review->id }}">
                                                <input type="hidden" name="approved_by" value="{{ Auth::user()->id }}">
                                                <button class="btn btn-wd btn-success" type="submit"><span class="btn-label">
                                                    <i class="fa fa-check"></i>
                                                </span> Опубликовано</button>
                                            </form>
                                            @elseif($review->published == 0)
                                            <form action="{{ route('dashboard.agent.approve-review.post') }}" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="review_id" value="{{ $review->id }}">
                                                <input type="hidden" name="approved_by" value="{{ Auth::user()->id }}">
                                                <button class="btn btn-danger btn-fill btn-wd" type="submit">Опубликовать</button>
                                            </form>
                                            @endif</span>
                                                        </div>
                                                        <br>
                                                        <div class="card-view"><span class="title" style="">Создано</span><span class="value pull-right">{{ $review->created_at }}</span>
                                                        </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="text-center">
                                            <?php echo $reviews->render(); ?>
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
