@component('mail::message')
<h1>{{ $client }}</h1>
{!! $text !!}

@component('mail::button', ['url' =>  $client_email ])
Перейти на сайт {{ $client }}
@endcomponent

<hr>
Вы получили данное письмо, т.к. являетесь пользователем карты ЕТК и зарегистрированы в личном кабинете.
Если Вы не хотите получать подобные рассылки, Вы можете отказаться от получения в <a href="https://etk21.ru/profile/settings">личном кабинете ЕТК</a>.
@endcomponent
