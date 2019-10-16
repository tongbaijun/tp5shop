<?php
namespace app\admin\controller;

use app\admin\service\LimitService;
use think\Controller;

class Limit extends Common
{
    //展示权限
    public function limit_show(){
        $li=(new \app\admin\model\Limit())::all();
        $limit=LimitService::getLimitByRecursion($li);
        $limit=LimitService::getLimitTree($limit);
        return view('',['limit'=>$limit]);
    }
    //添加权限
    public function add_limit(){
        if(request()->isGet()){
            $li=(new \app\admin\model\Limit())::all();
            $limit=LimitService::getLimitByRecursion($li);
            return view('',['limit'=>$limit]);
        }
        if(request()->isPost()){
            $limit_name=request()->post('limit_name');
            $limit_pid=request()->post('limit_pid');
            $limit_controller=request()->post('limit_controller');
            $limit_action=request()->post('limit_action');
            $limit_show=request()->post('limit_show');

            $data=['limit_name'=>$limit_name,'limit_pid'=>$limit_pid,'limit_controller'=>$limit_controller,'limit_action'=>$limit_action,'limit_show'=>$limit_show];
            $limit=new \app\admin\model\Limit();
            if($limit->save($data)){
                $this->success('添加权限成功','limit_show');
            }else{
                $this->error('添加权限失败');
            }
        }

    }
}