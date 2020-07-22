<?php
/**
 * Created by PhpStorm.
 * User: EDZ
 * Date: 2020/7/8
 * Time: 14:52
 */

namespace app\admins\controller;


class Site extends BaseAdmin
{
    /*管理员列表*/
    public function index(){
        $site=$this->db->table('sites')->where(['names'=>'tite'])->item();
        $site && $site['values']=json_decode($site['values'],true);
        $this->assign('site',$site);
        return $this->fetch();
    }
    /*管理员保存*/
    public function save(){
        $title=trim(input('post.title'));
        //检查名称是否存在
        $site=$this->db->table('sites')->where(['names'=>'tite'])->item();
        if(!$site){
            $res=$this->db->table('sites')->insert(['names'=>'tite','values'=>json_encode($title)]);
        }else{
            $value['values']=json_encode($title);
            $this->db->table('sites')->where(['names'=>'tite'])->update($value);
        }
        exit(json_encode(['code'=>0,'msg'=>'保存成功']));
        $res=true;//确保不做什么操作显示保存成功
        if($id==0){
            $data['add_time']=time();
            //检查用户是否存在
            $item=$this->db->table('admins')->where(['username'=>$data['username']])->item();
            if($item){
                exit(json_encode(['code'=>1,'msg'=>'该用户已存在']));
            }
            //保存数据
            $res=$this->db->table('admins')->insert($data);
        }else{
            $this->db->table('admins')->where(['id'=>$id])->update($data);
        }
        if(!$res){
            exit(json_encode(['code'=>1,'msg'=>'保存失败']));
        }
        exit(json_encode(['code'=>0,'msg'=>'保存成功']));
    }
}