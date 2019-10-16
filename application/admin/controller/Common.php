<?php

namespace app\admin\controller;

use app\admin\model\AdminRole;
use app\admin\model\Limit;
use app\admin\model\LimitRole;
use app\admin\service\LimitService;
use think\Controller;
use think\facade\View;

class Common extends Controller{
    public function __construct()
    {
        parent::__construct();
        if(cookie("admin")&&!session("admin")){
            session("admin",cookie("admin"));
        }
        if(!session("admin")){
            $this->success("请先登录","Login/login");
        }
        //调用检查权限的方法
        if(!$this->checkAccess()){
           $this->success('该页面暂无权限访问','Index/index');
        }
        //左侧导航栏展示
        $this->leftShow();
    }
    //检查是否有权限
    public function checkAccess(){
        //是否是超级管理员登录
        if(in_array(session('admin')['admin_name'],config('web.super_admin'))){
            return true;
        }
        //判断是否是允许访问的页面
        $access=ucfirst(strtolower(request()->controller())).'/'. strtolower(request()->action());
        if(in_array($access,config('web.admin_access'))){
            return true;
        }
        $session=session('admin')['admin_id'];
        $adminRole=new AdminRole();
        //当前用户的角色
        $role_id= $adminRole->where('admin_id',$session)->column('role_id');
        $limitRole=(new LimitRole())::all();
        $limit_id=[];
        //取 角色对应的权限id
        foreach($limitRole as $k=>$v){
            if(in_array($v['role_id'],$role_id)){
                $limit_id[]=$v->limit_id;
            }
        }
        //取所拥有的权限id 对应的权限
        $limits=(new Limit())::all($limit_id);

        $my_access=[];
        foreach($limits as $k=>$v){
            $li_access=ucfirst(strtolower($v['limit_controller'])).'/'.strtolower($v['limit_action']);
           $v['limit_url']=$li_access;
            array_push($my_access,$li_access);
        }
       $my_access=array_unique($my_access);

        if(in_array($access,$my_access)){
            return true;
        }else{
            return false;
        }
    }
    //左侧导航栏展示
    protected function leftShow(){
        //是否是超级管理员登录
        if(in_array(session('admin')['admin_name'],config('web.super_admin'))){
            //展示所有权限
            $limit=Limit::where('limit_show',0)->all();

            foreach($limit as $k=>$v){
                $li_access=ucfirst(strtolower($v['limit_controller'])).'/'.strtolower($v['limit_action']);
            $v['limit_url']=$li_access;
        }
            $limits=LimitService::getLimitTree($limit);
            return View::share('limits',$limits);
        }else{
            //展示该用户的权限
            $session=session('admin')['admin_id'];
            $adminRole=new AdminRole();
            //当前用户的角色
            $role_id= $adminRole->where('admin_id',$session)->column('role_id');
            $limitRole=(new LimitRole())::all();
            $limit_id=[];
            //取 角色对应的权限id
            foreach($limitRole as $k=>$v){
                if(in_array($v['role_id'],$role_id)){
                    $limit_id[]=$v->limit_id;
                }
            }
            //取所拥有的权限id 对应的权限
            $limit=(new Limit())::all($limit_id);
            foreach($limit as $k=>$v){
                $li_access=ucfirst(strtolower($v['limit_controller'])).'/'.strtolower($v['limit_action']);
                $v['limit_url']=$li_access;
            }
            $limits=LimitService::getLimitTree($limit);
            //dump($limits);
            return View::share('limits',$limits);
        }
    }
}