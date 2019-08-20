@extends('layouts.web')

@section('title', '支付')

@section('css')
  <style>
    .header {
      width: 20%;
      float: left;
      text-align: center;
      border: 1px solid #f0f0f0;
    }
    .msg{
      width: 100%;
      text-align: center;
    }
  </style>
@endsection

@section('content')
<div class="pagebg" style="background-image:url({{ asset('images/zd01.jpg') }}); background-repeat:no-repeat;background-origin: padding-box;
        background-clip: border-box;background-size: cover;
        background-position: center;"> </div>
<div class="container">
  <h1 class="t_nav"><span>不期望自己能改变世界，但希望自己做的事情多多少少能影响一部分人，不管这个数目是一千、一万还是一百万。</span><a href="/" class="n1">首页</a><a href="{{ url('/pay') }}" class="n2">支付</a></h1>
  <div class="news_infos" style="width: 100%; ">
    <div class="msg"><b>支付完成</b></div>
    <div>
    <ul>
      <li class="header">支付宝订单号</li>
      <li class="header">标题</li>
      <li class="header">金额</li>
      <li class="header">支付状态</li>
      <li class="header">支付时间</li>

      @foreach($data as $v)
        <li class="header">{{ $v['out_trade_no'] }}</li>
        <li class="header">{{ $v['title'] }}</li>
        <li class="header">{{ $v['total_amount'] }}</li>
        <li class="header">{{ $v['trade_status'] }}</li>
        <li class="header">{{ $v['pay_time'] }}</li>
      @endforeach

    </ul>
    </div>
  </div>
</div>
@endsection