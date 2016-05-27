<?php
	require('../config/db_mysql.php');
	global $db;
	$result = array('status' => 0, 'message' => '');
	$username=$_POST['username'];
	$reply_content = $_POST['reply_content'];
	$type = $_POST['type'];
	$title = $_POST['title'];
	$sql = " insert into app_wofw.wofw_reply(name,date_stamp,reply_content,update_time,type,title) 
	values('{$username}',NOW(),'{$reply_content}',NOW(),'{$type}','{$title}') 
	";
	$res = $db->query($sql);
	$result['status'] = $res;
	if($res){
		$result['message'] = "回复成功！";
	}else{
		$result['message'] = "回复失败！";
	}
	echo json_encode($result);
?>