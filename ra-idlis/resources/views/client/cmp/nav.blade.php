<nav class="navbar navbar-expand-md navbar-dark bg-dark" style="background: linear-gradient(to bottom left, #228B22, #84bd82);padding: 10px 10px 10px 10px;padding: 1px 1px 1px 1px;">
  <a class="navbar-brand"><img src="{{asset('ra-idlis/public/img/doh2.png')}}" style="max-height: 90px; padding-left: 20px;"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    @isset($curUser) 
      <ul class="navbar-nav mr-auto">
      </ul>
      <ul class="navbar-nav ml-auto" style="padding: 0px 20px;">
        <li class="nav-item @isset($curPage) active @endisset">
          <a class="nav-link" href="{{asset('/client/home')}}">HOME</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="fa fa-bell"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item">Sample Notification</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">See all</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="fa fa-user-circle"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <center><p class="dropdown-item"><img src="{{asset('ra-idlis/public/img/doh2.png')}}" style="max-height: 60px;"></p></center>
            <p class="dropdown-item">{{$curUser->facilityname}}</p>
            <p class="dropdown-item">{{$curUser->email}}</p>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{asset('/logout_user')}}">Logout</a>
          </div>
        </li>
      </ul>
    @else
      <form class="form-inline my-2 my-lg-0 ml-auto" method="POST" action="{{asset('/login_user')}}" style="padding: 0px 20px;">
        {{csrf_field()}}
        <input class="form-control mr-sm-2" type="text" name="uid" placeholder="Username" aria-label="Username" autocomplete="off">
        <input class="form-control mr-sm-2" type="password" name="pwd" placeholder="Password" aria-label="Password" autocomplete="off">
        <button class="btn btn-primary form-control" type="submit">Login</button>
      </form>
    @endisset
  </div>
</nav>