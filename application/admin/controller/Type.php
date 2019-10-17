<?php
namespace app\admin\controller;

use think\Controller;

class Type extends Common
{
    public function type_show()
    {
        $type=(new \app\admin\model\Type())::all();
        return view('',['type'=>$type]);
    }
    //添加类型
    public function add_type(){
        if(request()->isGet()){
            return view();
        }
       if(request()->isPost()){
           $type_name=request()->post('type_name','');
           $group_name=request()->post('group_name','');
           $data=['type_name'=>$type_name,'group_name'=>$group_name];
           if((new \app\admin\model\Type())->save($data)){
               $this->success('添加类型成功','Type/type_show');
           }
       }
    }
}
