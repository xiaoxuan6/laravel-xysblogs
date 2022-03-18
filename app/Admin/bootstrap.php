<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
use Encore\Admin\Grid\Column;

Encore\Admin\Form::forget(['map']);

Column::extend('prependIcon', function ($value, $icon) {
    return "<i class='fa fa-$icon'></i>  $value";
});

app('view')->prependNamespace('admin', resource_path('views/admin'));
