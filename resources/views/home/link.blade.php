@extends('layouts.web')

@section('title', '友情链接')

@section('content')
    <div class="pagebg" style="background-image:url({{ asset('images/b05.jpg') }}); background-repeat:no-repeat;background-origin: padding-box;
            background-clip: border-box;background-size: cover;
            background-position: center;"></div>
    <div>
    <div class="justify-content-center" style="float: left;width: 50%">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">申请友链 </div>
                <div class="card-body">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                        <div class="form-group row">
                            <label for="name" class="col-md-2 col-form-label text-md-right">标题</label>

                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control" name="name" value="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="url" class="col-md-2 col-form-label text-md-right">链接</label>

                            <div class="col-md-8">
                                <input id="url" type="text" class="form-control" name="url" value="" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="url" class="col-md-2 col-form-label text-md-right">邮箱</label>

                            <div class="col-md-8">
                                <input id="email" type="text" class="form-control" name="email" value="" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="" class="col-md-2 col-form-label text-md-right">描述</label>

                            <div class="col-md-8">
                                <textarea name="describe" id="describe" class="form-control"  ></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-10 offset-md-8">
                                <button type="button" class="btn btn-primary save">提交</button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div style="float: left; width: 50%">
        <div class="card-header">友接 </div>
        <div class="share">
            <ul>
                @foreach($links as$v)
                <li>
                    <a href="{{ $v->url }}" target="_blank">
                    <div class="shareli">
                        <h2 style="height:auto; text-align: center">
                                <div style="height: 30px">{{ $v->name }}</div>
                                <div style="word-wrap:break-word; word-break:break-all; overflow: hidden;">{{ $v->url }}</div>
                                <div >{{ $v->describe }}</div>
                        </h2>
                    </div>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div style="height: 10px;width:100%; overflow:auto;">
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('layui/layui.all.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/home/link.js')  }}"></script>
@endsection