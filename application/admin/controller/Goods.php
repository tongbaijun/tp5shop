<?php
namespace app\admin\controller;

use app\admin\model\Brand;
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
        $cates=(new \app\admin\model\Cate())::all();
        $cate=CateService::getCateByRecursion($cates);
        $brand=Brand::getAllBrand();
        return view('',['cate'=>$cate,'brand'=>$brand]);
    }
    //商品删除
    public function delete_goods(){
        echo '我是商品删除';

    }
}
