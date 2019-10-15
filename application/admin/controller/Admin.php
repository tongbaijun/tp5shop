<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Validate;

class Admin extends Common
{
    public function admin_show(){
       $admin=(new \app\admin\model\Admin())::all();

        return view('',['admin'=>$admin]);
    }
    //添加管理员
    public function add_admin(){
        if(request()->isGet()){
            return view();
        }
        if(request()->isPost()){
            $admin_name=request()->post('admin_name');
            $admin_pwd=request()->post('admin_pwd');
            $admin_email=request()->post('admin_email');
            $pwd_confirm=request()->post('pwd_confirm');
            //验证
            if($admin_pwd!=$pwd_confirm){
                $this->error('请确认密码是否正确');
                exit;
            }
            $validate = Validate::make([
                'admin_name'  => 'require|length:5,15;',
                'admin_pwd' => 'require',
                'admin_email'=>'require',
                'pwd_confirm' => 'require',
            ]);

            $data = [
                'admin_name'  => $admin_name,
                'admin_pwd' => $admin_pwd,
                'admin_email' => $admin_email,
                'pwd_confirm'=>$pwd_confirm
            ];
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }
            $sult=substr(uniqid(),-4);
            $admin_pwd=md5(md5($admin_pwd).$sult);
            $admin=['admin_name'  => $admin_name,'admin_pwd' => $admin_pwd,'admin_email' => $admin_email,'admin_sult'=>$sult,'add_time'=>time()];
            $user=new \app\admin\model\Admin();
            if($user->save($admin)){
                $this->success('添加管理员成功','Admin/admin_show');
            }else{
                $this->error('添加管理员失败');
            }

        }

    }
}