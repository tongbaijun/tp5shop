<?php

namespace app\admin\model;

use think\Db;
use think\Model;

class Log extends Model
{
    //取所有的日志
    public static function getAllLog(){
       return Db::table('shop_log')->order('log_id desc')->limit(0,5)->select();
    }
    //取总条数
    public static function getLogCount(){
        return Db::table('shop_log')->count();
    }
    //添加日志
    public static function addLog($data){
        return Db::table('shop_log')->insert($data);
    }
}
