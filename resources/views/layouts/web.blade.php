<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>james 博客 | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{asset('css/app.css')}}" rel="stylesheet" >
    <link href="{{ asset('css/base.css') }}" rel="stylesheet">
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
    <link href="{{ asset('css/m.css') }}" rel="stylesheet">
    <link href="{{ asset('layui/css/layui.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.easyfader.min.js') }}"></script>
    <script src="{{ asset('js/scrollReveal.js') }}"></script>
    <script src="{{ asset('js/common.js') }}"></script>
    <!--[if lt IE 9]>
    <script src="{{ asset('js/modernizr.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token()}}">
    <![endif]-->
    @yield('css')
    <style>
        .fixed-bottom {position: fixed;}
        .info{
            float: right;
            margin-top: -80px;
            margin-right: 100px;
            color:white;
            width: 150px;
        }
        .nick{
            float: right;
            text-align: left;
            width:95px;
        }
        .info img{
            border-radius:50%;
            z-index: 5;
            margin-left: 12px;
        }
        .personal {
            width: 150px;
            background: white;
            height: 100px;
            position: absolute;
        }
        .hide {
            display: none;
        }
        .personal a{
            height: 50px;
            display: block;
            width: 150px;
            color:black;
            text-align: center;
            /*margin-top: 3px;*/
            line-height: 50px;
        }
        .font {
            color:black !important;
        }
        .personal a:hover{
            background:#F5F5F5;
        }
        .data-info{
            width: 248px; 
            float: right;
        }
        .data-info:hover{
            display: block;
            background: white;
        }
    </style>
</head>
<body>
<header>
    <!--menu begin-->
    <div class="menu">
        <nav class="nav" id="topnav">
            @foreach($banner as $v)
                <li><a href="{{ url($v->url) }}" @if($v->type == 1) target="_blank" @endif>{{ $v->title }}</a> </li>
            @endforeach
            <!--search begin-->
            <div id="search_bar" class="search_bar ">
                <form  id="searchform" action="{{ url('/') }}" method="get" name="searchform">
                    <input class="input" placeholder="想搜点什么呢..." type="text" name="keywords" id="keywords" value="">
                    <span class="search_ico"></span>
                </form>
            </div>
            <!--search end-->
        </nav>
        @if(!Auth::guard('oauth')->check())
            <div style=" float: right; width: 100px; margin-top: -80px; margin-right: 100px" ><a style="color:white;" class="login">登录</a></div>
        @else
            <div class="data-info">
                <div class="info">
                    <img src="{{ env('COS_CDN').'/'.Auth::guard('oauth')->user()->image }}" width="30px">
                    <div class="nick">{{ Auth::guard('oauth')->user()->username }}</div>
                    <div class="personal hide">
                        <a class="slug" href="{{ url('show/discuss') }}">我的评论</a>
                        <a class="slug font logout">退出</a>
                    </div>
                </div>
            </div>
        @endif
        
    </div>
    <!--menu end-->
</header>

    @yield('content')

    @yield('js')
<a href="#" class="cd-top">Top</a>
<div style="margin-top: 10px"></div>
<footer class="fixed-bottom">
    <p>Design by <a href="{{ env('APP_URL') }}">James</a> 本站总访问量<a href="{{ url('/echarts') }}">{{ $count }}</a>次 总访客数{{ $number }}人次</p>
</footer>
<script type="text/javascript" src="{{ asset('layui/layui.all.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/home/web.js')  }}"></script>
<script >
    $(function(){
        function footerPosition(){
            $("footer").removeClass("fixed-bottom");
            var contentHeight = document.body.scrollHeight,//网页正文全文高度
                winHeight = window.innerHeight;//可视窗口高度，不包括浏览器顶部工具栏
            if(!(contentHeight > winHeight)){
                //当网页正文高度小于可视窗口高度时，为footer添加类fixed-bottom
                $("footer").addClass("fixed-bottom");
            } else {
                $("footer").removeClass("fixed-bottom");
            }
        }
        footerPosition();
        $(window).resize(footerPosition);
    });
    $(".info").on("mouseenter", function () {
        $('.personal').removeClass('hide');
    }).on("mouseleave", function () {
        $('.personal').addClass('hide');
    });
</script>
</body>
</html>
