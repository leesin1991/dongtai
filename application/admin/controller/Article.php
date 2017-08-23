<?php
namespace app\admin\controller;
use think\Request;
use think\Db;

class Article extends Common
{
    public function index()
    {
        $where['is_del'] = 0;
        $data = Db::name('article')->where($where)->select();
        $this->assign('data',$data);
        return view();
    }

    public function editArticle()
    {
        $where['id'] = input('post.id');
        $where['is_del'] = 0;
        $data = Db::name('article')->where($where)->find();
        $this->assign('data',$data);
        return view();
    }


    public function doEditArticle()
    {
        $post = input('post.');
        $rs = $this->saveData('article',$post);
        if ( $rs ){
            $return = ['errno' => 0, 'errmsg' => ''];
        } else{
            $return = ['errno' => 1, 'errmsg' => '保存失败'];
        }
        ajaxReturn($return);
    }


    public function category()
    {
        $where['is_del'] = 0;
        $data = Db::name('article_category')->where($where)->select();
        $this->assign('data',$data);
        return view();
    }

    public function editCategory()
    {
        $where['id'] = input('post.id');
        $where['is_del'] = 0;
        $data = Db::name('article_category')->where($where)->find();
        $this->assign('data',$data);
        return view();
    }


    public function doEditCategory()
    {
        $post = input('post.');
        $rs = $this->saveData('article_category',$post);
        if ( $rs ){
            $return = ['errno' => 0, 'errmsg' => ''];
        } else{
            $return = ['errno' => 1, 'errmsg' => '保存失败'];
        }
        ajaxReturn($return);
    }



}
