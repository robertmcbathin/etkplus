            <footer class="footer">
                <div class="container-fluid">
                    <nav class="pull-left">
                        <ul>
                            <li>
                                <a href="/">
                                    Портал
                                </a>
                            </li>

                            @isset($manager)
                            <li>
                                <a href="#" data-toggle="modal" data-target="#call-manager-modal">Связаться с менеджером</a>
                            </li>
                            @endisset
                        </ul>
                    </nav>
                    <div class="copyright pull-right">
                        &copy; <script>document.write(new Date().getFullYear())</script>, <a href="https://etk21.ru">Единая транспортная карта</a>
                    </div>
                </div>
            </footer>
@isset($manager)
<div class="modal fade" id="call-manager-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Связаться с менеджером</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-2">
                        <img src="https://etk21.ru{{ $manager->profile_image }}" class="img img-rounded img-responsive" ">
                    </div>
                    <div class="col-md-10">
                        <h6>{{ $manager->name }} {{ $manager->lastname }}</h6>
                        <p>тел.: <b>{{ $manager->phone }}</b></p>
                        <p>email: <b>{{ $manager->email }}</b></p>
                    </div>
                </div>    

            </div>
    </div>
</div>
</div>
@endisset