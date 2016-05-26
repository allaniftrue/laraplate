<!--<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">*</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="{{ url('dashboard') }}">Dashboard</a></li>
          </ul>
          <div class="dropdown navbar-right">
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span><img src="@if($user->avatar) {{ asset('uploads/profile').'/'.$user->avatar }} @else {{ asset('uploads/profile/default-avatar.jpg') }} @endif" class="img-circle" width="24" height="24"></span> {{ $user->fullname or 'Unknown' }} <span class="caret"></span></a>
                <ul class="dropdown-menu" aria-labelledby="user-settings-menu">
                  <li><a href="{{ url('dashboard/profile') }}">Profile</a></li>
                   <li role="separator" class="divider"></li>
                  <li><a href="{{ url('logout') }}">Logout</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
    </div>
</nav> -->

<nav>
  <div class="menu">
    <ul class="inline right">
      <li>
        <img src="@if($user->avatar) {{ asset('uploads/profile').'/'.$user->avatar }} @else {{ asset('uploads/profile/default-avatar.jpg') }} @endif" class="img-circle" id="user-icon" width="24" height="24">
      </li>
    </ul>
  </div>

  <div class="dropdown">
    <span class="top-arrow"><img src="{{ asset('img/top-arrow.png') }}"></span>
    <ul>
      <li>
        <div class="information">
          <div class="avatar">
            <img src="@if($user->avatar) {{ asset('uploads/profile').'/'.$user->avatar }} @else {{ asset('uploads/profile/default-avatar.jpg') }} @endif" class="img-circle" id="user-icon" width="64" height="64">
          </div>
          <div class="details">
            <p>
              <strong>{{ $user->fullname or "Unknown" }} John Snow</strong>
              <br>
              <a href="{{ url('dashboard/profile') }}">Profile</a>
            </p>
          </div>
        </div>
      </li>
    </ul>
    <div class="actions">
      <ul class="inline">
        <li>
          <button>Logout</button>
        </li>
      </ul>
    </div>
  </div>
</nav>
