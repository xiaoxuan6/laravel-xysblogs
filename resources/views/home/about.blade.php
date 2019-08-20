@extends('layouts.web')

@section('title', '关于')

@section('content')
<div class="pagebg" style="background-image:url({{ asset('images/banner02.jpg') }}); background-repeat:no-repeat;background-origin: padding-box;
        background-clip: border-box;background-size: cover;
        background-position: center;"> </div>
<div class="container">
  <h1 class="t_nav"><span>不期望自己能改变世界，但希望自己做的事情多多少少能影响一部分人，不管这个数目是一千、一万还是一百万。</span><a href="/" class="n1">首页</a><a href="{{ url('/about') }}" class="n2">关于</a></h1>
  <div class="news_infos" style="width: 100%">
    <ul>
      <h2>个人账户</h2>
      laravel 社区账户：<a href="https://laravel-china.org/james" target="_blank">https://laravel-china.org/james</a><br>
      github地址：<a href="{{ env('GITHUB') }}" target="_blank">{{ env('GITHUB') }}</a><br>
      码云地址：<a href="{{ env('GITTEE') }}" target="_blank">{{ env('GITTEE') }}</a><br>
      <br>
      <br>
      <h2>项目地址</h2>
      @foreach($list as $v)
      {{ $v->name }}：<a href="{{ $v->url }}" target="_blank">{{ $v->url }}</a><br>
      @endforeach
      <br>
      <br>
      <h2>支付宝支付</h2>
      <p>传送门&nbsp;&nbsp;<a href="{{ url('/pay') }}"><span style="color:#FF0000;"><strong>前往支付&gt;&gt;</strong></span></a></p><br>
      <br>
      <h2>欢迎打赏</h2><br>
      <div style="width: 80%; height: 300px; margin-left: 18%">
        <div style="width: 20%; float: left;"><img src="{{ asset('images/wechat.png') }}" alt="" height="300px"></div>
        <div style="width: 20%; float: left; margin-left: 7%"><img src="{{ asset('images/qq.png') }}" alt="" height="300px"></div>
        <div style="width: 20%; float: left; margin-left: 5%"><img src="{{ asset('images/pay1.png') }}" alt="" height="300px"></div>
      </div>
    </ul>
  </div>
</div>
@endsection