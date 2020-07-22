<?php
/**
 * 菜单管理
 * User: LHP
 * Date: 2020/7/7
 * Time: 17:06
 */

namespace app\admins\controller;


class Menu extends BaseAdmin
{
    /*菜单列表*/
    public function index(){
        $pid=(int)input('get.pid');
        $data['lists']=$this->db->table('admin_menus')->where(['pid'=>$pid])->lists();
        //返回上级菜单
        $backid=0;
        if($backid>0){
            $parent=$this->db->table('admin_menus')->where(['mid'=>$pid])->lists();
            $backid=$parent['pid'];
        }
        $this->assign('backid',$backid);
        $this->assign('pid',$pid);
        $this->assign('data',$data);
        return $this->fetch();
    }
    /*保存菜单*/
    public function save(){
        //前台提交过来是数组所以接收需要加'/a'
        $pid=(int)input('post.pid');
        $sort=input('post.sort/a');
        $title=input('post.title/a');
        $controller=input('post.controller/a');
        $method=input('post.method/a');
        $ishiddens=input('post.ishiddens/a');
        $status=input('post.status/a');
        foreach($sort as $k=>$v){
            $data['pid']=$pid;
            $data['sort']=$v;
            $data['title']=$title[$k];
            $data['controller']=$controller[$k];
            $data['method']=$method[$k];
            $data['ishidden']=isset($ishiddens[$k])?1:0;
            $data['status']=isset($status[$k])?1:0;
            if($k==0&&$data['title']){
                $this->db->table('admin_menus')->insert($data);//添加
            }
            if($k>0){
                if($data['title']==''&&$data['controller']==''&&$data['method']==''){
                    //删除
                    $this->db->table('admin_menus')->where(['mid'=>$k])->delete($data);
                } else{
                    //修改
                    $this->db->table('admin_menus')->where(['mid'=>$k])->update($data);
                }
            }
        }
        exit(json_encode(['code'=>0,'msg'=>'保存成功']));
    }
}