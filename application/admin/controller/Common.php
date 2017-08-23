<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;

class Common extends Controller
{

    public function _initialize()
    {
         if(!session('login_admin')){
            $this->error('您尚未登录系统',url('login/index'));
         }
    }

    public function saveData($table,$data)
    {
        $id = intval($data['id']);
        if($id < 1){
            $rs = Db::name($table)->insertGetId($data);
        }else{
            $rs = Db::name($table)->where(['id' => $id])->update($data);
        }
        return $rs;
    }
}