<?php
/**
 * Created by PhpStorm.
 * User: LHP
 * Date: 2020/7/8
 * Time: 10:50
 */

namespace app\admins\controller;


class Roles extends BaseAdmin
{
    /*角色列表*/
    public function index(){
        $data['lists']=$this->db->table('admin_groups')->lists();
        $this->assign('data',$data);
        return $this->fetch();
    }
    /*角色添加*/
    public function add(){
        $gid=(int)input('get.gid');
        //加载管理员信息
        $role=$this->db->table('admin_groups')->where(['gid'=>$gid])->item();
        $role && $role['rights']&& $role['rights']=json_decode($role['rights']);
        $menu_list=$this->db->table('admin_menus')->where(['status'=>0])->cates('mid');
        $menus=$this->gettreeitems($menu_list);
        foreach($menus as $k=>$v){
            $v['children']=isset($v['children'])?$this->formatMenus($v['children']):false;
            $results[]=$v;
        }

        $this->assign('menus',$results);
        $this->assign('role',$role);
        return $this->fetch();
    }
    /*返回树形菜单*/
    private function gettreeitems($items){
        $tree=[];
        foreach($items as $key=>$value){
            if(isset($items[$value['pid']])){
                $items[$value['pid']]['children'][]=&$items[$value['mid']];
            }else{
                $tree[]=&$items[$value['mid']];
            }
        }
        return $tree;
    }
    /*将二级三级菜单合并*/
    private function formatMenus($items,&$res=[]){
        foreach($items as $v){
            if(!isset($v['children'])){
                $res[]=$v;
            }else{
                $tem=$v['children'];
                unset($v['children']);
                $res[]=$v;
                $this->formatMenus($tem,$res);
            }
        }
        return $res;
    }
    /*保存角色*/
    public function save(){
        $gid=trim(input('post.gid'));
        $data['title']=trim(input('post.title'));
        $menus=input('post.menu/a');
        if(!$data['title']){
            exit(json_encode(['code'=>1,'msg'=>'角色名称不能为空']));
        }
        $menus && $data['rights']=json_encode(array_keys($menus));
        if($gid){
            $this->db->table('admin_groups')->where(['gid'=>$gid])->update($data);//修改
        }else{
            $this->db->table('admin_groups')->insert($data);//添加
        }

        exit(json_encode(['code'=>0,'msg'=>'保存成功']));
    }
    /*删除角色*/
    public function delete(){
        $gid=(int)input('post.gid');
        $res=$this->db->table('admin_groups')->where(['gid'=>$gid])->delete();
        if(!$res){
            exit(json_encode(['code'=>1,'msg'=>'删除失败']));
        }
        exit(json_encode(['code'=>0,'msg'=>'删除成功']));
    }
}