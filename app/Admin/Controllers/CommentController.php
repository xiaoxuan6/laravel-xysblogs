<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Tool\GoBack;
use App\Events\ReplySendMail;
use App\Http\Controllers\Controller;
use App\Model\Article;
use App\Model\Discuss;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use James\Admin\Grid;
//use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use James\Admin\Breadcrumb\Layout\Content;
use App\Model\Comment;
use App\Admin\Extensions\Tool\Aactions;
use Illuminate\Http\Request;
use App\Admin\Extensions\Tool\SetStatus;
use Encore\Admin\Facades\Admin;
use App\Admin\Extensions\Tool\DeleteButton;
use Lib\Tool;

class CommentController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content,$id)
    {
        return $content
            ->header('评论')
            ->description('列表')
            ->body($this->grid($id));
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid($id)
    {
        $grid = new Grid(new Discuss);
        $grid->model()->where('article_id',$id)->orderBy('id', 'desc');
        $grid->id('ID');
        $grid->oauth()->username('昵称');
        $grid->oauth()->email('联系方式');
        $grid->comment('评论内容')->limit(30);
        $grid->status('状态')->display(function($status){
            switch ($status) {
                case '1':
                    return '<samp class="bg-green btn btn-xs fa grid-check-row">'. Discuss::$status_name[$status] .'</samp>';
                case '2':
                    return '<samp class="bg-blue btn btn-xs fa grid-check-row">'. Discuss::$status_name[$status] .'</samp>';
                case '3':
                    return '<samp class="bg-red btn btn-xs fa grid-check-row">'. Discuss::$status_name[$status] .'</samp>';
                default:
                    return '<samp class="bg-orange btn btn-xs fa grid-check-row">未知</samp>';
            }
        });
        $grid->pid('父级ID');
        $grid->created_at('评论时间');
        $grid->disableCreateButton();
        $grid->disableExport();
        $grid->disableFilter();
        $prefix = config('admin.route.prefix');
        $grid->actions(function ($actions) use ($prefix){
            $actions->disableEdit();
            $actions->disableView();
            $actions->disableDelete();
            $actions->append(new DeleteButton($actions->getKey(),'/'.$prefix.'/article/comment/delete/'));
            $actions->append(new Aactions($actions->getKey(),$actions->row->status));
            $actions->append("&nbsp;&nbsp;<a href='/".$prefix."/comment/detail-".$actions->getKey()."' class='btn btn-xs bg-purple fa grid-check-row' data-id='".$actions->getKey()."' title='回复';>回复</a>");
;        });
        $grid->tools(function($tools) use ($prefix){
            $tools->batch(function ($batch) use ($prefix){
                $batch->add('批量显示', new SetStatus(1, '/'.$prefix.'/comment/set-status'));
                $batch->add('批量隐藏', new SetStatus(2, '/'.$prefix.'/comment/set-status'));
                $batch->disableDelete();
            });
            $tools->append(new GoBack());
        });
        return $grid;
    }

    public function setStatus(Request $request, $id)
    {
        if(Discuss::where('id', $id)->update(['status' => $request->input('status')]))
            return 1;
        return 0;
    }

    public function status(Request $request)
    {
        $stauts = $request->input('status');
        $data = Discuss::whereIn('id', $request->input('ids'))->get();
        foreach ($data as $v){
            $v->status = $stauts;
            $v->save();
        }
    }

    public function reply(Content $content, $id){
        return $content
            ->header('回复')
            ->body($this->form($id));
    }

    protected function form($id)
    {
        $form = new Form(new Discuss());
        $name = Discuss::where('id', $id)->value('comment');
        $form->textarea('name','标题')->value($name)->readOnly();
        $form->textarea('comment','回复内容');
        $form->hidden('pid')->value($id);
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
            $tools->disableList();
        });
        $form->footer(function ($footer) {
            $footer->disableReset();
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });
        $form->setAction('/admins/comment/post');
        return $form;
    }

    public function commentReply(Request $request)
    {
        $pid = $request->input('pid');
        $comment = $request->input('comment');
        $arr = Discuss::where('id', $pid)->with('article')->first();

        $data = [
            'article_id' => $arr->article_id,
            'oauth_id' => 0,
            'comment' => $comment,
            'pid' => $pid,
            'ppid' => $arr ? $arr->id : 0,
            'status' => Discuss::STATUS_SHOW,
            'type' => $arr->article->user_id == Admin::user()->id ? 1 : 0,
        ];
        Discuss::create($data);

        admin_toastr('回复成功', 'success');
        return redirect('/'.config('admin.route.prefix').'/article/'.$arr->article_id.'/comment');
    }

    public function delete(Request $request, $id)
    {
        if (Discuss::destroy($id))
            return 1;

        return __LINE__;
    }

}
