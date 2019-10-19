<?php
namespace app\admin\controller;

use app\admin\model\Attr;
use app\admin\model\Brand;
use app\admin\model\BrandCate;
use app\admin\model\Cate;
use app\admin\model\GoodsAttr;
use app\admin\model\Type;
use app\admin\service\CateService;
use Faker\Provider\nl_NL\Text;
use think\Controller;
use think\Db;

class Goods extends Common
{
    public function goods_show()
    {
        $goods=\app\admin\model\Goods::all();

        return view('',['goods'=>$goods]);
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
            $file=request()->file('goods_img');
            // 移动到框架应用根目录/uploads/ 目录下
            $info = $file->move( '../public/uploads');
            if($info){
                // 成功上传后 获取上传信息
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                $file=$info->getSaveName();
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
            $goods_img=request()->domain().'/uploads/'.str_replace('\\','/',$file);
            //取所有post传值
            $data=request()->post();

            //处理数组 整理好属性表的数据
            $arr=[
                $data['attr_id'],$data['attr_name'],$data['attr_value'],$data['attr_type']
            ];
            $attr=[];

            for($i=0;$i<count($data['attr_id']);$i++){
                $attr[]=array_column($arr,$i);
            }
            //处理数组 去掉属性表有关的值
            unset($data['type_id']);
            unset($data['attr_id']);
            unset($data['attr_name']);
            unset($data['attr_type']);
            unset($data['attr_value']);
            $data['goods_img']=$goods_img;

            $goodsModel=new \app\admin\model\Goods();
            $goodsModel->save($data);
            $goods_id=$goodsModel->goods_id;

            //处理数据 添加品牌分类
            $brandCateModel=new BrandCate();
            $brandCateModel->save(['brand_id'=>$data['brand_id'],'cate_id'=>$data['cate_id']]);

            //添加属性表
            $goodsAttrModel=new GoodsAttr();
            foreach($arr[0] as $k=>$v){
               $d[]=[
                   'goods_id'=>$goods_id,
                   'attr_id'=>$arr[0][$k],
                   'attr_name'=>$arr[1][$k],
                   'attr_value'=>$arr[2][$k],
                   'attr_type'=>$arr[3][$k],
               ];
            }
            $goodsAttrModel->saveAll($d);
            $this->success('添加商品成功','goods_show');
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