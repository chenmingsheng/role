<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/23
 * Time: 11:16
 */

namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\facade\Session;
use think\facade\Request;

class Common extends Controller
{
    protected $userinfo;
    /**
     * 初始方法-》获取列表用户信息
     */
    protected function initialize()
    {
        parent::initialize();
        $userinfo=Session::get('userinfo');
        if(empty($userinfo)) $this->redirect('/login');
        $this->userinfo=$userinfo;
        $this->assign('userinfo',$userinfo);
        $this->memu($userinfo['j_id']);

    }

    /**
     * @param $jid  =>角色id
     *
     */
    public function memu($jid){
        //获取角色信息
        $info=Db::name('job')->where("j_id='$jid'")->find();
        $this->assign('jobInfo',$info);

        //获取菜单
        $data=Db::name('memu')->where("m_id in({$info['m_id']})")->select();
        //菜单列表
        $this->assign('memu',memu($data));

        //控制器
        $this->assign('CommonController',$this);
    }
    /**
     *菜单验证权限
     */
    public function vif($vif){
        $userinfo=$this->userinfo;
        $info=Db::name('job')->where(['j_id'=>$userinfo["j_id"]])->field('m_id')->find();
        $arr=explode(',',$info['m_id']);
        if(in_array($vif,$arr)){
            return true;
        }else{
            return false;
        }
    }
    /**
     * 日志管理
     * @param $type 操作类型
     * @param $text 操作文本
     * @param $time 操作时间
     */
    public function inlog($type,$text,$time='')
    {
        $userinfo=$this->userinfo;
        $ip=Request::ip();
        $url=Request::url();
        $time=Request::time();
        $data="用户:".$userinfo['u_name'].'->操作类型:'.$type.'->操作文本:'.$text.'->操作ip:'.$ip.'->操作URL：'.$url.'->操作时间'.$time;
        file_put_contents('./html/log/log.txt',$data.PHP_EOL,FILE_APPEND);
    }
}