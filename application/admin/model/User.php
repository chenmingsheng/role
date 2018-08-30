<?php
namespace app\admin\model;

use think\Model;

class User extends Model
{
    public function jobs()
    {
        return $this->belongsToMany('Job');
    }
}