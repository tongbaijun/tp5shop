<?php

namespace app\admin\model;

use think\Db;
use think\Model;

class Cate extends Model
{

    //修改分类
    public static function updateCate($cate_id,$data){
        if(self::table('shop_cate')->where(['cate_id'=>$cate_id])->update($data)){
            return true ;
        }
    }
}
