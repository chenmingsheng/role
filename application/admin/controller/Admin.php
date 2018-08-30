<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
class Admin extends Common
{
    /**
     * @return mixed
     * 后台页面
     */
    public function admin(){
        return $this->fetch();
    }

    /**
     * @return mixed
     * 管理员页面
     */
    public function alist(){
        return $this->fetch('admin/admin-list');
    }

    /**
     * @return mixed
     * 角色管理
     */
    public function arole(){
        return $this->fetch('admin/admin-role');
    }
    public function add(){
        return $this->fetch('admin/admin-add');
    }
}