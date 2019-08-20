@extends('layouts.web')

@section('title',  '404错误')

@section('content')
  <article>
  <div class="infosbox">
    <h1>找不到你想要的页面！</h1>
  </div>
  @include('layouts.comment')
  </article>
@endsection
