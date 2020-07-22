<?php
/**
 * Created by PhpStorm.
 * User: LHP
 * Date: 2020/7/6
 * Time: 14:20
 */
namespace app\admins\controller;
class Admin extends BaseAdmin{
    /*管理员列表*/
    public function index(){
        $data['lists']=$this->db->table('admins')->lists();
        //加载角色
        $data['groups']=$this->db->table('admin_groups')->cates('gid');
        $this->assign('data',$data);
        return $this->fetch();
    }
    /*管理员添加*/
    public function add(){
        $id=(int)input('get.id');
        //加载管理员信息
        $data['item']=$this->db->table('admins')->where(['id'=>$id])->item();
        //加载角色
        $data['groups']=$this->db->table('admin_groups')->cates('gid');
        $this->assign('data',$data);
        return $this->fetch();
    }
    /*管理员保存*/
    public function save(){
        $id=(int)input('post.id');
        $data['username']=trim(input('post.username'));
        $password=trim(input('post.pwd'));
        $data['gid']=(int)input('post.gid');
        $data['truename']=trim(input('post.truename'));
        $data['status']=(int)input('post.status');

        if(!$data['username']){
            exit(json_encode(['code'=>1,'msg'=>'用户名不能为空']));
        }if($id==0&&!$password){
            exit(json_encode(['code'=>1,'msg'=>'密码不能为空']));
        }if(!$data['gid']){
            exit(json_encode(['code'=>1,'msg'=>'角色不能为空']));
        }if(!$data['truename']){
            exit(json_encode(['code'=>1,'msg'=>'真实姓名不能为空']));
        }
        if($password){
            $data['password']=md5($data['username'].$password);
        }
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
  /*删除管理员*/
    public function delete(){
        $id=(int)input('post.id');
        $res=$this->db->table('admins')->where(['id'=>$id])->delete();
        if(!$res){
            exit(json_encode(['code'=>1,'msg'=>'删除失败']));
        }
        exit(json_encode(['code'=>0,'msg'=>'删除成功']));
    }
}