<footer class="footer footer-black footer-big">

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-4">
                <div class="logo text-center">
                    <h3>ЕТКплюс</h3>
                </div>
            </div>
            <div class="col-md-8 col-sm-8">
                <div class="links">
                    <ul>
                        <li>
                            <a href="/about">
                                О проекте
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('site.show-categories.get') }}">
                               Партнерская сеть
                           </a>
                       </li>
                       <li>
                        <a href="">
                           Личный кабинет
                       </a>
                   </li>
                   <li>
                    <a href="" data-toggle="modal" data-target="#billing-choice">
                       Оплата услуг
                   </a>
               </li>
               <li>
                <a href="">
                   Сотрудничество
               </a>
           </li>
           <li>
            <a href="{{ route('login') }}">
                Вход для партнеров
            </a>
        </li>
    </ul>
    <hr>
    <div class="copyright">
        <div class="pull-left">
           Все права защищены © <script>document.write(new Date().getFullYear())</script> ЕТКплюс
       </div>
       <div class="pull-right">
        <ul>
            <li>
                <a href="">
                    Политика конфиденциальности
                </a>
            </li>
            |
            <li>
                <a href="">
                    Пользовательское соглашение
                </a>
            </li>
        </ul>
    </div>
</div>
</div>
</div>
</div>

</div>
</footer>
<div class="modal fade" id="billing-choice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-notice">
        <div class="modal-content">
            <div class="modal-header no-border-header">
                <h5 class="modal-title" id="myModalLabel">Доступны следующие способы оплаты услуг</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="instruction">
                    <div class="row">
                        <div class="col-md-8">
                            <p> <strong>1. Банковская карта</strong> - оплата производится через процессинговый центр <a href="http://uniteller.ru/">Uniteller</a>. Пополнение происходит моментально.</p>
                        </div>
                        <div class="col-md-4">
                            <div class="picture">
                                <img src="assets/img/sections/angelo-pantazis.jpg" alt="Thumbnail Image" class="img-rounded img-responsive">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="instruction">
                    <div class="row">
                        <div class="col-md-8">
                            <p> <strong>2. Счет для оплаты в банке (только для юрлиц и ИП). </strong> Если Вам удобнее проводить оплату безналичным расчетом, Вы можете выписать счет для оплаты. Пополнение происходит в течение 3-х рабочих дней.</p>
                        </div>
                        <div class="col-md-4">
                            <div class="picture">
                                <img src="assets/img/sections/rawpixel-coms.jpg" alt="Thumbnail Image" class="img-rounded img-responsive">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <div class="left-side">
                    <button type="button" class="btn btn-danger btn-link" data-dismiss="modal" data-toggle="modal" data-target="#billing-choice-invoice"><i class="fa fa-credit-card"></i> Оплатить картой</button>
                </div>
                <div class="divider"></div>
                <div class="right-side">
                    <button type="button" class="btn btn-danger btn-link" data-dismiss="modal" data-toggle="modal" data-target="#billing-choice-invoice"><i class="fa fa-file"></i> Выписать счет</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="billing-choice-invoice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-notice">
        <div class="modal-content">
            <div class="modal-header no-border-header">
                <h5 class="modal-title" id="myModalLabel">Выписать счет на оплату</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            @if (Auth::user())
            @if ((Auth::user()->role_id == 21) || (Auth::user()->role_id == 22))
            <div class="modal-body">
                <div class="instruction">
                    <div class="row">
                        <div class="col-md-8">
                         <div class="form-group">
                            <input type="text" value="" placeholder="Simple" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="picture">
                            <img src="assets/img/sections/angelo-pantazis.jpg" alt="Thumbnail Image" class="img-rounded img-responsive">
                        </div>
                    </div>
                </div>
            </div>
            <div class="instruction">
                <div class="row">
                    <div class="col-md-12">
                        <p> <strong>2. Счет для оплаты в банке (только для юрлиц и ИП). </strong> Если Вам удобнее проводить оплату безналичным расчетом, Вы можете выписать счет для оплаты. Пополнение происходит в течение 3-х рабочих дней.</p>
                    </div>
                    <div class="col-md-4">
                        <div class="picture">
                            <img src="assets/img/sections/rawpixel-coms.jpg" alt="Thumbnail Image" class="img-rounded img-responsive">
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="modal-footer">

        </div>
        @endif
        @else
        <div class="modal-body">
            <form action="{{ route('site.create-invoice.post') }}" method="POST">
                {{ csrf_field() }}
            <div class="instruction">
                <div class="row">
                    <p>Номер договора</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id='index-bill-form-group' class="form-group">
                            <input type="text" class="form-control form-control-danger" name="contract_id" id="index-bill-contract-id" placeholder="00000" value="">
                            <div id="index-bill-control-feedback" class="form-control-feedback"><small id="index-bill-notice"></small></div>
                        </div>
                        <br>
                        .
                    </div>
                </div>
                <div class="row">
                    <p>Полное наименование</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                    <div class="form-group">
                            <input type="text" name="name" value="" placeholder="ООО ..." minlength="5" maxlength="255" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                     <p>Реквизиты</p>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="inn" value="" placeholder="ИНН" minlength="10" maxlength="12" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="kpp" value="" placeholder="КПП" minlength="9" maxlength="9" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                     <p>Юридический адрес</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" name="legal_address" value="" placeholder="428000, ..." minlength="10" maxlength="255" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                     <p>Номер телефона</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" name="phone" value="" placeholder="+7" minlength="6" maxlength="50" class="form-control" required>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                     <p>Сумма (в рублях)</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" name="value" value="" placeholder="" minlength="2" maxlength="6" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <button type="submit" id="index-bill-submit" class="btn btn-danger btn-fill btn-round" style="width:100%;" disabled>Выписать счет</button>
                </div>
            </div>
        </form>
        </div>
        @endif
    </div>
</div>
</div>
<script>
    var checkContractIdUrl = '{{ route('ajax.check-contract-id') }}';
    var token = '{{ Session::token() }}';
</script>

