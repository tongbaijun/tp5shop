<?php
namespace app\admin\controller;

use think\Controller;

class Role extends Common
{
    public function role_show(){
      $role= \app\admin\model\Role::getAllRole();
         return view('',['role'=>$role]);
    }
    //添加角色
    public function add_role(){

        return view();
    }
}