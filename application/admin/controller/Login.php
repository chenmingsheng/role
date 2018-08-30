<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\facade\Request;
use think\facade\Session;

class Login extends Controller
{
    public function login(){
        return $this->fetch('login/login');
    }
    public function linfo(){
        if(Request::isAjax()){
            $username=isSql(trim(input('post.username')));
            $password=isSql(trim(input('post.password')));
            $state=Db::name('user')->where("u_name='$username'")->find();
            if(!$state) echoJson('401','无当前用户!');
            if($state['u_state']==0) echoJson('401','你的帐号已被限制访问!');
            if(md5($password.$state['u_key'])!=$state['u_password']) echoJson('401','用户名密码错误!');
            Session::set('userinfo',$state);
            $data=[
                'l_name'=>$username,
                'l_ip'=>Request::ip(),
                'l_time'=>date('Y-m-d H:i:s',time())
            ];
            Db::name('login')->insert($data);
            echoJson('200','登录成功');
        }else{
            echoJson('401','非法请求');
        }

    }

    /**
     * 退出登录
     */
    public function logout(){
        Session::clear('userinfo');
        $this->redirect('/login');
    }
}