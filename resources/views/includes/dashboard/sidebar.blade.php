        <div class="sidebar"  data-active-color="danger">
            <div class="logo">

            </div>
            <div class="sidebar-wrapper">
                <div class="user">
                    <div class="info">
                        <div class="photo">
                            <img src="{{ Auth::user()->profile_image }}" />
                        </div>

                        <a data-toggle="collapse" href="#logout" class="collapsed">
                            <span>
                                {{ Auth::user()->name }}
                                <b class="caret"></b>
                            </span>
                        </a>
                        <div class="clearfix"></div>

                        <div class="collapse" id="logout">
                            <ul class="nav">
                                <li>
                                    <a href="{{ route('logout') }}">
                                        <span class="sidebar-normal text-center"> <i class="fa fa-sign-out"></i> Выход</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <ul class="nav" id="sidebar-nav">
                @can('show-dashboard-admin')
                    <li @if (Request::path() == 'dashboard') class="active" @endif>
                        <a href="{{ route('dashboard.show-dashboard.get') }}">
                            <i class="fa fa-area-chart"></i>
                            <p>Панель управления</p>
                        </a>
                    </li>

                    <li @if (Request::path() == 'dashboard/operations') class="active" @endif>
                        <a href="{{ route('dashboard.show-operations.get') }}">
                            <i class="fa fa-handshake-o"></i>
                            <p>Операции</p>
                        </a>
                    </li>

                    <li @if (Request::path() == 'dashboard/categories/list') class="active" @endif>
                        <a href="{{ route('dashboard.show-category-list.get') }}">
                            <i class="fa fa-list"></i>
                            <p>Категории</p>
                        </a>
                    </li>

                    <li @if (Request::path() == 'dashboard/partners/list') class="active" @endif>
                        <a href="{{ route('dashboard.show-partner-list.get') }}">
                            <i class="fa fa-building"></i>
                            <p>Предприятия</p>
                        </a>
                    </li>

                     <li @if (Request::path() == 'dashboard/users/list') class="active" @endif>
                        <a href="{{ route('dashboard.show-user-list.get') }}">
                            <i class="fa fa-user"></i>
                            <p>Пользователи</p>
                        </a>
                    </li>

                     <li @if (Request::path() == 'dashboard/billing') class="active" @endif>
                        <a href="{{ route('dashboard.show-billing-page.get') }}">
                            <i class="fa fa-money"></i>
                            <p>Оплата услуг</p>
                        </a>
                    </li>

                     <li @if (Request::path() == 'dashboard/salary') class="active" @endif>
                        <a href="{{ route('dashboard.show-salary-page.get') }}">
                            <i class="fa fa-credit-card-alt"></i>
                            <p>Выплата агентам</p>
                        </a>
                    </li>

                    <li @if (Request::path() == 'dashboard/reviews/list') class="active" @endif>
                        <a href="{{ route('dashboard.show-review-list.get') }}">
                            <i class="fa fa-comments"></i>
                            <p>Отзывы</p>
                        </a>
                    </li>

                    <li @if (Request::path() == 'dashboard/tariffs/list') class="active" @endif>
                        <a href="{{ route('dashboard.show-tariff-list.get') }}">
                            <i class="fa fa-tasks"></i>
                            <p>Тарифы</p>
                        </a>
                    </li>

                    <li @if (Request::path() == 'dashboard/emails') class="active" @endif>
                        <a href="{{ route('dashboard.show-emails-distribution.get') }}">
                            <i class="fa fa-envelope"></i>
                            <p>Рассылки</p>
                        </a>
                    </li>

                 <!--   <li @if (Request::path() == 'dashboard/chat') class="active" @endif>
                        <a href="{{ route('dashboard.show-chat.get') }}">
                            <i class="fa fa-envelope"></i>
                            <p>Чат</p>
                        </a>
                    </li> -->

                    <li @if (Request::path() == 'dashboard/log') class="active" @endif>
                        <a href="{{ route('dashboard.show-log.get') }}">
                            <i class="fa fa-align-justify"></i>
                            <p>Лог</p>
                        </a>
                    </li>

                @endcan

                @can('show-dashboard-agent')
                    <li @if (Request::path() == 'dashboard') class="active" @endif>
                        <a href="{{ route('dashboard.show-dashboard.get') }}">
                            <i class="fa fa-area-chart"></i>
                            <p>Панель управления</p>
                        </a>
                    </li>

                    <li @if (Request::path() == 'dashboard/operations') class="active" @endif>
                        <a href="{{ route('dashboard.show-operations.get') }}">
                            <i class="fa fa-handshake-o"></i>
                            <p>Операции</p>
                        </a>
                    </li>

                    <li @if (Request::path() == 'dashboard/partners/list') class="active" @endif>
                        <a href="{{ route('dashboard.show-partner-list.get') }}">
                            <i class="fa fa-building"></i>
                            <p>Предприятия</p>
                        </a>
                    </li>

                    <li @if (Request::path() == 'dashboard/cards/list') class="active" @endif>
                        <a href="{{ route('dashboard.show-card-list.get') }}">
                            <i class="fa fa-credit-card"></i>
                            <p>Карты</p>
                        </a>
                    </li>


                     <li @if (Request::path() == 'dashboard/cards/list') class="active" @endif>
                        <a href="{{ route('dashboard.show-card-list.get') }}">
                            <i class="fa fa-money"></i>
                            <p>Оплата услуг</p>
                        </a>
                    </li>

                @endcan

                @can('show-dashboard-partner')
                    <li @if (Request::path() == 'control-panel') class="active" @endif>
                        <a href="{{ route('dashboard.partner.show-dashboard.get') }}">
                            <i class="fa fa-area-chart"></i>
                            <p>Панель управления</p>
                        </a>
                    </li>

                    <li @if (Request::path() == 'control-panel/show-operations') class="active" @endif>
                        <a href="{{ route('dashboard.partner.show-operations.get') }}">
                            <i class="fa fa-handshake-o"></i>
                            <p>Операции</p>
                        </a>
                    </li>
                    <li @if (Request::path() == 'control-panel/billing') class="active" @endif>
                        <a href="{{ route('dashboard.partner.billing.get') }}">
                            <i class="fa fa-money"></i>
                            <p>Оплата услуг</p>
                        </a>
                    </li>
                    <li @if (Request::path() == 'control-panel/show-reviews') class="active" @endif>
                        <a href="{{ route('dashboard.partner.show-reviews.get') }}">
                            <i class="fa fa-comments"></i>
                            <p>Отзывы</p>
                        </a>
                    </li>

                @endcan
                @can('show-dashboard-partner-admin')
                    <li @if (Request::path() == 'control-panel/show-operators') class="active" @endif>
                        <a href="{{ route('dashboard.partner.show-operators-list.get') }}">
                            <i class="fa fa-user"></i>
                            <p>Операторы</p>
                        </a>
                    </li>
                    <li @if (Request::path() == 'control-panel/show-operators') class="active" @endif>
                        <a href="{{ route('dashboard.partner.show-operators-list.get') }}">
                            <i class="fa fa-wrench"></i>
                            <p>Настройки</p>
                        </a>
                    </li>
                @endcan
                </ul>
            </div>
        </div>