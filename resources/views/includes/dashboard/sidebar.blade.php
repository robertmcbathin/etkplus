        <div class="sidebar"  data-active-color="danger" data-background-color="brown">
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
                                {{ Auth::user()->name }} {{ Auth::user()->lastname }}
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

                    <li @if (Request::path() == 'dashboard/companies/list') class="active" @endif>
                        <a href="{{ route('dashboard.show-companies-list.get') }}">
                            <i class="fa fa-address-book"></i>
                            <p>Контрагенты</p>
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
                    <li @if (Request::path() == 'agent/dashboard') class="active" @endif>
                        <a href="{{ route('dashboard.agent.show-dashboard.get') }}">
                            <i class="fa fa-area-chart"></i>
                            <p>Панель управления</p>
                        </a>
                    </li>

                    <li @if (Request::path() == 'agent/dashboard/operations') class="active" @endif>
                        <a href="{{ route('dashboard.agent.show-operations.get') }}">
                            <i class="fa fa-handshake-o"></i>
                            <p>Операции</p>
                        </a>
                    </li>

                    <li @if (Request::path() == 'agent/dashboard/partners/list') class="active" @endif>
                        <a href="{{ route('dashboard.agent.show-partner-list.get') }}">
                            <i class="fa fa-building"></i>
                            <p>Предприятия</p>
                        </a>
                    </li>

                    <li @if (Request::path() == 'agent/dashboard/billing') class="active" @endif>
                        <a href="{{ route('dashboard.agent.billing.get') }}">
                            <i class="fa fa-money"></i>
                            <p>Оплата услуг</p>
                        </a>
                    </li>

                    <li @if (Request::path() == 'agent/dashboard/salary') class="active" @endif>
                        <a href="{{ route('dashboard.agent.salary.get') }}">
                            <i class="fa fa-suitcase"></i>
                            <p>Мои начисления</p>
                        </a>
                    </li>

                    <li @if (Request::path() == 'agent/dashboard/show-reviews') class="active" @endif>
                        <a href="{{ route('dashboard.agent.show-reviews.get') }}">
                            <i class="fa fa-comments"></i>
                            <p>Отзывы</p>
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

                  <!--  <li @if (Request::path() == 'control-panel/show-reviews') class="active" @endif>
                        <a href="{{ route('dashboard.partner.show-reviews.get') }}">
                            <i class="fa fa-comments"></i>
                            <p>Отзывы</p>
                        </a>
                    </li> -->

                    @endcan
                    @can('show-dashboard-partner-admin')
                    <li @if (Request::path() == 'control-panel/show-operators') class="active" @endif>
                        <a href="{{ route('dashboard.partner.show-operators-list.get') }}">
                            <i class="fa fa-user"></i>
                            <p>Операторы</p>
                        </a>
                    </li>

                    @endcan
                    <!-- SHOP ADMIN -->
                    @can('show-dashboard-admin')
                    <hr>
                    <li>
                        <a href="#">
                            <p>ETKTRADE</p>
                        </a>
                    </li>
                    <li @if (Request::path() == 'dashboard/shop/categories') class="active" @endif>
                        <a href="">
                            <i class="fa fa-list"></i>
                            <p>Категории</p>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="collapse" href="#sb-categories">
                            <i class="fa fa-list"></i>
                            <p>
                                Категории
                               <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="sb-categories">
                            <ul class="nav">
                                <li>
                                    <a href="{{ route('dashboard.shop.show-categories.get', ['level' => 1]) }}">
                                        <span class="sidebar-mini">L1</span>
                                        <span class="sidebar-normal">Уровень 1</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('dashboard.shop.show-categories.get', ['level' => 2]) }}">
                                        <span class="sidebar-mini">L2</span>
                                        <span class="sidebar-normal">Уровень 2</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('dashboard.shop.show-categories.get', ['level' => 3]) }}">
                                        <span class="sidebar-mini">L3</span>
                                        <span class="sidebar-normal">Уровень 3</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li @if (Request::path() == 'dashboard/shop/shops') class="active" @endif>
                        <a href="{{ route('dashboard.shop.show-shops.get') }}">
                            <i class="fa fa-shopping-cart"></i>
                            <p>Магазины</p>
                        </a>
                    </li>
                    <li @if (Request::path() == 'dashboard/shop/goods') class="active" @endif>
                        <a href="{{ route('dashboard.shop.show-goods.get') }}">
                            <i class="fa fa-archive"></i>
                            <p>Товары</p>
                        </a>
                    </li>
                    <li @if (Request::path() == 'dashboard/shop/brands') class="active" @endif>
                        <a href="{{ route('dashboard.shop.show-brands.get') }}">
                            <i class="fa fa-copyright"></i>
                            <p>Бренды</p>
                        </a>
                    </li>
                    @endcan
                    <!-- END SHOP ADMIN -->

                    <!-- SHOP PARTNER -->
                    @can('show-dashboard-partner-admin-shop')
                    <hr>
                    <li>
                        <a href="#">
                            <p>МАГАЗИН</p>
                        </a>
                    </li>
                    <li @if (Request::path() == 'control-panel/shop/products') class="active" @endif>
                        <a href="{{ route('dashboard.partner.shop.show-products.get') }}">
                            <i class="fa fa-archive"></i>
                            <p>Товары</p>
                        </a>
                    </li>
                    @endcan
                    <!-- END SHOP PARTNER -->
                </ul>
                

            </div>
        </div>