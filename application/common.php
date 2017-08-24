<?php
// +----------------------------------------------------------------------
// | Function for ThinkPHP5 [ Brainy is the new sexy ~ ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017-2017 http://www.iawim.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.iawim.com/)
// +----------------------------------------------------------------------
// | Author: 李清 <leesin2011@163.com>
// +----------------------------------------------------------------------
use think\Controller;
use think\Db;
use think\Request;
use think\Session;

// 应用公共文件
error_reporting(E_ERROR | E_PARSE );


/**
 * http_curl
 * @param $url 接口url string
 * @param $type 请求类型 string
 * @param $res 返回数据类型 string
 * @param $arr post请求数组 array
 * @return error/json
 */
function http_curl($url="",$type='get',$res='json',$arr='')
{
    //1.初始化curl
    $ch = curl_init();
    //2.设置curl参数
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if ($type == 'post') {
        curl_setopt($ch, CURLOPT_POST, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
    }
    //3.采集
    $output = curl_exec($ch);
    //4.关闭
    curl_close($ch);
    if ($res == 'json') {
        if (curl_errno($ch)) {
            return curl_errno($ch);
        }
        else{
            return json_decode($output,TRUE);
        }
    }
}

/**
 *快捷打印变量
 * @param $val
 */
function p($val)
{
    if (is_bool($var)) {
        var_dump($val);
    }else {
        echo "<pre style='position:relative;z-index:1000;padding:10px;
		border-radius:5px;background:#F5F5F5;border:1px solid #aaa;font-size:14px;
		line-height:18px;opacity:0 9;'>".print_r($val,true)."</pre>";
        //print_r($val);
    }
}


/**
 * 创建多级文件夹 *
 * @param 路径 www.iawim.com/sing/public/uploads/
 * @param 权限 755/777 $mode
 */
function mkpath($path,$mode = 0777)
{
    $path = str_replace("\\","_|",$path);
    $path = str_replace("/","_|",$path);
    $path = str_replace("__","_|",$path);
    $dirs = explode("_|",$path);
    $path = $dirs[0];
    for($i = 1;$i < count($dirs);$i++)
    {
        $path .= "/".$dirs[$i];
        if(!is_dir($path))
            mkdir($path,$mode);
    }
}

/**
 * 前台登录检查
 *
 */
function checkHomeLogin()
{
    if(!session('login_user')){
        header("Location: /sing/index.php/index/login/index");
        //$this->error('您尚未登录系统',url('login/index'));
    }
}

/**
 * 后台登录检查
 *
 */
function checkBackLogin()
{
    if(!session('login_admin')){
        $this->error('您尚未登录系统',url('login/index'));
    }
}


/**
 * 获取某一字段的值
 * @param string $table
 * @param array $where
 * @param string $field
 * @return string
 */
function getFieldName($table,$where,$field='name')
{
    $rs = Db::name($table)->where($where)->value($field);
    return $rs;
}


/**
 * 生成随机数
 * @param 长度 $length
 * @param 是否是数字 $num
 * @return varchar
 */
function random($length=6,$num)
{
    $str = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";   //   输出字符集
    if($num)$str = "0123456789";   //   只输出数字
    $len = strlen($str)-1;
    for($i=0 ; $i<$length; $i++){
        $s .=  $str[rand(0,$len)];
    }
    return $s;
}

/**
 * 字符串加密
 * @param varchar $txt
 * @return varchar
 */
function encrypt($txt)
{
    return base64_encode(QING.$txt);
}

/**
 * 字符串解密
 * @param varchar $txt
 * @return varchar
 */
function decrypt($txt)
{
    $str =  base64_decode($txt);
    return str_replace(QING,"",$str);
}

/**
 * 信息提示
 * @param varchar $text
 * @param varchar $url
 */
function sysMsg($text,$url="history.go(-1);")
{
    $str = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />";
    $str .=  "<script>alert('$text');$url</script>";
    die($str);
}

/**
 * 数字列表
 * @param 开始 int $from
 * @param 结束 int $end
 * @param 排序 $sort
 * @return array
 */
function getNumList($from,$end,$sort)
{
    $arr = array();
    if($sort =="DESC"){
        for ($i=$end;$i>$from;$i--){
            $arr[$i] = $i;
        }
    }
    else{
        for ($i=$from;$i<$end;$i++){
            $arr[$i] = $i;
        }
    }
    return $arr;
}

/**
 * 过期时间
 * @param varchar $endtime
 * @return varchar
 */
function leavHr($endtime)
{
    $time = (strtotime($endtime)-time());
    if ($time >= 86400 ) {
        $day = floor($time/86400);
        $time = $time-$day*86400;
        $str = $day.'天';
        $str .= floor($time/3600).'小时';
    }
    else{
        $str = floor($time/3600).'小时';
    }
    return $str;
}

function ajaxReturn($data,$type = 'json'){
    exit(json_encode($data));
}

/*
 * 过滤非法html标签
 */

function t($text) {
    $text = nl2br($text);
    $text = real_strip_tags($text);
    $text = addslashes($text);
    $text = trim($text);
    return addslashes($text);
}

function real_strip_tags($str, $allowable_tags = "") {
    $str = stripslashes(htmlspecialchars_decode($str));
    return strip_tags($str, $allowable_tags);
}

/**
 * h函数用于过滤不安全的html标签，输出安全的html
 * @param string $text 待过滤的字符串
 * @param string $type 保留的标签格式
 * @return string 处理后内容
 */
function h($text, $type = 'html')
{
    // 无标签格式
    $text_tags = '';
    //只保留链接
    $link_tags = '<a>';
    //只保留图片
    $image_tags = '<img>';
    //只存在字体样式
    $font_tags = '<i><b><u><s><em><strong><font><big><small><sup><sub><bdo><h1><h2><h3><h4><h5><h6>';
    //标题摘要基本格式
    $base_tags = $font_tags . '<p><br><hr><a><img><map><area><pre><code><q><blockquote><acronym><cite><ins><del><center><strike>';
    //兼容Form格式
    $form_tags = $base_tags . '<form><input><textarea><button><select><optgroup><option><label><fieldset><legend>';
    //内容等允许HTML的格式
    $html_tags = $base_tags . '<meta><ul><ol><li><dl><dd><dt><table><caption><td><th><tr><thead><tbody><tfoot><col><colgroup><div><span><object><embed><param>';
    //专题等全HTML格式
    $all_tags = $form_tags . $html_tags . '<!DOCTYPE><html><head><title><body><base><basefont><script><noscript><applet><object><param><style><frame><frameset><noframes><iframe>';
    //过滤标签
    $text = real_strip_tags($text, ${$type . '_tags'});
    // 过滤攻击代码
    if ($type != 'all') {
        // 过滤危险的属性，如：过滤on事件lang js
        while (preg_match('/(<[^><]+)(ondblclick|onclick|onload|onerror|unload|onmouseover|onmouseup|onmouseout|onmousedown|onkeydown|onkeypress|onkeyup|onblur|onchange|onfocus|action|background|codebase|dynsrc|lowsrc)([^><]*)/i', $text, $mat)) {
            $text = str_ireplace($mat[0], $mat[1] . $mat[3], $text);
        }
        while (preg_match('/(<[^><]+)(window\.|javascript:|js:|about:|file:|document\.|vbs:|cookie)([^><]*)/i', $text, $mat)) {
            $text = str_ireplace($mat[0], $mat[1] . $mat[3], $text);
        }
    }
    return $text;
}

/**
 * URL跳转函数
 * @param string $url
 * @param integer $time 跳转延时(秒)
 * @param string $msg 提示语
 * @return void
 */
function redirect($url, $time = 0, $msg = '')
{
    //多行URL地址支持
    $url = str_replace(array("\n", "\r"), '', $url);
    if (empty($msg))
        $msg = "系统将在{$time}秒之后自动跳转到{$url}！";
    if (!headers_sent()) {
        // redirect
        if (0 === $time) {
            header("Location: " . $url);
        } else {
            header("Content-type: text/html; charset=utf-8");
            header("refresh:{$time};url={$url}");
            echo($msg);
        }
        exit();
    } else {
        $str = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
        if ($time != 0)
            $str .= $msg;
        exit($str);
    }
}
