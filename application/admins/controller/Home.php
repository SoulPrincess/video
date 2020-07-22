<?php
namespace app\admins\controller;

use think\Controller;
use Util\data\Sysdb;
class Home extends BaseAdmin{
    public function index(){
        $menus=false;
        $role=$this->db->table('admin_groups')->where(['gid'=>$this->_admin['gid']])->item();
        if($role){
            $role['rights']=(isset($role['rights'])&&$role['rights'])?json_decode($role['rights'],true):'';
        }
        if($role['rights']){
            $where="mid in(".implode(',',$role['rights']).") and ishidden=0 and status=0";
            $menus=$this->db->table('admin_menus')->where($where)->cates('mid');
            $menus && $menus=$this->gettreeitems($menus);
        }
        $site=$this->db->table('sites')->where(['names'=>'tite'])->item();
        $site && $site['values']=json_decode($site['values'],true);
        $this->assign('site',$site);
        $this->assign('role',$role);
        $this->assign('menus',$menus);
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
    public function welcome(){
        return $this->fetch();
    }
}