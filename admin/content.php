<?php require '../config/db_mysql.php'; 
	  require '../lib/blog_info.php';

	  $title = $_REQUEST['title'];
	  $blog_type = $_REQUEST['blog_type'];
	  $exists = isExist($title,$blog_type);
	  if($exists){
	  	$res = getContent($blog_type,$title);
	  	$content = $res[0]['blog_content'];
	  }else{
	  	header('HTTP/1.1 404 Not Found'); 
		header('status: 404 Not Found');
		header("Content-type: text/html; charset=utf-8"); 
		echo "不存在此博客！";
		exit();
	  }       
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" type="text/css" href="../css/article.css">
	<link rel="stylesheet" type="text/css" href="../includes/kindeditor/plugins/code/prettify.css">
	<link type="text/css" href="../includes/calendar/css/calendar.css" rel="stylesheet" />
	<script src="../js/jscript_jquery-1.4.2.min.js" type="text/javascript"></script>
	<script src="../includes/calendar/js/calendar.js" type="text/javascript"></script>
	<script src="../includes/kindeditor/plugins/code/prettify.js"></script>
</head>
<body>
		<div class="main">
			<div class="header">
			<p>进击の小风</p>
			</div>
			<hr />
			<div class="title">
				<a href="https://github.com/xiebf" target="_blank"><img class="github" src="../images/github.png" alt="Fork me on github"></a>
				<b>
	            	<a href="#" target="_blank"><?php echo $title; ?></a> 
	            	<input type="hidden" value="<?php echo $title; ?>" id="blog_title" />
	            	<input type="hidden" value="<?php echo $blog_type; ?>" id="blog_type" />
	        	</b>
	        	<div id="blog_content">
	        		<?php echo $content; ?>
	        	</div>
			</div>
			<div class="program"></div>
			<div class="month-container">
	      		<div class="month-head"><span></span></div>
	      			<ul class="month-body">
		      			<div class="month-cell orange"><span>日</span></div>    
		      			<div class="month-cell blue"><span>一</span></div>
		      			<div class="month-cell blue"><span>二</span></div>
		      			<div class="month-cell blue"><span>三</span></div>
		      			<div class="month-cell blue"><span>四</span></div>     
		      			<div class="month-cell blue"><span>五</span></div>      
		      			<div class="month-cell blue"><span>六</span></div>
	      			</ul>
	      	<div class="clear"></div>
			</div>
			<?php
				global $db;
				$sql = "select * from app_wofw.wofw_reply where type = '{$blog_type}' and title = '{$title}' ";
    			$rs = $db -> getAll($sql);
    			?>
			<div  class="replyList" style="<?php if(empty($rs)){echo'display:none;';} ?>">
				<div class="replyTop">评论列表</div>
				<?php 
					foreach ($rs as $key => $value) {
						echo '<div class="replyer">'.$value['name'].'&nbsp;&nbsp;'.$value['date_stamp'].'</div>';
						echo '<div class="replyContent">'.$value['reply_content'].'</div>';
					}
				?>				
			</div>
			<div class="reply">
				<form>
					<span>马甲:</span>
					<input type="text" value="游客" id="username" />
					<textarea id="reply_content"></textarea>
					<input type="button" class="submit" value="提交" onclick="reply_add();" />
				</form>
			</div>
		</div>
	<script type="text/javascript">
		function reply_add(){
			var username = $('#username').val();
			var reply_content = $('#reply_content').val();
			var title = $('#blog_title').val();
			var type = $('#blog_type').val();
			var pre_data = {'username':username,'reply_content':reply_content,'type':type,'title':title};
			console.log(pre_data);
			$.ajax({
				url: '../admin/reply.php',
				type:'post',
				dataType: 'json',
				data: pre_data,
				success:function(data){
					alert(data.message);
					location.reload();
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.log(XMLHttpRequest.status);	
	                console.log(XMLHttpRequest.readyState);
	                console.log(textStatus);
				}
			});
		}
	</script>
</body>
</html>