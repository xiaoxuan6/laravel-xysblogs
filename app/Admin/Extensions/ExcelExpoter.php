<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace App\Admin\Extensions;

use App\Model\Label;
use Maatwebsite\Excel\Facades\Excel;
use Encore\Admin\Grid\Exporters\AbstractExporter;

class ExcelExpoter extends AbstractExporter
{
    protected $head = [];
    protected $body = [];
    protected $filename = '';
    protected $ext = '';

    public function __construct($filename, $head, $body, $ext = '')
    {
        $this->head = $head;
        $this->body = $body;
        $this->filename = $filename;
        $this->ext = $ext;
    }

    public function export()
    {
        $Filename = $this->filename;
        $ext = $this->ext ? $this->ext : 'xls';
        Excel::create($Filename, function ($excel) use ($Filename) {
            $excel->sheet($Filename, function ($sheet) {
                // 这段逻辑是从表格数据中取出需要导出的字段
                $head = $this->head;
                $body = $this->body;
                $bodyRows = collect($this->getData())->map(function ($item) use ($body) {
                    foreach ($body as $keyName) {
                        if ($keyName == 'label_id') {
                            $arr[] = Label::whereIn('id', $item[$keyName])->pluck('title');
                        } else {
                            $arr[] = array_get($item, $keyName);
                        }
                    }

                    return $arr;
                });
                $rows = empty($head) ? $bodyRows : collect([$head])->merge($bodyRows);
                $sheet->rows($rows);
            });
        })->export($ext);
    }
}
