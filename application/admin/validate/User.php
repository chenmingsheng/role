<?php
namespace app\admin\validate;
use think\Validate;
class User extends Validate
{
    protected $rule =   [
        'u_name'  => 'require',
        'u_password'   => 'require',
    ];

    protected $message  =   [
        'u_name.require' => '用户名必须',
        'u_password.require' => ' 密码必须',
    ];
}