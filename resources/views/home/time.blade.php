@extends('layouts.web')

@section('title', $date )

@section('css')
    <link rel="stylesheet" href="{{ asset('css/just-tip.css') }}">
    <style>
        .abc{background:green;border:1px solid green;}

        .abc .just-top{border-top-color:green;}
    </style>
@endsection
@section('content')
<div class="pagebg timer"> </div>
<div class="container">
  <h1 class="t_nav"><span>时光飞逝，机会就在我们眼前，何时找到了灵感，就要把握机遇，我们需要智慧和勇气去把握机会。</span><a href="/" class="n1">首页</a><a href="#" class="n2">({{ $date }})</a></h1>
  <div class="timebox">
  <ul id="list">
  @foreach($data as $v)
    <li><span>{{$v->times}}</span><a href="{{ url('articles/'. $v->slug) }}" class="demoStyle3">{{$v->name}}</a></li>
  @endforeach
  </ul>
  <ul id="list2">
  </ul>
  </div>
</div>
@endsection
@section('js')
  <script src="{{ asset('js/home/justTools.js') }}"></script>
  <script>
      $(".demoStyle3").mouseover(function(){
          var _this = $(this);
          _this.justToolsTip({
              animation:"fadeIn",
              // width:"300px",
              contents:_this.text(),
              theme:"abc",
              gravity:'top'
          });
      })
  </script>
@endsection
