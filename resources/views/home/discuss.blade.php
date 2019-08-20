@extends('layouts.web')

@section('title',  '我的评论')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/discuss.min.css') }}">
@endsection
@section('content')
<article>
  <h1 class="t_nav"><span>你，我生命中一个重要的过客，我们之所以是过客，因为你未曾会为我停留。</span><a href="/" class="n1">首页</a><a href="{{ url('show/discuss') }}" class="n2">我的评论</a></h1>
  <div class="infosbox">
    <div class="gj-lg-12">
      <div class="gj-wk gcl-hb">
        <!--媒体列表-->
        @foreach($data as $v)
        <div class="gj-body gj-shuo">
          <div class="list">
            <img src="{{ env('COS_CDN').'/'.$v->oauth->image }}" class="tx hidd-xs" alt="">
            <span class="gj-title" ><h1><a href="{{ url('articles/'. $v->article->slug) }}#reply">{{ $v->article->name }}</a></h1></span>
            <div class="cont" style="width: 100%">
              <div class="cont-p" id="content_11">{!! $v->comment !!} </div>
              <div class="cont-sx">
                <span><i class="fa fa-clock-o" aria-hidden="true"></i> {{ date('Y-m-d', strtotime($v->created_at)) }}</span>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    </div>
  @include('layouts.comment')
</article>
@endsection

@section('js')
  <script type="text/javascript" src="{{ asset('layui/layui.all.js') }}"></script>
  <script src="https://www.guojian945.com/common/static/gj-blog/js/guojian.min.js" type="text/javascript"></script>
  <script>
      /*GJ-UI响应式导航栏*/
      $(document).ready(function() {
          $(".gbar").click(function() {
              $(".gnav-ul").slideToggle("slow");
              return false
          })
      });
  </script>
@endsection