<?php
namespace app\admin\controller;

use app\admin\model\Attr;
use app\admin\model\Brand;
use app\admin\model\Cate;
use app\admin\model\Type;
use app\admin\service\CateService;
use think\Controller;
use think\Db;

class Goods extends Common
{
    public function goods_show()
    {
        return view();
    }
    //添加商品
    public function add_goods(){
        if(request()->isGet()){
            $type=Type::all();
            $cates=Cate::all();
            $cate=CateService::getCateByRecursion($cates);
            $brand=Brand::getAllBrand();
            return view('',['cate'=>$cate,'brand'=>$brand,'type'=>$type]);
        }
        if(request()->isPost()){
            $data=request()->post();
            dump($data);
        }
    }
    //商品删除
    public function delete_goods(){
        echo '我是商品删除';
    }
    //添加商品属性
    public function add_goods_attr(){
        $type_id=request()->post('type_id');

        if($attr=Attr::where('type_id',$type_id)->all()){
            foreach($attr as $key=>$val){
                if($val['attr_input_type']==1){
                    $attr_input_value=explode('，',$val['attr_input_value']);
                    $val['input_value']=$attr_input_value;
                }
            }
           return ['status'=>1,'msg'=>'ok','content'=>$attr];
        }else{
            return ['status'=>0,'msg'=>'not ok'];
        }
    }
}