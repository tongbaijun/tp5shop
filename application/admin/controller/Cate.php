<?php
namespace app\admin\controller;

use app\admin\model\Log;
use think\Controller;
use think\Db;
use think\Session;
use think\Validate;

class Cate extends Common
{
    public function show()
    {
        $cates=\app\admin\model\Cate::getAllCate();
        $cate=\app\admin\model\Cate::getCateByRecursion($cates);
        return view('',['cate'=>$cate]);
    }
    //添加分类
    public function add_cate(){
        $session=session('admin');
        if(request()->isGet()){
            $cates=\app\admin\model\Cate::getAllCate();
            $cate=\app\admin\model\Cate::getCateByRecursion($cates);
            return view('',['cate'=>$cate]);
        }
        if(request()->isPost()){
            $cate_name=request()->post('cate_name','');
            $cate_pid=request()->post('cate_pid','');
            $cate_order=request()->post('cate_order','');
           if(empty($cate_name)){
               $this->error('分类名称不能为空');
           }
            $data=['cate_name'=>$cate_name,'cate_pid'=>$cate_pid,'cate_order'=>$cate_order];
            if(\app\admin\model\Cate::addCate($data)){
                $data=['admin_name'=>$session['admin_name'],'log_content'=>$session['admin_name'].'添加了分类','log_time'=>time(),'admin_ip'=>$_SERVER['REMOTE_ADDR']];
                Log::addLog($data);
                $this->success('添加分类成功','show');
            }else{
                $this->error('添加分类失败');
            }
        }

    }
    //切换是否展示
    public function change_show(){
        $session=session('admin');
        $cate_id=request()->post('cate_id','');
        $is_show=request()->post('is_show','')==0 ? 1 : 0;

        $data=['is_show'=>$is_show];
       if(\app\admin\model\Cate::updateCate($cate_id,$data)){
           $data=['admin_name'=>$session['admin_name'],'log_content'=>$session['admin_name'].'切换了是否显示的状态','log_time'=>time(),'admin_ip'=>$_SERVER['REMOTE_ADDR']];
           Log::addLog($data);
           echo json_encode(['status'=>1,'msg'=>'ok','content'=>$is_show]);
       }else{
           echo json_encode(['status'=>0,'msg'=>'not ok']);
       }
    }
    //切换是否导航栏
    public function change_nav_show()
    {
        $session=session('admin');
        $cate_id = request()->post('cate_id', '');
        $is_nav_show = request()->post('is_nav_show', '') == 0 ? 1 : 0;

        $data = ['is_nav_show' => $is_nav_show];
        if (\app\admin\model\Cate::updateCate($cate_id, $data)) {
            $data=['admin_name'=>$session['admin_name'],'log_content'=>$session['admin_name'].'切换了是否导航栏显示的状态','log_time'=>time(),'admin_ip'=>$_SERVER['REMOTE_ADDR']];
            Log::addLog($data);
            echo json_encode(['status' => 1, 'msg' => 'ok', 'content' => $is_nav_show]);
        } else {
            echo json_encode(['status' => 0, 'msg' => 'not ok']);
        }
    }
    //即点即改 分类名称
    public function change_cate_name(){
        $session=session('admin');
        $new_name=request()->post('new_name','');
        $cate_id=request()->post('cate_id','');
        $data=['cate_name'=>$new_name];
        if (\app\admin\model\Cate::updateCate($cate_id, $data)) {
            $data=['admin_name'=>$session['admin_name'],'log_content'=>$session['admin_name'].'修改了分类名称','log_time'=>time(),'admin_ip'=>$_SERVER['REMOTE_ADDR']];
            Log::addLog($data);
            echo json_encode(['status' => 1, 'msg' => 'ok', 'content' => $new_name]);
        } else {
            echo json_encode(['status' => 0, 'msg' => 'not ok']);
        }
    }
}
