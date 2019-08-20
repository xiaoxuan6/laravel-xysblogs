<?php

namespace App\Admin\Extensions;

use Encore\Admin\Grid;
use Encore\Admin\Grid\Exporters\AbstractExporter;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\Label;

class ExcelExpoter extends AbstractExporter
{
    protected $head = [];
    protected $body = [];
    protected $filename = '';
    protected $ext = '';

    public function __construct($filename, $head, $body, $ext = ''){
        $this->head = $head;
        $this->body = $body;
        $this->filename = $filename;
        $this->ext = $ext;
    }

    public function export()
    {
        $Filename = $this->filename;
        $ext = $this->ext ? $this->ext : 'xls';
        Excel::create($Filename, function($excel) use($Filename){
            $excel->sheet($Filename, function($sheet) {
                // 这段逻辑是从表格数据中取出需要导出的字段
                $head = $this->head;
                $body = $this->body;
                $bodyRows = collect($this->getData())->map(function ($item)use($body) {
                    foreach ($body as $keyName){
                        if($keyName == 'label_id'){
                            $arr[] = Label::whereIn('id', $item[$keyName])->pluck('title');
                        }else{
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