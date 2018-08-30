<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/23
 * Time: 15:11
 */

namespace app\admin\model;
use think\Model;

class Job extends Model
{
    public function user()
    {
//        return $this->belongsTo('User','j_id','uid');
    }
}