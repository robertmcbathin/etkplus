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
                <div class="col-md-12">


                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Операции</h4>
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
                                        <th>{{ $review->id  }}</th>
                                        <th>{{ $review->partnername }}</th>
                                        <th>{{ $review->username }}</th>
                                        <th class="text-right"><i class="fa fa-star"></i> {{ $review->rating }}</th>
                                        <th class="text-right">{{ $review->title }}</th>
                                        <th class="text-right">{{ $review->description }}</th>
                                        <th class="text-right">
                                            @if($review->published == 1)
                                            <form action="{{ route('dashboard.disapprove-review.post') }}" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="review_id" value="{{ $review->id }}">
                                                <input type="hidden" name="approved_by" value="{{ Auth::user()->id }}">
                                                <button class="btn btn-wd btn-success" type="submit"><span class="btn-label">
                                                    <i class="fa fa-check"></i>
                                                </span> Опубликовано</button>
                                            </form>
                                            @elseif($review->published == 0)
                                            <form action="{{ route('dashboard.approve-review.post') }}" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="review_id" value="{{ $review->id }}">
                                                <input type="hidden" name="approved_by" value="{{ Auth::user()->id }}">
                                                <button class="btn btn-danger btn-fill btn-wd" type="submit">Опубликовать</button>
                                            </form>
                                            @endif
                                        </th>
                                        <th class="text-right">{{ $review->created_at }}</th>
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
        @include('includes.dashboard.footer')
    </div>
</div>


@endsection
