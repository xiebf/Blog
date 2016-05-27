<?php
	require_once('config.php');
    error_reporting(E_ALL ^ E_NOTICE);
     class DB{
         public $db_host;//localhost
         public $db_user;//用户名
         public $db_pwd;//密码
         public $db_name;//数据库名
         public $links;//链接名称
         //构造方法的参数和属性名字一致，但是含义不同
         function __construct($db_host,$db_user,$db_pwd,$db_name){
             $this -> db_host = $db_host;
             $this -> db_user = $db_user;
             $this -> db_pwd = $db_pwd;
             $this -> db_name = $db_name;
             //链接数据库代码
             $this -> links = mysql_connect($db_host,$db_user,$db_pwd);
             if(!$this -> links){
             	die("数据库链接失败");
             }
             //echo $this -> links;打印是资源
            mysql_query("set names utf8");
            mysql_select_db($db_name,$this->links);
              
         }
         function query($sql){//执行各种sql，inert update delete执行，如果执行select返回结果集
             return mysql_query($sql);
         }
         function numRows($sql){//返回select的记录数
             $result = $this -> query($sql);
             $count = mysql_num_rows($result);
             return $count;
         }
         function getOne($sql){//得到一条记录的一维数组
             $result = $this -> query($sql);
             $arr = mysql_fetch_assoc($result);
             return $arr;
         }
         function getAll($sql){//得到多条记录的二维数组
             $result = $this -> query($sql);
             $rows = array();
             while($rs = mysql_fetch_assoc($result)){
                 $rows[] = $rs;
             }
             return $rows;
         }
         function __destruct(){
             $this -> db_host = db_host;
             $this -> db_user = db_user;
             $this -> db_pwd = db_pwd;
             $this -> db_name = db_name;
         }
     }
      
    $db = new DB($db_name,$db_username,$db_password,"");
     //$sql = "insert into category(categoryName)values('常熟seo')";
     //$db -> query($sql);
      
     //返回select的记录数
     //$sql = "select * from category";
     //$count = $db -> numRows($sql);
     //echo $count;
      
     //得到一条记录的一维数组
     //$sql = "select * from category where categoryId=1";
     //$arr = $db -> getOne($sql);
     //<a href="https://www.baidu.com/s?wd=print_r&tn=44039180_cpr&fenlei=mv6quAkxTZn0IZRqIHckPjm4nH00T1YkPjuWujn3PjP9nycYmHKB0ZwV5Hcvrjm3rH6sPfKWUMw85HfYnjn4nH6sgvPsT6KdThsqpZwYTjCEQLGCpyw9Uz4Bmy-bIi4WUvYETgN-TLwGUv3EnHnvrjcknH01nW0zPWm1Pj6drf" target="_blank" class="baidu-highlight">print_r</a>($arr);
      
     //得到多条记录的二维数组
     // $sql = "select * from app_wofw.wofw_reply";
     // $rs = $db -> getAll($sql);
     // print_r($rs);


?>