<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/24
 * Time: 16:37
 */

namespace app\admin\controller;

use think\Db;

class Structure extends Common
{
    /**
     * 部门数据
     */
    public function structure(){
        $list = Db::name('structure')->field('s_id as id, s_name as name, s_pid as pid')->select();
        $this->assign('json',json_encode(unlimitedForLayer($list)));
        return $this->fetch('structure/member-list');
    }


}