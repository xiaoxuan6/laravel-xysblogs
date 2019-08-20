@extends('layouts.web')

@section('title', 'Packagist 包')

@section('content')
<div class="pagebg" style="background-image:url({{ asset('images/20f655ea.jpg') }}); background-repeat:no-repeat;background-origin: padding-box;
        background-clip: border-box;background-size: cover;
        background-position: center;"></div>
<div class="container">
  <h1 class="t_nav"><span>不要轻易放弃。学习成长的路上，我们长路漫漫，只因学无止境。 </span><a href="/" class="n1">首页</a><a href="{{ url('packagist') }}" class="n2">Packagist 包</a></h1>
<div class="share">
<ul>
    @foreach($list as $v)
        <div class="github-widget" data-repo="{{ $v }}"></div>
    @endforeach
</ul>
</div>
</div>
@endsection
@section('js')
<script src="{{ asset('js/home/jquery.githubRepoWidget.min.js') }}"></script>
@endsection