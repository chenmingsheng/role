<?php

namespace app\admin\controller;
use think\Db;
use think\facade\Request;
use think\facade\Session;

class User  extends Common
{
    /**
     * @return mixed
     * 用户列表
     */
    public function user(){
        return $this->fetch('user/member-list');
    }

    /**
     * 获取用户数据
     */
    public function uinfo(){
        $data=Session::get('userinfo');
        if($data['uid']==1){
            $useinfo=Db::name('user')
                ->alias('u')
                ->join(['cms_job'=>'j'],'u.j_id=j.j_id')
                ->join('structure s','s.s_id=j.s_id')
                ->field("j.j_name,u.uid,u.u_name,u.u_nick,s_name")
                ->select();
            $count=Db::name('user')->count();
        }else{
            $useinfo=Db::name('user')
                ->alias('u')
                ->join(['cms_job'=>'j'],'u.j_id=j.j_id')
                ->join('structure s','s.s_id=j.s_id')
                ->field("j.j_name,u.uid,u.u_name,u.u_nick,s_name")
                ->where('u.uid > 1')
                ->select();
            $count=Db::name('user')->where('uid > 1')->count();
        }

        Jsonlist(0,'获取数据成功',$count,$useinfo);
    }

    /**
     * @return mixed
     * j_id  角色id
     */
    public function add(){
        if(Request::isAjax()){
            $info=Request::post();
            $u_key=rand(000000,999999);
            $data=[
                'j_id'         =>$info['j_id'],
                'u_name'       =>$info['u_name'],
                'u_password'  =>md5($info['u_password'].$u_key),
                'u_nick'       =>$info['u_nick'],
                'u_state'      =>$info['u_state'],
                'u_key'        =>$u_key
            ];
            $state=Db::name('user')->insert($data);
            if($state){
                echoJson(200,'添加成功');
            }else{
                echoJson(401,'添加失败',$data);
            }
        }else{
            $db=Db::name('job')->field('j_id,j_name')->select();
            $this->assign('job',$db);
            return $this->fetch('user/adduser');
        }
    }

    /**
     * @return mixed
     * 修改用户信息
     */
    public function edit(){
        if(Request::isAjax()){
            $info=Request::post();
            $u_key=rand(000000,999999);
            $data=[
                'j_id'=>$info['j_id'],
                'u_name'=>$info['u_name'],
                'u_state'=>$info['u_state'],
                'u_password'  =>md5($info['u_password'].$u_key),
                'u_key'        =>$u_key,
                'u_nick'       =>$info['u_nick'],
            ];
            $state=Db::name('user')->where(['uid'=>$info['uid']])->update($data);
            if($state){
                echoJson('200','修改成功');
            }else{
                echoJson('401','修改失败');
            }
        }else{
            $uid=Request::get('uid');
            $info=Db::name('user')->where("uid='$uid'")->find();
            $db=Db::name('job')->field('j_id,j_name')->select();
            $this->assign('info',$info);
            $this->assign('job',$db);
            return $this->fetch('user/edit');
        }
    }

    /**
     *
     */
    public function del(){
        $uid=Request::post('uid');
        $db=Db::name('user')->where("uid='$uid'")->delete();
        if($db>0){
            $this->inlog(Request::type(),'删除用户',Request::time());
            echoJson('200','删除成功');
        }else{
            echoJson('401','删除失败');
        }
    }
}