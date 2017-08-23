<?php
namespace app\admin\controller;
use think\Request;
use think\Db;

class Article extends Common
{
    public function index()
    {
        return view('article');
    }

    public function editArticle()
    {
        return view();
    }


    public function doEditArticle()
    {
        return view();
    }


    public function category()
    {
        return view();
    }

    public function editCategory()
    {
        return view();
    }


    public function doEditCategory()
    {
        $post = input('post.');
//        $post = Request::instance()->post();
//        print_r($post);die;
        $rs = saveData('article_category',$post);
//        $rs = Db::name('article_category')->insertGetId($post);
        if ( $rs ){
            $return = ['errno' => 0, 'errmsg' => ''];
        } else{
            $return = ['errno' => 1, 'errmsg' => '保存失败'];
        }
        ajaxReturn($return);
    }



}
