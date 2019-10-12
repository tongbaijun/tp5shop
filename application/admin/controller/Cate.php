<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Validate;

class Cate extends Common
{
    public function show()
    {
        $cates=\app\admin\model\Cate::getAllCate();
        $cate=\app\admin\model\Cate::getCateByRecursion($cates);
        return view('',['cate'=>$cate]);
    }
    //添加分类
    public function add_cate(){
        if(request()->isGet()){
            $cates=\app\admin\model\Cate::getAllCate();
            $cate=\app\admin\model\Cate::getCateByRecursion($cates);
            return view('',['cate'=>$cate]);
        }
        if(request()->isPost()){
            $cate_name=request()->post('cate_name','');
            $cate_pid=request()->post('cate_pid','');
            $cate_order=request()->post('cate_order','');
           if(empty($cate_name)){
               $this->error('分类名称不能为空');
           }
            $data=['cate_name'=>$cate_name,'cate_pid'=>$cate_pid,'cate_order'=>$cate_order];
            if(Db::table('shop_cate')->insert($data)){
                $this->success('添加分类成功','show');
            }else{
                $this->error('添加分类失败');
            }
        }

    }
}
