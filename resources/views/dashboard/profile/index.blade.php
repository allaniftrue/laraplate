@extends('dashboard.templates.master')

@section('content')
<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <ul class="nav nav-tabs">
      <li role="presentation" class="active"><a data-toggle="tab" href="#personalInfo"><span class="glyphicon glyphicon-user"></span> Personal Info</a></li>
      <li role="presentation"><a data-toggle="tab" href="#loginInfo"><span class="glyphicon glyphicon-lock"></span> Login Info</a></li>
    </ul>
  </div>
</div>
<br>
<div class="tab-content">
    <div id="personalInfo" class="tab-pane fade in active">
      <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="alert alert-info" role="alert">
              <strong>Heads up!</strong> Fields with <strong>*</strong> are required.
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="form-group">
            <label for="avatarZone">* Profile Picture  <abbr title="attribute"><a href="javascript:void(0)"><span class="glyphicon glyphicon-question-sign" data-toggle="help-popover" data-trigger="focus" title="<span class='glyphicon glyphicon-info-sign'></span> Tip" data-content="<ul class='list-unstyled'><li><strong>File types:</strong> jpg, jpeg, png, gif.</li><li><strong>File size:</strong> < 1.5MB</li><li><strong>Dimension:</strong>120x120px</li></ul>"></span></a></abbr></label>
            <div class="profile">
                <form action="{{ url('/dasboard/profile/upload') }}" class="dropzone" id="avatarZone" accept="image/gif,image/jpg,image/jpeg,image/png" style="background-image:url({{ asset( 'uploads/profile/') }}/{{ $user->avatar }})">
                </form>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="post" action="{{ url('dashboard/profile/store') }}" class="last" id="profileForm" data-parsley-validate>
                <div class="form-group">
                  <label for="fullname">* Full Name</label>
                  <input type="text" value="{{ $user->fullname or old('fullname') }}" name="fullname" id="fullname" class="form-control" placeholder="Juan dela Cruz" data-parsley-pattern="/^[a-z\d\-_\s]+$/i" required>
                </div>
                <div class="form-group">
                  <label for="address">* Permanent Address or Store Address</label>
                  <input type="text" value="{{ $user->address or old('address') }}" name="address" id="address" class="form-control" placeholder="Blk. 11. Lot 2, 68 Raeburn Avenue, Cagayan de Oro City, Philippines 9000" required>
                </div>
                <div class="form-group">
                  <label for="contact">* Contact Number (unique)</label>
                  <input type="text" value="{{ $user->contact or old('contact') }}" name="contact" id="contact" class="form-control" placeholder="Contact Number" data-parsley-type="number" data-parsley-minlength="11" data-parsley-maxlength="11" maxlength="11" required>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-default" id="saveProfileInformation">Save Information</button>
            </form>
        </div>

      </div>
    </div>

    <div id="loginInfo" class="tab-pane fade">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
          <form method="post" action="{{ url('dashboard/profile/login/update') }}" class="last" id="loginForm" data-parsley-validate>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" value="{{ $user->email }}" name="email" id="email" class="form-control" disabled="disabled">
            </div>
            <div class="form-group">
                <label for="lname">Current Password</label>
                <div class="input-group">
                  <input type="password" name="currentPassword" id="currentPassword" value="{{ old('currentPassword') }}" class="form-control" data-parsley-focus="first">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="button" id="showCurrentPassword" data-info="currentPassword" data-for="currentPassword" tabindex="-1">
                        <span class="glyphicon glyphicon-eye-open"></span>
                    </button>
                  </span>
                </div>
                {{-- <input type="password" name="currentPassword" id="currentPassword" class="form-control" data-parsley-focus="first" required> --}}
            </div>
            <div class="form-group">
                <label for="lname">New Password</label>
                <div class="input-group">
                  <input type="password" name="newPassword" id="newPassword" class="form-control">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="button" id="showNewPassword" value="{{ old('newPassword') }}"  data-info="newPassword" data-for="newPassword" tabindex="-1">
                        <span class="glyphicon glyphicon-eye-open"></span>
                    </button>
                  </span>
                </div>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" class="btn btn-default" id="saveProfileInformation">Save Password</button>
          </form>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
            <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="glyphicon glyphicon-info-sign"></span> Tips</h3>
            </div>
            <div class="panel-body">
            <ul>
                <li>
                    Use a stronger password or use passphareses instead. See <a href="https://accounts.google.com/PasswordHelp" target="_blank">Google's</a> suggestion.
                </li>
            </ul>
            </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('jsFooter')
    <script type="text/javascript">
    var currentPage = 'profile';
    </script>
    <script type="text/javascript" src="{{ asset('js/dropzone.js') }}"></script>
    <script type="text/javascript" src="{{ elixir('js/app.js') }}"></script>
@stop
