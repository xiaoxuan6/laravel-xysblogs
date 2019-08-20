<section class="content"><div class="row"><div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">查看</h3>
                    <div class="box-tools">
                        <div class="btn-group pull-right" style="margin-right: 5px">
                            <a href="{{ url('/admin/black-list') }}" class="btn btn-sm btn-default" title="列表"><i class="fa fa-list"></i><span class="hidden-xs">&nbsp;列表</span></a>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form action="" method="post" accept-charset="UTF-8" class="form-horizontal" pjax-container="">
                    <div class="box-body">
                        <div class="fields-group">
                            <div class="form-group  ">
                                <label for="name" class="col-sm-2 control-label">标题</label>
                                <div class="col-sm-8">
                                    <input type="text" value="{{ $data->name }}" class="form-control " >
                                </div>
                            </div>
                            <div class="form-group  ">
                                <label for="author" class="col-sm-2  control-label">作者</label>
                                <div class="col-sm-8">
                                    <input type="text" value="{{ $data->author }}" class="form-control " >
                                </div>
                            </div>
                            <div class="form-group  ">
                                <label for="label_id" class="col-sm-2 control-label">标签</label>
                                <div class="col-sm-8">
                                    <input type="text" value="{{ $data->label_name }}" class="form-control " >
                                </div>
                            </div>
                            <div class="form-group  ">
                                <label for="content" class="col-sm-2 control-label">内容</label>
                                <div class="col-sm-8">
                                    {!! $data->content !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <input type="hidden" name="_token" value="62TEqIVSWpESd8eAD7feXHic3Zjjv78XvNwv0Z5q"><div class="col-md-2">
                        </div>
                        <div class="col-md-8">
                            <div class="btn-group pull-right">
                                <button type="button" class="btn btn-primary"><a href="javascript:history.go(-1);" style='color:white;'>返回</a></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div></div>
</section>