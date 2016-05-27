<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>表单中Readonly和Disabled的区别</title>
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
	            	<a href="disabled_readonly.php" target="_blank">表单中Readonly和Disabled的区别</a> 
	        	</b>
	        	<p>
	        		&nbsp;Readonly和Disabled是用在表单中的两个属性，它们都能够做到使用户不能够更改表单域中的内容。但是它们之间有着微小的差别，
	        总结如下：<br />
	        		&nbsp;Readonly只针对input(text / password)和textarea有效，而disabled对于所有的表单元素都有效，包括select, radio, checkbox, button等。
					&nbsp;但是表单元素在使用了disabled后，当我们将表单以POST或GET的方式提交的话，这个元素的值不会被传递出去，而readonly会将该值
			传递出去（这种情况出现在我们将某个表单中的textarea元素设置为disabled或readonly，但是submit button却是可以使用的）。<br />
				</p>
				<p>
					&nbsp;一般比较常用的情况是：<br />
				</p>
				<p>
					    &bull;&nbsp;&nbsp;在某个表单中为用户预填了某个唯一识别代码，不允许用户改动，但是在提交时需要传递该值，此时应该将它的属性设置为readonly。<br />
				</p>
				<p>
					    &bull;&nbsp;&nbsp;经常遇到当用户正式提交了表单后需要等待管理员的信息验证，这就不允许用户再更改表单中的数据，而是只能够查看，由于d
			isabled的作用元素范围大，所以此时应该使用disabled，但同时应该注意的是要将submitbutton也disabled掉，否则只要用户按了这个按钮，如果在数据库操作页面中没有做完整性检测的话，数据库中的值就会被清除。<br/>
						&nbsp;如果说在这种情况下用readonly来代替disabled的话，若表单中只有input(text/password)和textarea元素，那还是可以的，如
			果存在其他发元素，比如select，用户可以在重新改写值后按回车键进行提交（回车是默认的submit触发按键）。<br />
				</p>
				<p>
			&bull;&nbsp;&nbsp;我们常常在用户按了提交按钮后，利用javascript将提交按钮disabled掉，这样可以防止网络条件比较差的环境下，用户反复点提交按钮导致数据冗余地存入数据库。<br />
				</p>
				<p>
						&nbsp;disabled和readonly这两个属性有一些共同之处，比如都设为true，则form属性将不能被编辑，往往在写js代码的时候容易混合
			使用这两个属性，其实他们之间是有一定区别的。<br />
				</p>
				<p>
						&nbsp;如果一个输入项的disabled设为true，则该表单输入项不能获取焦点，用户的所有操作（鼠标点击和键盘输入等）对该输入项都
			无效，最重要的一点是当提交表单时，这个表单输入项将不会被提交。<br />
				</p>
				<p>
						&nbsp;而readonly只是针对文本输入框这类可以输入文本的输入项，如果设为true，用户只是不能编辑对应的文本，但是仍然可以聚焦
			焦点，并且在提交表单的时候，该输入项会作为form的一项提交。<br />
	        	</p>
	        	<p>
	        		小技巧：diabled可用readonly代替，background-color:#cccccc;加上灰色背景色就可以。
	        	</p>
	        	<pre>
	        		<code class="language-markup">
	&lt;input name="userName" type="text" value="readonly" readonly="readonly" /&gt;
	&lt;input name="password" type="text" value="disabled" disabled="disabled" /&gt;
	        		</code>
	        	</pre>
	        	
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
				$sql = "select * from app_wofw.wofw_reply where type = 'disabled_readonly' ";
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
			var pre_data = {'username':username,'reply_content':reply_content,'type':'disabled_readonly'};
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