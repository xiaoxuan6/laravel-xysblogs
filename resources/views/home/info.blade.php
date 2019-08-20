@extends('layouts.web')

@section('title',  $data->name)

@section('content')
<article>
  <div class="infosbox">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="newsview">
      <h3 class="news_title">{{$data->name}}</h3>
      <div class="bloginfo">
        <ul>
          <li class="author"><a href="/author/{{$data->user->name}}">{{$data->user->name}}</a></li>
          <li class="timer">{{$data->created_at}}</li>
          <li class="view">{{$data->view}}</li>
          <li class="diggnum @if($status) likes @else like @endif">{{$point ?? 0}}</li>
        </ul>
      </div>
      <div class="tags">
        @foreach($data->label_id as $item)
        <a href="{{ url('/tag/'.$item)  }}" >{{$item}}</a> &nbsp;
          @endforeach
      </div>
      <div class="news_con"> {!! $data->content !!}</div>
      <br>
      <div>本文链接：<a href="{{ env('APP_URL').\Request::getRequestUri() }}" target="_blank">{{ env('APP_URL').\Request::getRequestUri() }}</a></div><br>
      <div class="bshare-custom">分享：<a title="分享到QQ空间" class="bshare-qzone"></a><a title="分享到新浪微博" class="bshare-sinaminiblog"></a><a title="分享到人人网" class="bshare-renren"></a><a title="分享到腾讯微博" class="bshare-qqmb"></a><a title="分享到网易微博" class="bshare-neteasemb"></a><a title="更多平台" class="bshare-more bshare-more-icon more-style-addthis"></a><span class="BSHARE_COUNT bshare-share-count">0</span></div><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/button.js#style=-1&amp;uuid=&amp;pophcol=2&amp;lang=zh"></script><a class="bshareDiv" onclick="javascript:return false;"></a><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>

    </div>
    <div class="share">
      <div class="point" data-id="{{ $data->id }}"><p class="diggit"> 很赞哦！(<b id="diggnum" class="diggnum">{{$point ?? 0}}</b>)</p></div>
      <p class="dasbox"><a href="{{ env('PAY_URL') }}" target="_blank" class="dashang" title="打赏，支持一下">打赏本站</a></p>
    </div>
    <div class="nextinfo">
      @if($data->prev_data)
      <p>上一篇：<a href="{{ url('articles/'. $data->prev_data->slug) }}">{{ $data->prev_data->name }}</a></p>
      @endif
      @if($data->next_data)
      <p>下一篇：<a href="{{ url('articles/'. $data->next_data->slug) }}">{{ $data->next_data->name }}</a></p>
        @endif
    </div>

    <div class="news_pl">
      <h2 id="reply">文章评论 <span style="margin-right: 20px; color:red; display: block; float: right;" class="comments">发表评论</span></h2>
      <div style="margin: 20px 0 0 20px; display: none" class="comment_show">
        <input type="hidden" value="{{ $data->id }}" class="id">
        <input type="hidden" value="0" class="pid">
        <input type="hidden" value="{{ \Auth::guard('oauth')->check() }}" class="oauth">
        <div style="display:none" class="replay-nickname">
          <span class="replays"></span><br>
          <div style="margin-top: 8px"></div>
        </div>
        <span class="title">评论内容：</span>
        <div class="col-md-6" style="margin-left: 55px; margin-top: -20px">
          <textarea name="comment" id="describe" class="form-control comment" placeholder="请输入内容..." ></textarea>
        </div>
        <div style="margin-top: 8px"></div>
        <button type="button" class="btn btn-primary tijioa" style="margin-left: 71px;">提交</button>
      </div>
      <ul>
        <div class="gbko" style="margin: 20px 0 0 13px">
          @foreach($data['comments'] as $v)
            <li>
              <div class="parent">
                <span style="color:white; width: 40px; height: 30px; display: block; @if($v->status === 3) background: sandybrown;line-height: 30px; text-align: center; margin-right: 5px; border-radius: 4px;@endif float: left">@if($v->status === 3) 置顶  @endif</span>
                <div>
                  <div style="float: left; width: 50px"><img src="{{ env('APP_URL').'/'.$v->oauth->image }}" alt="" width="40px"; height="40px"></div>
                  <div style="float:left; width: 85%">
                    <span class="nickname"> 昵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;称：{{ $v->oauth->username }}@if($v->type)<span style="color: red">（作者）</span>@endif</span>
                    <br>
                    <span >评论内容：</span><div style="width: 88%; float: right;">{{ $v->comment }}</div>
                    <br>
                    <div style="margin-left:70px;">
                      <span style="font-family: Icons; margin-top: 10px; color:#a6b5c5;">{{ $v->created_at }}</span>&nbsp;
                      <span class="replay" data-id="{{ $v->id }}">回复</span>
                    </div>
                  </div>
                </div>
                <br>
                <div style="width: 100%; height: auto; clear: left; margin-left: 87px" class="parent">
                  @if($v->children)
                    @foreach($v->children as $vv)
                      <div>
                        <div style="float: left; width: 50px"><img src="{{ env('APP_URL').'/'.$vv->oauth->image }}" alt="" width="40px"; height="40px"></div>
                        <div style="float:left; width: 90%">
                          <span class="nickname"> 昵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;称：{{ $vv->oauth->username }}@if($vv->type)<span style="color: red">（作者）</span>@endif</span>
                          <br>
                          <span >评论内容：</span>{{ $vv->comment }}
                          <br>
                          <div style="margin-left: 70px">
                            <span style="font-family: Icons; margin-top: 10px; color:#a6b5c5;">{{ $vv->created_at }}</span>&nbsp;
                            <span class="replay" data-id="{{ $vv->id }}">回复</span>
                          </div>
                          </div>
                        </div>
                      <br>
                    @endforeach
                  @endif
                </div>
              </div>
            </li>
            @endforeach
        </div>
      </ul>
    </div>
  </div>
  @include('layouts.comment')
</article>
@endsection

@section('js')
  <script type="text/javascript" src="{{ asset('layui/layui.all.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/home/info.js')  }}"></script>
@endsection