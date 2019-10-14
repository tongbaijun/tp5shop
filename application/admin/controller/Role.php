<?php
namespace app\admin\controller;

use app\admin\model\Admin;
use app\admin\model\Limit;
use think\Controller;

class Role extends Common
{
    public function role_show(){
        $all=Limit::getAllRoleLimit();
         return view('',['all'=>$all]);
    }
    //添加角色
    public function add_role(){
        if(request()->isGet()){
            $li=Limit::getAllLimit();
            $limit=Limit::getLimit($li);
            return view('',['limit'=>$limit]);
        }
       if(request()->isPost()){
           $role_name=request()->post('role_name');
           $role_desc=request()->post('role_desc');
           $limit_id=request()->post('limit_id');

           $data=['role_name'=>$role_name,'role_desc'=>$role_desc];

           $role_id=\app\admin\model\Role::addRole($data);
           if($role_id){
               foreach($limit_id as $key=>$val){
                   $data=['role_id'=>$role_id,'limit_id'=>$val];
                    Limit::add_role_limit($data);
               }
               $this->success('添加角色成功','role_show');
           }else{
               $this->error('添加角色失败');
           }
       }
    }
    //修改管理员角色
    public function update_role(){

        if(request()->isGet()){
            $li=Limit::getAllLimit();
            $limit=Limit::getLimit($li);
            $role=\app\admin\model\Role::getAllRole();
            $admin_id=request()->param('admin_id');
            return view('',['limit'=>$limit,'role'=>$role,'admin_id'=>$admin_id]);
        }
        if(request()->isPost()){
            $role_id=request()->post('role_id');
            $admin_id=request()->post('admin_id');
            $data=['admin_id'=>$admin_id,'role_id'=>$role_id];
            if(Admin::add_admin_role($data)){
                $this->success('添加管理员角色成功','Admin/admin_show');
            }else{
                $this->error('添加管理员角色失败');
            }
        }
    }
}