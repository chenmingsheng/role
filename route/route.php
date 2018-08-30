<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

//Route::get('hello/:name', 'index/hello');
//Route::get('new/:id', 'admin/admin/admin')
//    ->ext('html');
//Route::get('admin/index-:id-:name', 'admin/admin/admin')->ext('html');
//    ->model('id', '\app\admin\model\User');
//Route::get('admin/index-<name>-<id>', 'admin/admin/index_:name')->ext('html')
//    ->pattern(['name' => '\d+', 'id' => '\d+']);
Route::get('admin/$', 'admin/admin/admin');
return [
    'alist'=>'admin/admin/alist',       //管理员页面
    'arole'=>'admin/admin/arole',       //角色管理
    'add'=>'admin/admin/add',           //角色添加
    'login'=>'admin/login/login',       //登录页面
    'addlist'=>'admin/role/addlist',      //添加岗位页面
    'rmodify'=> 'admin/role/rmodify',     //修改页面
    'adduser'=>'admin/user/add',             //添加用户
    'edit'=>'admin/user/edit'               //修改用户
];
