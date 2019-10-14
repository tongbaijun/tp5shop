<?php
namespace app\admin\controller;

use app\admin\model\Brand;
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
        $cates=\app\admin\model\Cate::getAllCate();
        $cate=\app\admin\model\Cate::getCateByRecursion($cates);
        $brand=Brand::getAllBrand();
        return view('',['cate'=>$cate,'brand'=>$brand]);
    }
}
