<?php
namespace app\admin\controller;

use app\admin\model\Type;
use think\Controller;

class Attr extends Common
{
    public function attr_show()
    {
        $attr=\app\admin\model\Attr::all();
        return view('',['attr'=>$attr]);
    }
    //添加属性
    public function add_attr(){
        if(request()->isGet()){
            $type=(new \app\admin\model\Type())::all();
            return view('',['type'=>$type]);
        }
       if(request()->isPost()){
           $attr_name=request()->post('attr_name');
           $type_id=request()->post('type_id');
           $group_name=request()->post('group_name');
           $attr_type=request()->post('attr_type');
           $attr_input_type=request()->post('attr_input_type');
           $attr_input_value=request()->post('attr_input_value');

           $data=['attr_name'=>$attr_name,'type_id'=>$type_id,'group_name'=>$group_name,'attr_type'=>$attr_type,'attr_input_type'=>$attr_input_type,'attr_input_value'=>$attr_input_value];
           if((new \app\admin\model\Attr())->save($data)){
               $this->success('添加商品属性成功','Attr/attr_show');
           }else{
               $this->error('添加商品属性失败');
           }
       }
    }
    //根据所选商品类型 提供对应属性
    public function change(){
        $type_id=request()->post('type_id');
       if($type=(new \app\admin\model\Type())::get($type_id)){
           $group_name=$type->group_name;
           $group_name=explode('，',$group_name);
           echo json_encode(['status'=>1,'msg'=>'ok','content'=>$group_name]);
       }else{
           echo json_encode(['status'=>0,'msg'=>'not ok']);
       }
    }
}
