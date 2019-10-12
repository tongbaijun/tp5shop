<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Session;
use think\Validate;

class Login extends Controller
{
    // 登录
    public function login(){
        if(request()->isGet()){
            return view();
        }
       if(request()->isPost()){
            $admin_name=request()->post('admin_name','');
           $admin_pwd=request()->post('admin_pwd','');
           //验证
           $validate = Validate::make([
               'admin_name'  => 'require|length:5,15;',
               'admin_pwd' => 'require'
           ]);

           $data = [
               'admin_name'  => $admin_name,
               'admin_pwd' => $admin_pwd
           ];

           if (!$validate->check($data)) {
               $this->error($validate->getError());
           }

           if($admin=Db::table('shop_admin')->where('admin_name',$admin_name)->find()){
               if(md5(md5($admin_pwd).$admin['admin_sult'])==$admin['admin_pwd']){
                   $data=['admin_name'=>$admin_name,'log_content'=>$admin_name.'登陆了后台系统','log_time'=>time(),'admin_ip'=>$_SERVER['REMOTE_ADDR']];
                   Db::table('shop_log')->insert($data);
                   session('admin',$admin);
                   $this->success('登陆成功','Index/index');
               }else{
                   $this->error('登陆失败');
               }
           }else{
               $this->error('账号不存在');
           }
       }
    }
    //退出
    public function login_out(){
        session(null);
        $this->success('退出成功','Login/login');
    }

}
