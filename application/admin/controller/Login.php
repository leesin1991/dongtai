<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Session;

class Login extends Controller
{
    public function index()
    {
        return view('index/login');
    }

    public function doLogin()
    {
        $username = t($_POST['_username']);
        $admin = Db::name('admin')->where(['username' => $username] )->find();
        if ($admin){
            if ($admin['password'] === md5($_POST['_password'])){
                Session::set('login_admin',$admin);
                $return = ['errno' => 0 , 'errmsg' => ''];
            }else{
                $return = ['errno' => 1, 'errmsg' => '密码错误'];
            }
        }else{
            $return = ['errno' => 1 , 'errmsg' => '账号不存在'];
        }
        ajaxReturn($return);
    }

}
