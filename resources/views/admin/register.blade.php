@extends('layouts.admin')

@section('name', config('admin.title'))

@section('title', '注册')

@section('content')
  <div class="login-logo">
    {{--<a href="{{ admin_base_path('/') }}"><b>{{config('admin.name')}}</b></a>--}}
    <b>注册</b>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body" style="background:rgba(255,255,255,0);">
    <p class="login-box-msg"><a href="{{ admin_base_path('auth/login') }}" style="color:white;">已有账号，<b>登陆</b></a></p>

    <form action="{{ admin_base_path('auth/register') }}" method="post" enctype="multipart/form-data" onsubmit="return check()">
      <div class="form-group has-feedback ">
        <input type="input" class="form-control" style="background-color:transparent; color:black !important;" placeholder="{{ trans('admin.username') }}" name="username" value="{{ old('username') }}">
        <span class=" glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback ">
        <input type="password" class="form-control" style="background-color:transparent" placeholder="{{ trans('admin.password') }}" name="password" value="{{ old('password') }}">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback ">
        <input type="password" class="form-control" style="background-color:transparent" placeholder="确认密码" name="confirm_password" value="">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback ">
        <input type="text" class="form-control" style="background-color:transparent" placeholder="手机号" name="phone" value="">
        <span class="glyphicon  form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback ">
        <div style="display:inline">
          <input type="text" class="form-control" style="background-color:transparent; width: 60%; color: black ; float: left" placeholder="输入验证码" name="captcha" value="">
          <button type="button" style="width: 36%;float: left; margin-left: 12px" class="btn btn-primary btn-block btn-flat send">发送验证码</button>
        </div>
      </div>
      <div class="row">

        <!-- /.col -->
        <div class="col-xs-4 col-md-offset-4" style="margin-top: 15px">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="button" class="btn btn-primary btn-block btn-flat save" >注册</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('layui/layui.all.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/register.js') }}"></script>
@endsection
