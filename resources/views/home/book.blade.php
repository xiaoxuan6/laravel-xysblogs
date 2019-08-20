@extends('layouts.web')

@section('title', '学习资源')

@section('content')
<div class="pagebg " style="background-image:url({{ asset('images/t03.jpg') }}); background-repeat:no-repeat;background-origin: padding-box;
        background-clip: border-box;background-size: cover;
        background-position: center;"></div>
<div class="container">
  <h1 class="t_nav"><span>不要轻易放弃。学习成长的路上，我们长路漫漫，只因学无止境。 </span><a href="/" class="n1">首页</a><a href="{{ url('book') }}" class="n2">学习资源</a></h1>


<div class="share">
<ul>
    @foreach($list as $v)
        <li>
            <div class="shareli">
                <a href="{{ $v->url }}" target="_blank">
                    <i><img src="{{ env('COS_CDN').'/'.$v->image }}" style="width:250px "></i>
                    <h2><b>{{ $v->title }}</b></h2>
                </a>
            </div>
        </li>
    @endforeach
</ul>
</div>
<div class="pagelist">{{ $list->links() }}</div>
</div>
@endsection
