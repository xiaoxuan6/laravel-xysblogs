<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Illuminate\Support\Facades\Config;
use Illuminate\Container\Container;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->header('首页')
            ->row(function (Row $row) {

                $row->column(8, function (Column $column) {
                    $column->append(Dashboard::environment());
                });
                $row->column(4, function(Column $column){
                    $form = new \Encore\Admin\Widgets\Form();
                    $form->action(admin_base_path('/notice/create'));
                    $form->method('post');

                    $notice = env('NOTICE');
                    $form->textarea('name', '内容')->rules('required')->required()->default($notice);
                    $form->hidden('_token')->default(csrf_token());
                    $form->disableReset();
                    $column->append((new Box("公告", $form))->style('success'));
                });

            });
    }

    public function notice(\Illuminate\Http\Request $request)
    {
        $name = $request->input('name');
        if(!$name){
            admin_toastr('请输入内容', 'success');
            return redirect()->back();
        }

        $data = ['NOTICE' => '"'.$name.'"'];
        $contentArray = $this->getEnvFile();
        $content = $contentArray->transform(function ($item) use ($data) {
            foreach ($data as $key => $value) {
                if (str_contains($item, $key)) {
                    return $key . '=' . $value;
                }
            }
            return $item;
        });
        $content = implode($content->toArray(), "\n");

        \File::put(self::getEnvFilePath(), $content);
        admin_toastr('操作成功', 'success');

        return redirect('/admins');
    }

    /**
     * 获取.env
     * @return string
     */
    private static function getEnvFilePath()
    {
        return Container::getInstance()->environmentPath() . DIRECTORY_SEPARATOR .
            Container::getInstance()->environmentFile();
    }

    /**
     * Notes: 获取 .env 内容
     * Date: 2019/6/5 14:36
     * @return array
     */
    public function getEnvFile()
    {
        return collect(file(self::getEnvFilePath(), FILE_IGNORE_NEW_LINES));
    }

}
