<?php
namespace app\admin\controller;

use app\admin\model\Goods;
use app\admin\model\GoodsAttr;
use think\Controller;
use think\Db;
use think\Validate;

class Product extends Common
{
    public function product_show(){
        $goods_id=request()->param('goods_id');
        $product=\app\admin\model\Product::where('goods_id',$goods_id)->all();
       // dump($product);
        foreach($product as $key=>$val) {
            //dump($val);
            $arr = explode('/', $val['goods_attr_id']);
            $goodsAttr = \app\admin\model\GoodsAttr::where('goods_id', $goods_id)->all($arr)->toArray();
            $new= array_column($goodsAttr, 'attr_value', 'goods_attr_id');
            //dump($b);
            $a=implode('+',$new);
            $val['goods_attr_id']=$a;
        }
        //dump($product);

      return view('',['goods_id'=>$goods_id,'product'=>$product]);
    }

    //添加货品
    public function add_product(){

        if(request()->isGet()){
            $goods_id=request()->param('goods_id');
            $attr=GoodsAttr::where(['goods_id'=>$goods_id,'attr_type'=>1])->select();
            $result =[];
            foreach($attr as $key=>$val){
                $result[$val['attr_name']][] =$val;
            }
            return view('',['result'=>$result,'goods_id'=>$goods_id]);
        }

        if(request()->isPost()){
            $data=request()->post("goods_attr_id");

            $goods_id=request()->param('goods_id');
            //处理数组
            $arr=[];
            foreach($data as $key=>$val){
                $goods_num=array_pop($val);
                $arr[$key]["goods_id"]=$goods_id;
                //获取拼接后的加价
                $goodsAttr = \app\admin\model\GoodsAttr::where('goods_id', $goods_id)->all($val)->toArray();
                $price=array_column($goodsAttr, 'attr_price', 'goods_attr_id');
                //dump($price);
                $sum=0;
                foreach($price as $kk=>$vv){
                    $sum+=intval($vv);
                }
                $arr[$key]["product_price"]=$sum;
                $arr[$key]["goods_attr_id"]=implode("/",$val);
                $arr[$key]["product_sn"]='TP'.substr(uniqid(),-4);
                $arr[$key]["product_num"]=$goods_num;
            }
            //判断 规格是否已寻在
            $goods_attr_id=\app\admin\model\Product::column('goods_attr_id');
            foreach($arr as $kk=>$vv){
                if(in_array($vv['goods_attr_id'],$goods_attr_id)){
                    $this->error('该规格已存在');
                }
            }
            //添加
            $productModel=new \app\admin\model\Product();
            if($productModel->saveAll($arr)){
                $this->success('添加货品成功',url('product_show',['goods_id'=>$goods_id]));
            }else{
                $this->error('添加货品失败');
            }
        }
    }
}