<?php
namespace app\admins\controller;

use think\Controller;
use Util\data\Sysdb;

/*
 * 后台登录控制器
 */
class Account extends Controller{
    public function login(){
        return $this->fetch();
    }
    /*登录*/
    public function dologin(){
        $username=trim(input('post.username'));
        $password=trim(input('post.password'));
        $verifycode=trim(input('post.verifycode'));
        if($username==''){
            exit(json_encode(['code'=>1,'msg'=>'用户名不能为空']));
        }
        if($password==''){
            exit(json_encode(['code'=>1,'msg'=>'密码不能为空']));
        }
        if($verifycode==''){
            exit(json_encode(['code'=>1,'msg'=>'验证码不能为空']));
        }
        //验证验证码
        if(!captcha_check($verifycode)){
            exit(json_encode(['code'=>1,'msg'=>'验证码错误']));
        }
        //验证用户
        $this->db=new Sysdb();
        $admin=$this->db->table('admins')->where(['username'=>$username])->item();
        if(!$admin){
            exit(json_encode(['code'=>1,'msg'=>'用户名不存在']));
        }
        if(md5($admin['username'].$password)!=$admin['password']){
            exit(json_encode(['code'=>1,'msg'=>'密码错误']));
        }
        if($admin['status']==1){
            exit(json_encode(['code'=>1,'msg'=>'账号被禁用']));
        }
        //设置用户session
        session('admin',$admin);
        exit(json_encode(['code'=>0,'msg'=>'登录成功']));
    }

    public function logout(){
        session('admin',null);
        exit(json_encode(['code'=>0,'msg'=>'退出成功']));
    }
}