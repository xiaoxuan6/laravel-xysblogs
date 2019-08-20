@extends('layouts.web')

@section('title', '首页')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/just-tip.css') }}">
  <style>
      .labels {
          display: block;
          width: 45px;
          background: rgba(34,36,38,.1);
          margin-right: 10px;
          float: left;
          border-radius: 7%;
          height: 20px;
          text-align: center;
          margin-top: 4px;
      }
      .abc{background:#cccccc;border:1px solid #cccccc;}
      /*.abc .just-top{border-top-color:black;}*/
      .notice-left{
          width: 40%;
      }
      .notice {
          background: #ececf6;
          width: 71%;
          height: 30px;
          text-align: left;
          /*border-radius: 5px;*/
          border-bottom-right-radius: 5px;
          border-top-right-radius: 5px;
          line-height: 30px;
          margin-left: 29%;
          position:relative;
      }
      .notice-content {
          float: left;
          text-align: center;
          width: 54px;
          background: #f3d17a;
          line-height: 30px;
          border-bottom-left-radius: 5px;
          border-top-left-radius: 5px;
          color: white;
          z-index: 10;
      }
      .mar {
          position: absolute;
      }
  </style>
@endsection
@section('content')
<div class="pagebg " style="background-image:url({{ asset('images/t01.jpg') }}); background-repeat:no-repeat;background-origin: padding-box;
        background-clip: border-box;background-size: cover;
        background-position: center;"></div>
<article style="margin:20px auto 0;">
  <h1 class="t_nav"><span>慢生活，不是懒惰，放慢速度不是拖延时间，而是让我们在生活中寻找到平衡。</span><a href="/" class="n1">首页</a>
  @if(!$tag)
  </h1>
  @else
  <a href="#" class="n2">{{ $tag }}</a></h1>
  @endif

  <div class="blogsbox">
      <div>
          <div class="notice-left">
            <span class="labels demoStyle1" data-title="点赞数排序"><a href="{{ \url()->current().'?order=excellent' }}">精华</a></span>
            <span class="labels demoStyle1" data-title="浏览数排序"><a href="{{ \url()->current().'?order=popular' }}">热门</a></span>
            <span class="labels demoStyle1" data-title="发布时间排序"><a href="{{ \url()->current().'?order=recent' }}">最新</a></span>
          </div>
          <div class="notice-content">公告</div>
          <div class="notice"><marquee class="mar">{{ env('NOTICE') }}</marquee></div>
      </div>
      <div style="clear:both;height: 10px"></div>
    @foreach($data as $v)
    <div class="blogs" data-scroll-reveal="enter bottom over 1s" >
      <h3 class="blogtitle">
        @if($v->status === 3 && !$filter)<span style="color:white; width: 45px; height: 25px; display: block; @if($v->status === 3) background: sandybrown;line-height: 25px; text-align: center; margin-right: 5px; border-radius: 4px;@endif float: left">@if($v->status === 3 && !$filter) 置顶  @endif</span>@endif
        <a href="{{ url('articles/'. $v->slug) }}" class="demoStyle3">{{$v->name}}</a>
      </h3>
      <p class="blogtext">{{ strip_tags($v->content)}}</p>
      <div class="bloginfo">
        <ul>
          <li class="author">{{$v->user->name}}</li>
          <li class="lmname"><?php echo implode('，', $v->label_id);?></li>
          <li class="timer">{{$v->time}}</li>
          <li class="view">{{$v->view}}已阅读</li>
          <li class="@if($v->status_like)likes @else like @endif">{{$v->point_num}}</li>
        </ul>
      </div>
    </div>
    @endforeach
  {{ $data->links() }}
  </div>
  <!--右侧 开始-->
    @include('layouts.comment')
  <!--右侧 结束-->
</article>
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
              gravity:'top'
          });
      })
      $(".demoStyle1").mouseover(function(){
          var _this = $(this);
          _this.justToolsTip({
              animation:"fadeIn",
              contents:_this.data('title'),
              // theme:"abc",
              gravity:'top'
          });
      })
  </script>
@endsection
