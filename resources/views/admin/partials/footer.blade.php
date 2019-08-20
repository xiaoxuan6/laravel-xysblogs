<!-- Main Footer -->
<footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
        @if(config('admin.show_environment'))
            <strong>Env</strong>&nbsp;&nbsp; {!! env('APP_ENV') !!}
        @endif

        &nbsp;&nbsp;&nbsp;&nbsp;

        @if(config('admin.show_version'))
        <strong>Version</strong>&nbsp;&nbsp; {!! \Encore\Admin\Admin::VERSION !!}
        @endif

    </div>
    <!-- Default to the left -->
    @if(config('admin.show_powered'))
    <strong>Powered by <a href="{!! env('APP_URL') !!}/author/{!! config('admin.show_powered_by') !!}" target="_blank">{!! config('admin.show_powered_by') !!}</a></strong>
    @endif
</footer>