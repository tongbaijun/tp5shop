<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;

class Brand extends Common
{
    public function brand_show()
    {
        $brand=Db::table('shop_brand')->select();
        return view('',['brand'=>$brand]);
    }
    public function add_brand()
    {
        if(request()->isGet()){
            return view();
        }
        if(request()->isPost()){
            $brand_name=request()->post('brand_name','');
            $brand_order=request()->post('brand_order','');
            $brand_desc=request()->post('brand_desc','');
            $file=request()->file('brand_logo');
            $is_show=request()->post('is_show','');
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
            $brand_logo=request()->domain().'/uploads/'.str_replace('\\','/',$file);
            $data=['brand_name'=>$brand_name,'brand_order'=>$brand_order,'brand_desc'=>$brand_desc,'brand_logo'=>$brand_logo,'is_show'=>$is_show];
            if(Db::table('shop_brand')->insert($data)){
                $this->success('添加品牌成功','brand_show');
            }else{
                $this->error('添加失败');
            }
        }
    }
}
