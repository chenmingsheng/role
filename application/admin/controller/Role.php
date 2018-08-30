<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/24
 * Time: 14:37
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use think\Db;
use think\facade\Request;
use think\Session;

class Role extends Common
{
    /**
     * @return mixed
     * 显示岗位列表页面
     */
    public function Rlist()
    {
        return $this->fetch('role/member-list');
//        $userinfo=$this->userinfo;
//        $info=Db::name('job')
//            ->alias('j')
//            ->join(['cms_structure'=>'s'],'j.s_id = s.s_id')
////            ->where("j_id",$userinfo['j_id'])
//            ->field('j.j_id,j.j_name,s.s_id,s.s_name')
//            ->select();

    }

    /**
     * 获取所有岗位角色
     */
    public function rinfo()
    {
        $count = Db::name('job')->count();
        $info = Db::name('job')
            ->alias('j')
            ->join(['cms_structure' => 's'], 'j.s_id = s.s_id')
            ->field('j.j_id,j.j_name,s.s_id,s.s_name')
            ->select();
        Jsonlist('0', '获取数据成功!', $count, $info);
    }

    /**
     * 显示岗位添加页面
     * ajax  添加信息
     */
    public function addlist()
    {
        if (Request::isAjax()) {
            $post = Request::post();
            if(empty($post['arr_m_id'])) echoJson(401,'请添加权限');
            $m_id = implode(',', $post['arr_m_id']);
            $data = [
                'j_name' => $post['j_name'],
                'm_id' => $m_id,
                's_id' => $post['s_id'],
            ];
            $state = Db::name('job')->insert($data);
            if ($state) {
                $type=Request::type();
                $time=Request::time();
                $this->inlog($type,'添加角色',$time);
                echoJson(200,'添加成功');
            }
        }else{
            $lick=Db::name('memu')->field('m_id as checkboxValue, m_name as name,  m_pid as pid')->select();
            $this->assign('json',json_encode(joblist($lick)));
            $data = Db::name('structure')->field('s_id,s_name')->select();
            $this->assign('sdata', $data);
        }
        return $this->fetch('role/member-add');
    }

    /**
     * 修改岗位信息
     *
     */
    public function rmodify()
    {
        if(Request::isAjax()){
            $info=Request::post();
            $m_id=implode(',',$info['id']);
            $state=Db::name('job')->where('j_id',$info["j_id"])->update(['m_id'=>$m_id,'j_name'=>$info['j_name']]);
            if($state){
                echoJson('200','修改成功');
            }else{
                echoJson('401','修改失败');
            }
        }else{
            $id=input('get.id');
            $info=Db::name('memu')->field('m_id as checkboxValue, m_name as name,  m_pid as pid')->select();
            $jid=Db::name('job')->where(['j_id'=>$id])->find();
            $this->assign('json',json_encode(rolelist($info,$jid['m_id'])));
            $this->assign('job',$jid);
        }
        return $this->fetch('role/modify');
    }
    /**
     * 删除角色
     */
    public function del(){
        $j_id=Request::post('j_id');
        $count=Db::name('user')->where("j_id='$j_id'")->count();
        if($count>0){
            echoJson('400','请先修改用户的角色权限!');
        }
        $id=Db::name('job')->where("j_id='$j_id'")->delete();
        $type=Request::type();
        $time=Request::time();
        if($id>0){
            $this->inlog($type,'删除角色',$time);
            echoJson('200','删除成功');
        }
    }
}