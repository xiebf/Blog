<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>JS判断密码强度</title>
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
			<a href="https://github.com/xiebf" target="_blank"><img class="github" src="../images/github.png" alt="Fork me on github"></a>
			<p>进击の小风</p>
			</div>
			<hr />
			<div class="title">
				<b>
	            	<a href="password_level.php" target="_blank">JS判断密码强度</a> 
	        	</b>
	        	<p>
	        		&nbsp;收藏了一个JS判断密码强度的demo,用二进制1、10、100和1000分别表示含有数字、含有大写字母、含有
	    小写字母和含有其他字符的密码，用'|'运算组合多种类型的密码，再判断二进制数mode中1的个数来判断含有类型的个数，
	    判断完一个位数后，二进制数mode向右移一位，代码非常的精简,我自己来解决这个问题的话首选想到的便是构建数组或者对
	    象来存放各种密码情况。代码简洁，对于我这种学渣来说，也是又让我熟悉了一下JS基础知识。
	 			</p>
	 			<br />
	 			<p>
	 				html部分：
	 				<pre>
	 					<code class="language-markup">
	&lt;form name="form1" action=""&gt;
		密码:&lt;input type="password" size="8" onkeyup="pwdStrength(this.value)" onblur="pwdStrength(this.value)"&gt;
		&lt;br&gt;
		密码强度:
		&lt;table width="220px" border="1" cellspacing="0" cellpadding="1" bordercolor="#eeeeee" height="22px"&gt;
			&lt;tr align="center" bgcolor="#f5f5f5"&gt;
				&lt;td width="33%" id="strength_L"&gt;弱&lt;/td&gt;
				&lt;td width="33%" id="strength_M"&gt;中&lt;/td&gt;
				&lt;td width="33%" id="strength_H"&gt;强&lt;/td&gt;
			&lt;/tr&gt;
		&lt;/table&gt;
	&lt;/form&gt;
	 					</code>
	 				</pre>
	 			</p>
	 			<p>
	 				js部分：
	 				<pre>
	 					<code class="language-javascript">
	 	function pwdStrength(pwd) {
		    O_color = "#eeeeee";
		    L_color = "#FF0000";
		    M_color = "#FF9900";
		    H_color = "#33CC00";
		    var level = 0, strength = "O";
		    if (pwd == null || pwd == '') {
		        strength = "O";
		        Lcolor = Mcolor = Hcolor = O_color;
		    }
		    else {
		        var mode = 0;
		        if (pwd.length <= 4)
		            mode = 0;
		        else {
		            for (i = 0; i < pwd.length; i++) {
		                var charMode, charCode;
		                charCode = pwd.charCodeAt(i);
		                // 判断输入密码的类型
		                if (charCode >= 48 && charCode <= 57) //数字  
		                    charMode = 1;
		                else if (charCode >= 65 && charCode <= 90) //大写  
		                    charMode = 2;
		                else if (charCode >= 97 && charCode <= 122) //小写  
		                    charMode = 4;
		                else
		                    charMode = 8;
		                mode |= charMode;
		            }
		            // 计算密码模式
		            level = 0;
		            for (i = 0; i < 4; i++) {
		                if (mode & 1)
		                    level++;
		                mode >>>= 1;
		            }
		        }
		        switch (level) {
		            case 0:
		                strength = "O";
		                Lcolor = Mcolor = Hcolor = O_color;
		                break;
		            case 1:
		                strength = "L";
		                Lcolor = L_color;
		                Mcolor = Hcolor = O_color;
		                break;
		            case 2:
		                strength = "M";
		                Lcolor = Mcolor = M_color;
		                Hcolor = O_color;
		                break;
		            default:
		                strength = "H";
		                Lcolor = Mcolor = Hcolor = H_color;
		                break;
		        }
		    }
		    document.getElementById("strength_L").style.background = Lcolor;
		    document.getElementById("strength_M").style.background = Mcolor;
		    document.getElementById("strength_H").style.background = Hcolor;
		    return strength;
		}
	 					</code>
	 				</pre>
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
			<div class="demo">
				<a href="demo/demo2.html" target="_blank">查看示例</a>
			</div>
		<?php
				require('../config/db_mysql.php');
				global $db;
				$sql = "select * from app_wofw.wofw_reply where type = 'password_level' ";
    			$rs = $db->getAll($sql);
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
			var pre_data = {'username':username,'reply_content':reply_content,'type':'password_level'};
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