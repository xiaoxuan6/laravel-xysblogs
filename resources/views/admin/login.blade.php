@extends('layouts.admin')

@section('name', config('admin.title'))

@section('title', trans('admin.login'))

@section('content')
  <div class="login-logo">
    {{--<a href="{{ admin_base_path('/') }}"><b>{{config('admin.name')}}</b></a>--}}
    <b>{{ trans('admin.login') }}</b>
  </div>
  <div class="login-box-body" style="background:rgba(255,255,255,0);">
    <p class="login-box-msg"> <a href="{{ admin_base_path('auth/register') }}" style="color:white; ">&nbsp;&nbsp;还没有账号? <b>注册</b></a></p>

    <form action="{{ admin_base_path('auth/login') }}" method="post">
      <div class="form-group has-feedback {!! !$errors->has('username') ?: 'has-error' !!}">

        @if($errors->has('username'))
          @foreach($errors->get('username') as $message)
            <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>{{$message}}</label><br>
          @endforeach
        @endif

        <input type="input" class="form-control" style="background-color:transparent; color:black !important;" placeholder="{{ trans('admin.username') }}" name="username" value="{{ old('username') }}">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback {!! !$errors->has('password') ?: 'has-error' !!}">

        @if($errors->has('password'))
          @foreach($errors->get('password') as $message)
            <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>{{$message}}</label></br>
          @endforeach
        @endif

        <input type="password" class="form-control" style="background-color:transparent" placeholder="{{ trans('admin.password') }}" name="password" value="{{ old('password') }}">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="form-group has-feedback {!! !$errors->has('captcha') ?: 'has-error' !!}">

          @if($errors->has('captcha'))
            @foreach($errors->get('captcha') as $message)
              <label class="control-label" for="inputError" style=" margin-left: 15px"><i class="fa fa-times-circle-o"></i>{{$message}}</label></br>
            @endforeach
          @endif

          <input type="text" class="form-control" style="display: inline;width: 55%; margin-left: 15px; background-color:transparent"  placeholder="{{ trans('admin.captcha') }}" name="captcha">
          <span class="glyphicon glyphicon-refresh form-control-feedback captcha" style="right:39%;z-index: 100"></span>
          <img  class="captcha" src="{{ captcha_src('admin') }}" onclick="refresh()">
        </div>
        <script>
            function refresh(){
                $('img[class="captcha"]').attr('src','{{ captcha_src('admin') }}'+Math.random());
            }
        </script>
        <div class="row">

          <!-- /.col -->
          <div class="col-xs-4 col-md-offset-4">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('admin.login') }}</button>
          </div>
        </div>
    </form>

    <div>
      <div style="color:white; text-align:center; margin: 10px 0 5px 0 "><b>支持第三方登录</b></div>
      <a href="{{ admin_base_path('oauth/github') }}"><button type="button" class="btn btn-primary btn-block btn-flat form-control" style="">gitHub 登录</button></a>
    </div>
  </div>
@endsection