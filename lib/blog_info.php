<?php
 
	function getTitle($type){
		global $db;
		$sql = "select title from app_wofw.blog_info where blog_type = '{$type}' ";
		$res = $db->getAll($sql);
		return $res;
  }
	function getContent($type,$title){
	  	global $db;
	  	$sql = "select blog_content from app_wofw.blog_info where blog_type = '{$type}' and title = '{$title}'";
	  	$res = $db->getAll($sql);
	  	return $res;
	}
	function isExist($title,$blog_type){
	    global $db;
	    $sql = "select 1 from app_wofw.blog_info where title = '{$title}' and blog_type = '{$blog_type}' ";
	    $res = $db->getAll($sql);
	    if(empty($res)){
	        return false;
	    }else{
	        return true;
	    }
	}
	function getBlogList(){
		global $db;
		$sql = "select blog_type,title,blog_content from app_wofw.blog_info order by blog_type";
		$res = $db->getAll($sql);
		return $res;
	}
?>