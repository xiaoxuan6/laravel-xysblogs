<div class="sidebar">
    <div class="tuijian">
        <h2 class="hometitle">点击排行</h2>
        <ul class="sidenews">
        @foreach($clickList as $item)
            <li>
                <p><a href="{{  url('articles/'. $item->slug) }}">{{$item->name}}</a></p>
                <span>{{$item->time}}</span>
            </li>
        @endforeach
        </ul>
    </div>
    <div class="">
        <h2 class="hometitle">文档归案</h2>
        <ul>
            @foreach($file as $item)
                <li style="height: 20px"><a href="{{ url('article',$item->pub_date) }}">{{date('Y年m月', strtotime($item->pub_date))}} ({{ $item->num }})</a></li>
            @endforeach
        </ul>
    </div>
    <div class="cloud">
        <h2 class="hometitle">标签云</h2>
        <ul>
            @foreach ($tags as $val)
            <a href="{{url('/tag/'.$val->title)}}">{{$val->title}}（{{$val->num}}）</a>
            @endforeach
        </ul>
    </div>

    <div class="tuijian">
        <h2 class="hometitle">最新评论</h2>
        <ul class="sidenews">
            @foreach($comment as $item)
                <li>
                    昵称：{{ $item->oauth->username }}
                    <span>在文章 <strong style="font-size:14px;"><a href="{{ url('articles/'. $item->article->slug) }}#reply">{{ $item->article->name }}</a></strong> 中评论：{{ str_limit($item->comment, 60) }}</span>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="guanzhu" id="follow-us">
        <h2 class="hometitle">关注我们 么么哒！</h2>
        <ul>
            <li class="qq"><a href="/" target="_blank"><span>QQ号</span>{{ env('USER_QQ') }}</a></li>
            <li class="email"><a href="/" target="_blank"><span>邮箱帐号</span>{{ env('USER_EMAIL') }}</a></li>
            <li class="wxgzh"><a href="/" target="_blank"><span>微信号</span>{{ env('USER_WECHAT') }}</a></li>
            {{--<li class="">交流群：{{ env('QQ', '663610806') }}</li>--}}
        </ul>
    </div>

    <div class="">
        <h2 class="hometitle">友情链接</h2>
        <ul>
            @foreach($links as $item)
                <li style="height: 20px"><a href="{{ $item->url }}" target="_blank"><i style="font-size: 14px;font-family: layui-icon !important;font-style: normal;width: 14px; height: 18px; border: white"></i>&nbsp;&nbsp;{{ $item->name }}</a></li>
            @endforeach
                <li><a href="{{ url('link') }}" ><i style="font-size: 14px;font-family: layui-icon !important;font-style: normal;width: 14px; height: 18px; border: white"></i>&nbsp;&nbsp;申请交换 》》</a></li>
        </ul>
    </div>
</div>