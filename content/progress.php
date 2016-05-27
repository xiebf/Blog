<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>CSS实现流程图</title>
	<link rel="stylesheet" type="text/css" href="../css/article.css">
	<link rel="stylesheet" type="text/css" href="../css/prism.css">
	<link type="text/css" href="calendar/css/calendar.css" rel="stylesheet" />
	<script src="../js/jscript_jquery-1.4.2.min.js" type="text/javascript"></script>
	<script src="calendar/js/calendar.js" type="text/javascript"></script>
	<script src="../js/prism.js"></script>
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
	            	<a href="progress.php" target="_blank">CSS实现流程图</a> 
	        	</b>
	        	<p>
	        		&nbsp;首先声明这个流程图不支持IE8以下，看看代码就知道了。主要用了CSS里的伪元素，作用就是在元素内容前面或者后面添加新的
	        	内容，这里又要区别以下伪类了，伪元素产生新对象，在dom中看不到，但是可以操作，伪类是dom中一个元素的不同状态。另外还有一个区分方法，伪类的效果可以通过添加一个实际的类来达到，而伪元素的效果则需要通过添加一个实际的元素才能达到，这也是为什么他们一个称为伪类，一个称为伪元素的原因。其实css3为了区分两者，已经明确规定了伪类用一个冒号来表示，而伪元素则用两个冒号来表示。
	            CSS样式如下：<br />
	        	<pre>
	        		<code class="language-css">
	*{
			margin: 0;
			padding: 0;
		}
		.flowChart{
			margin: 30px;
			overflow: hidden;
		}
		.flowChart li {
			color: #000;
			width: 8%;
			display: inline-block;
			text-align: center;
			float: left;
			position: relative;
		}
		.flowChart li:before {
			content: ' ';
			width: 16px;
			height: 16px;
			display: block;
			text-align: center;
			border-radius: 8px;
			background-color: #ccc;
			color: #fff;
			margin: 0 auto 5px auto;
		}
		.flowChart li:after {
			content: '';
			width: 100%;
			height: 4px;
			background: #ccc;
			position: absolute;
			left: -50%;
			top: 6px;
			z-index: -1;
		}
		.flowChart li:first-child:after {
			width: 60%;
			left: -10%;
		}
		.flowChart li.active:before, .flowChart li.active:after {
			background: #27AE60;
			color: white;
		}
	        		</code>
	        	</pre>
	    <p>html部分：</p>
	    <pre>
	        		<code class="language-markup">
	&lt;ul class="flowChart"/&gt;
		&lt;li class="active"/&gt;num1&lt;/li/&gt;
		&lt;li class="active"/&gt;num2&lt;/li/&gt;
		&lt;li/&gt;num3&lt;/li/&gt;
		&lt;li/&gt;num4&lt;/li/&gt;
		&lt;li/&gt;num5&lt;/li/&gt;
		&lt;li/&gt;num6&lt;/li/&gt;
		&lt;li/&gt;num7&lt;/li/&gt;
		&lt;li/&gt;num8&lt;/li/&gt;
	&lt;/ul/&gt;
	        		</code>
	        	</pre> 
	       	<p>效果图如下：
	       		<img id="progress_pic" src="../images/progress.JPG" alt="流程图" />
	       	</p>   	
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
				require('../config/db_mysql.php');
				global $db;
				$sql = "select * from app_wofw.wofw_reply where type = 'progress' ";
    			$rs = $db -> getAll($sql);
    			?>
			<div  class="replyList" style="<?php if(empty($rs)){echo'display:none;margin-top:28px;';} ?>">
				<div class="replyTop">评论列表</div>
				<?php 
					foreach ($rs as $key => $value) {
						echo '<div class="replyer">'.$value['name'].'&nbsp;&nbsp;'.$value['date_stamp'].'</div>';
						echo '<div class="replyContent">'.$value['reply_content'].'</div>';
					}
				?>				
			</div>
		<div class="reply" style="<?php if(empty($rs)){echo'margin-top:45px;';} ?>">
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
			var pre_data = {'username':username,'reply_content':reply_content,'type':'progress'};
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