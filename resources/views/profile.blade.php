@extends('layouts.master')
@section('description')
@endsection
@section('keywords')
@endsection
@section('title')
{{ $user->name }}
@endsection
@section('content')
<div class="wrapper">

  <div class="page-header page-header-xs filter pattern-image" style="background-image: url('../assets/img/sections/etkplus-bg2.jpg');">
    <div class="content-center">
    </div>
  </div>        
</div>
<div class="profile-content section-white-gray">
  <div class="container">
    <div class="row owner">
      <div class="col-md-2 offset-md-5 col-sm-4 offset-md-4 col-xs-6 offset-md-3 text-center">
        <div class="avatar">
          <img src="https://etk21.ru{{ $user->profile_image }}" alt="{{ $user->name }}" class="img-circle img-responsive">
        </div>

        <div class="name">
          <h4>{{ $user->name }}</h4>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 offset-md-3 text-center">
        <div class="description-details">
          <ul class="list-unstyled">
          </ul>
        </div>
      </div>
    </div>

    @if ($auth_user_id == $user->id)
    <!-- PROFILE TABS -->
    <div class="profile-tabs">
      <div class="nav-tabs-navigation">
        <div class="nav-tabs-wrapper">
          <ul id="tabs" class="nav nav-tabs" role="tablist">
            <li class="nav-item ">
              <a class="nav-link active" href="#tweets" data-toggle="tab" role="tab">Лента</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#connections" data-toggle="tab" role="tab">Бонусы</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#media" data-toggle="tab" role="tab">Накопительная система</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#media" data-toggle="tab" role="tab">Кэшбэк</a>
            </li>
          </ul>
        </div>
      </div>

      <div id="my-tab-content" class="tab-content">
        <div class="tab-pane active" id="tweets" role="tabpanel">
          <div class="row">
            <div class="col-md-8">
              <div class="tweets">
                <div class="media">
                  <a class="pull-left" href="#paper-kit">
                   <div class="avatar">
                    <img class="media-object" src="../assets/img/rihanna.jpg" alt="...">
                  </div>
                </a>
                <div class="media-body">
                  <strong>Rihanna</strong>
                  <h5 class="media-heading"><small>@rihanna · 1h</small></h5>
                  <p>It's just beyond the vault. Discover room 7 of the <a href="javascript: void(0);" class="link-danger">#ANTIdiaRy</a> at <a href="" class="link-info">http://smarturl.it/AntidiaRyTW</a></p>

                  <div class="media-footer">
                    <a href="#paper-kit" class="btn btn-link">
                     <i class="fa fa-reply"></i>
                   </a>
                   <a href="#paper-kit" class="btn btn-success btn-link">
                     <i class="fa fa-retweet"></i> 2.1k
                   </a>
                   <a href="#paper-kit" class="btn btn-danger btn-link">
                     <i class="fa fa-heart"></i> 3.2k
                   </a>
                   <div class="dropdown">
                    <button id="dLabel" type="button" class="btn btn-just-icon btn-link btn-lg" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fa fa-ellipsis-h"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                      <li class="dropdown-item">
                        <a href="#paper-kit">
                          <div class="row">
                            <div class="col-sm-2">
                              <span class="icon-simple"><i class="fa fa-envelope"></i></span>
                            </div>
                            <div class="col-sm-9">Direct Message</div>
                          </div>
                        </a>
                      </li>
                      <div class="dropdown-divider"></div>
                      <li class="dropdown-item">
                        <a href="#paper-kit">
                          <div class="row">
                            <div class="col-sm-2">
                              <span class="icon-simple"><i class="fa fa-microphone-slash"></i></span>
                            </div>
                            <div class="col-sm-9">Mute</div>
                          </div>
                        </a>
                      </li>
                      <div class="dropdown-divider"></div>
                      <li class="dropdown-item">
                        <a href="#paper-kit">
                          <div class="row">
                            <div class="col-sm-2">
                              <span class="icon-simple"><i class="fa fa-exclamation-circle"></i></span>
                            </div>
                            <div class="col-sm-9">Report</div>
                          </div>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>

              </div>
            </div> <!-- end media -->

            <div class="media">
              <a class="pull-left" href="#paper-kit">
                <div class="avatar">
                 <img class="media-object" alt="Tim Picture" src="../assets/img/khaled.jpg">
               </div>
               <div class="retweet">
                <btn class="btn btn-xs btn-success btn-just-icon btn-sm" rel="tooltip" title="Follow"><i class="fa fa-retweet"></i></btn>
              </div>
            </a>
            <div class="media-body">
              <strong>DJ KHALED</strong>
              <h5 class="media-heading"><small>@djkhaled ·  6 Jan 2016</small></h5>
              <p><a href="#paper-kit" class="link-danger">#LA</a> fan luv I'm be <a href="#paper-kit" class="link-info">@1oakla</a> tonight i want see fan luv let's win more ! <a href="#paper-kit" class="link-danger">#wethebest</a> </p>
              <div class="tweet-link">
                <div class="row">
                  <div class="col-md-4">
                    <img src="../assets/img/khaled_tweet.png" alt="Rounded Image" class="img-rounded img-tweet-link img-responsive">
                  </div>
                  <div class="col-md-8">
                    <strong>Let's win more by DJ Khaled</strong>
                    <a href="#0"><p>This is a 3-day event hosted by DJ Khaled for his fan luv in LA. Major 🔑 to success. Bless up!</p>
                      <small></small></a><small><a href="#paper-kit" class="text-muted">djkhaled.com</a></small>
                    </div>
                  </div>
                </div>



                <div class="media-footer">
                  <a href="#paper-kit" class="btn btn-link">
                   <i class="fa fa-reply"></i>
                 </a>
                 <a href="#paper-kit" class="btn btn-link">
                   <i class="fa fa-retweet"></i> 100
                 </a>
                 <a href="#paper-kit" class="btn btn-danger btn-link">
                   <i class="fa fa-heart"></i> 234
                 </a>
                 <div class="dropdown">
                  <button id="dLabel" type="button" class="btn btn-icon btn-link btn-lg" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-h"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-right">
                    <li class="dropdown-item">
                      <a href="#paper-kit">
                        <div class="row">
                          <div class="col-sm-2">
                            <span class="icon-simple"><i class="fa fa-envelope"></i></span>
                          </div>
                          <div class="col-sm-9">Direct Message</div>
                        </div>
                      </a>
                    </li>
                    <div class="dropdown-divider"></div>
                    <li class="dropdown-item">
                      <a href="#paper-kit">
                        <div class="row">
                          <div class="col-sm-2">
                            <span class="icon-simple"><i class="fa fa-microphone-slash"></i></span>
                          </div>
                          <div class="col-sm-9">Mute</div>
                        </div>
                      </a>
                    </li>
                    <div class="dropdown-divider"></div>
                    <li class="dropdown-item">
                      <a href="#paper-kit">
                        <div class="row">
                          <div class="col-sm-2">
                            <span class="icon-simple"><i class="fa fa-exclamation-circle"></i></span>
                          </div>
                          <div class="col-sm-9">Report</div>
                        </div>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div> <!-- end media -->
          <div class="media">
            <a class="pull-left" href="#paper-kit">
              <div class="avatar">
               <img class="media-object" alt="Tim Picture" src="../assets/img/rihanna.jpg">
             </div>
           </a>
           <div class="media-body">
            <strong>Rihanna</strong>
            <h5 class="media-heading"><small>@rihanna ·  8 Jan 2016</small></h5>
            <p>bitch better have my mistletoe <a href="#paper-kit" class="link-danger">#rihannaxstance</a> </p>
            <img src="../assets/img/rihanna_tweet.jpeg" alt="Rounded Image" class="img-rounded img-tweet">


            <div class="media-footer">
              <a href="#paper-kit" class="btn btn-link">
               <i class="fa fa-reply"></i>
             </a>
             <a href="#paper-kit" class="btn btn-link">
               <i class="fa fa-retweet"></i> 5.8K
             </a>
             <a href="#paper-kit" class="btn btn-danger btn-link">
               <i class="fa fa-heart"></i> 12K
             </a>
             <a href="#paper-kit" class="btn btn-link">
               <i class="fa fa-ellipsis-h"></i>
             </a>
           </div>
         </div>
       </div> <!-- end media -->
       <div class="media">
        <a class="pull-left" href="#paper-kit">
          <div class="avatar">
           <img class="media-object" alt="Tim Picture" src="../assets/img/rihanna.jpg">
         </div>
       </a>
       <div class="media-body">
        <strong>Rihanna</strong>
        <h5 class="media-heading"><small>@rihanna ·  9 Jan 2016</small></h5>
        <p>Thank you God for fulfilling Your plans in my life.... All the Glory belongs to You!!!! <a href="https://instagram.com/p/4m5W4sBMzj/">https://instagram.com/p/4m5W4sBMzj/</a> </p>


        <div class="media-footer">
          <a href="#paper-kit" class="btn btn-link">
           <i class="fa fa-reply"></i>
         </a>
         <a href="#paper-kit" class="btn btn-link">
           <i class="fa fa-retweet"></i> 5.9K
         </a>
         <a href="#paper-kit" class="btn btn-link">
           <i class="fa fa-heart"></i> 11K
         </a>
         <div class="dropdown">
          <button id="dLabel" type="button" class="btn btn-icon btn-link btn-lg" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-ellipsis-h"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-right">
            <li class="dropdown-item">
              <a href="#paper-kit">
                <div class="row">
                  <div class="col-sm-2">
                    <span class="icon-simple"><i class="fa fa-envelope"></i></span>
                  </div>
                  <div class="col-sm-9">Direct Message</div>
                </div>
              </a>
            </li>
            <div class="dropdown-divider"></div>
            <li class="dropdown-item">
              <a href="#paper-kit">
                <div class="row">
                  <div class="col-sm-2">
                    <span class="icon-simple"><i class="fa fa-microphone-slash"></i></span>
                  </div>
                  <div class="col-sm-9">Mute</div>
                </div>
              </a>
            </li>
            <div class="dropdown-divider"></div>
            <li class="dropdown-item">
              <a href="#paper-kit">
                <div class="row">
                  <div class="col-sm-2">
                    <span class="icon-simple"><i class="fa fa-exclamation-circle"></i></span>
                  </div>
                  <div class="col-sm-9">Report</div>
                </div>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div> <!-- end media -->
  <div class="media last-media">
    <a class="pull-left" href="#paper-kit">
      <div class="avatar">
       <img class="media-object" alt="Tim Picture" src="../assets/img/billboard.jpeg">
     </div>
     <div class="retweet">
      <btn class="btn btn-xs btn-success btn-just-icon btn-sm" rel="tooltip" title="Follow"><i class="fa fa-retweet"></i></btn>
    </div>
  </a>
  <div class="media-body">
    <strong>billboard</strong>
    <h5 class="media-heading"><small>@billboard ·  1 Jul 2016</small></h5>
    <p><a href="#paper-kit">@Rihanna</a> has become the first artist to surpass RIAA's 100 million cumulative singles award threshold: <a href="http://blbrd.cm/3rQ3Iq">http://blbrd.cm/3rQ3Iq</a> </p>

    <div class="media-footer">
      <a href="#paper-kit" class="btn btn-link">
       <i class="fa fa-reply"></i>
     </a>
     <a href="#paper-kit" class="btn btn-link">
       <i class="fa fa-retweet"></i> 5.6K
     </a>
     <a href="#paper-kit" class="btn btn-danger btn-link">
       <i class="fa fa-heart"></i> 7.2K
     </a>
     <div class="dropdown">
      <button id="dLabel" type="button" class="btn btn-icon btn-link btn-lg" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-ellipsis-h"></i>
      </button>
      <ul class="dropdown-menu dropdown-menu-right">
        <li class="dropdown-item">
          <a href="#paper-kit">
            <div class="row">
              <div class="col-sm-2">
                <span class="icon-simple"><i class="fa fa-envelope"></i></span>
              </div>
              <div class="col-sm-9">Direct Message</div>
            </div>
          </a>
        </li>
        <li class="dropdown-item">
          <a href="#paper-kit">
            <div class="row">
              <div class="col-sm-2">
                <span class="icon-simple"><i class="fa fa-microphone-slash"></i></span>
              </div>
              <div class="col-sm-9">Mute</div>
            </div>
          </a>
        </li>
        <li class="dropdown-item">
          <a href="#paper-kit">
            <div class="row">
              <div class="col-sm-2">
                <span class="icon-simple"><i class="fa fa-exclamation-circle"></i></span>
              </div>
              <div class="col-sm-9">Report</div>
            </div>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>
</div> <!-- end media -->
<br>
<div class="text-center">
 <btn class="btn btn-outline-info btn-round">Load more tweets</btn>
</div>
</div>

</div>
<div class="col-md-4 col-sm-6">
  <div class="card card-with-shadow">
    <div class="card-block">
      <h5 class="card-title">Who to follow · <small><a href="javascript: void(0);" class="link-info">View all</a></small></h5>
      <div class="accounts-suggestion">
        <ul class="list-unstyled">
          <li class="account">
            <div class="row">
              <div class="col-md-3">
                <div class="avatar">
                  <img src="../assets/img/chet_faker_1.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                </div>
              </div>
              <div class="col-md-7 description-section">
                Chet Faker <a href="#paper-kit" class="text-muted">@chetfaker</a>
                <br>
                <span class="text-muted"><small>Followed by <a href="#paper-kit" class="link-info">@banks</a> and <a href="#paper-kit" class="link-info">@rihanna</a> </small></span>
              </div>

              <div class="col-md-2 follow">
                <btn class="btn btn-sm btn-outline-info btn-just-icon"><i class="fa fa-plus"></i></btn>
              </div>
            </div>
          </li>
          <li class="account">
            <div class="row">
              <div class="col-md-3">
                <div class="avatar">
                  <img src="../assets/img/placeholder.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                </div>
              </div>
              <div class="col-md-7 description-section">
                John Green <a href="#paper-kit" class="text-muted">@johngreen</a>
                <br>
                <span class="text-muted"><small>Followed by <a href="#paper-kit" class="link-info">@rihanna</a> </small></span>
              </div>

              <div class="col-md-2 follow">
                <btn class="btn btn-sm btn-outline-info btn-just-icon"><i class="fa fa-plus"></i></btn>
              </div>
            </div>
          </li>
          <li class="account">
            <div class="row">
              <div class="col-md-3">
                <div class="avatar">
                  <img src="../assets/img/drake.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                </div>
              </div>
              <div class="col-md-7 description-section">
                Drake <a href="#paper-kit" class="text-muted">@drake</a>
                <br>
                <span class="text-muted"><small>Followed by <a href="#paper-kit" class="link-info">@chetfaker</a> </small></span>
              </div>

              <div class="col-md-2 follow">
                <btn class="btn btn-sm btn-outline-info btn-just-icon"><i class="fa fa-plus"></i></btn>
              </div>
            </div>
          </li>
        </ul>
      </div>

    </div>
  </div> <!-- end card -->
  <div class="card card-with-shadow">
    <div class="card-block">
      <h5 class="card-title">Trends · <small><a href="javascript: void(0);" class="link-info">Change</a></small></h5>
      <div class="hashtag-suggestions">
        <ul class="list-unstyled">
          <li><a href="#paper-kit" class="link-danger">#JeSuisToujoursCharlie</a></li>
          <li><a href="#paper-kit">Oculus Rift</a></li>
          <li><a href="#paper-kit" class="link-danger">#CarenAndLarryAreNotReal</a></li>
          <li><a href="#paper-kit" class="link-danger">#Twitter10k</a></li>
          <li><a href="#paper-kit">EXCLUSIVE MOVE WITHINGTON</a></li>
          <li><a href="#paper-kit">London</a>
          </li><li><a href="#paper-kit">DJ Khaled Snapchat</a>
        </li></ul>
      </div>

    </div>
  </div> <!-- end card -->
</div>
</div>
</div>

<div class="tab-pane text-center" id="connections" role="tabpanel"></div>

<div class="tab-pane" id="media" role="tabpanel"></div>
</div>

</div>








<!-- END PROFILE TABS -->
@else
<div class="row">
  <div class="col-md-8">
    <div class="tweets">
    <h5 class="card-title">Последние отзывы</h5>

    @foreach ($reviews as $review)
      <div class="media">
        <a class="pull-left" href="{{route('site.show-partner.get', $review->partner_id) }}">
         <div class="avatar">
          <img class="media-object" src="{{ $review->logo }}" alt="{{ $review->name }}">
        </div>
      </a>
      <div class="media-body">
        <h5 class="media-heading">{{ $review->title }} <small>{{ $review->created_at }} </small></h5>
        <p>{{ $review->description }}</p>

        <div class="media-footer">
         <a href="t" class="btn btn-danger btn-link">
           <i class="fa fa-star"></i> {{ $review->rating }}
         </a>
      </div>

    </div>
  </div> <!-- end media -->
  @endforeach

<br>
<div class="text-center">
 <btn class="btn btn-outline-info btn-round">Load more tweets</btn>
</div>
</div>

</div>
<div class="col-md-4 col-sm-6">
  <div class="card card-with-shadow">
    <div class="card-block">
      <h5 class="card-title">Who to follow · <small><a href="javascript: void(0);" class="link-info">View all</a></small></h5>
      <div class="accounts-suggestion">
        <ul class="list-unstyled">
          <li class="account">
            <div class="row">
              <div class="col-md-3">
                <div class="avatar">
                  <img src="../assets/img/chet_faker_1.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                </div>
              </div>
              <div class="col-md-7 description-section">
                Chet Faker <a href="#paper-kit" class="text-muted">@chetfaker</a>
                <br>
                <span class="text-muted"><small>Followed by <a href="#paper-kit" class="link-info">@banks</a> and <a href="#paper-kit" class="link-info">@rihanna</a> </small></span>
              </div>

              <div class="col-md-2 follow">
                <btn class="btn btn-sm btn-outline-info btn-just-icon"><i class="fa fa-plus"></i></btn>
              </div>
            </div>
          </li>
          <li class="account">
            <div class="row">
              <div class="col-md-3">
                <div class="avatar">
                  <img src="../assets/img/placeholder.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                </div>
              </div>
              <div class="col-md-7 description-section">
                John Green <a href="#paper-kit" class="text-muted">@johngreen</a>
                <br>
                <span class="text-muted"><small>Followed by <a href="#paper-kit" class="link-info">@rihanna</a> </small></span>
              </div>

              <div class="col-md-2 follow">
                <btn class="btn btn-sm btn-outline-info btn-just-icon"><i class="fa fa-plus"></i></btn>
              </div>
            </div>
          </li>
          <li class="account">
            <div class="row">
              <div class="col-md-3">
                <div class="avatar">
                  <img src="../assets/img/drake.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                </div>
              </div>
              <div class="col-md-7 description-section">
                Drake <a href="#paper-kit" class="text-muted">@drake</a>
                <br>
                <span class="text-muted"><small>Followed by <a href="#paper-kit" class="link-info">@chetfaker</a> </small></span>
              </div>

              <div class="col-md-2 follow">
                <btn class="btn btn-sm btn-outline-info btn-just-icon"><i class="fa fa-plus"></i></btn>
              </div>
            </div>
          </li>
        </ul>
      </div>

    </div>
  </div> <!-- end card -->
  <div class="card card-with-shadow">
    <div class="card-block">
      <h5 class="card-title">Trends · <small><a href="javascript: void(0);" class="link-info">Change</a></small></h5>
      <div class="hashtag-suggestions">
        <ul class="list-unstyled">
          <li><a href="#paper-kit" class="link-danger">#JeSuisToujoursCharlie</a></li>
          <li><a href="#paper-kit">Oculus Rift</a></li>
          <li><a href="#paper-kit" class="link-danger">#CarenAndLarryAreNotReal</a></li>
          <li><a href="#paper-kit" class="link-danger">#Twitter10k</a></li>
          <li><a href="#paper-kit">EXCLUSIVE MOVE WITHINGTON</a></li>
          <li><a href="#paper-kit">London</a>
          </li><li><a href="#paper-kit">DJ Khaled Snapchat</a>
        </li></ul>
      </div>

    </div>
  </div> <!-- end card -->
</div>
</div>
@endif

</div>
</div>
</div>
@endsection