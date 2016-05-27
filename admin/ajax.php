<?php 
require '../config/db_mysql.php';
error_reporting(E_ALL ^ E_NOTICE);
session_start();
//在页首先要开启session,
//error_reporting(2047);
session_destroy();
//将session去掉，以每次都能取新的session值;
//用seesion 效果不错，也很方便

$act = $_REQUEST['act'];
if($act == 'getCode'){
    die($_SESSION["authnum_session"]);
}
if($act == 'login'){
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];
    global $db;
    $sql = "select * from app_wofw.admin_user where username = '{$username}'";
    $res = $db->getAll($sql);
    if(empty($res)){
    	$data['message'] = "找不到用户名！";
    }elseif(!empty($res) && $res[0]['password'] == $password){
    	$data['url'] = "/blog_add.php?"."username=".$username;
    	$data['message'] = "登录成功！";
    }else{
    	$data['message'] = "密码错误！";
    }
    die(json_encode($data));
}
if($act == 'add_blog'){
    $title = $_REQUEST['title'];
    $blog_type = $_REQUEST['blog_type'];
    $blog_cont = $_REQUEST['blog_cont'];
    $username = $_REQUEST['username'];
    $exist = isExist($title,$blog_type,$username);
    if($exist){
        $status = updateBlog($title,$blog_type,$username,$blog_cont);
    }else{
        $status = insertBlog($title,$blog_type,$username,$blog_cont);
    }
    if($status){
        $data['message'] = "博客发布成功！";
        $data['states'] = "success";
    }else{
        $data['message'] = "博客发布失败！";
        $data['states'] = "error";
    }
    die(json_encode($data));
}

function isExist($title,$blog_type,$username){
    global $db;
    $sql = "select 1 from app_wofw.blog_info where title = '{$title}' and blog_type = '{$blog_type}' and create_user = '{$username}' ";
    $res = $db->getAll($sql);
    if(empty($res)){
        return false;
    }else{
        return true;
    }
}

function updateBlog($title,$blog_type,$username,$blog_cont){
    global $db;
    $sql = "update app_wofw.blog_info set blog_content = '{$blog_cont}',update_stamp = NOW()  where title = '{$title}' and blog_type = '{$blog_type}' and create_user = '{$username}' ";
    return $db->query($sql);
}

function insertBlog($title,$blog_type,$username,$blog_cont){
    global $db;
    $sql = "insert into app_wofw.blog_info(blog_id,blog_type,title,blog_content,create_user,create_stamp,update_stamp) 
        values(null,'{$blog_type}','{$title}','{$blog_cont}','{$username}',NOW(),NOW())";
    return $db->query($sql);
}
?>