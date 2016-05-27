<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Jquery的attr和prop的区别</title>
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
	            	<a href="attr_and_prop.php" target="_blank">Jquery的attr和prop的区别</a> 
	        	</b>
	        	<p>
	        		&nbsp;今天被attr("checked")坑了，不管是勾上checkbox还是没有勾上checkbox，attr("checked")的值都是checked(进入页面后默认是
            checked)，如果不写checked属性的话，一直都是undefined， 后来换上prop("checked")就好了，之前只知道这两个方法类似，并不知道
            区别，这次遇到问题了就得自习看看为什么了，网上查了下资料，做一下记录:
	        	</p>
	        	<p>菜鸟教程上面说：</p>
	        	<p>注意：prop() 方法应该用于检索属性值，例如 DOM 属性（如 selectedIndex, tagName, nodeName, nodeType, ownerDocument, defaultChecked, 和 defaultSelected）。</p>
				<p>提示：如需检索 HTML 属性，请使用 attr() 方法代替。</p>
				<p>所以用prop("checked")时是可以获取属性当前的属性值的，但没有解释为啥attr("checked")不能用。下面借用大神总结的使用方法：</p>	
	        	<p>&bull;&nbsp;&nbsp;对于HTML元素本身就带有的固有属性，在处理时，使用prop方法。</p>
	        	<p>&bull;&nbsp;&nbsp;对于HTML元素我们自己自定义的DOM属性，在处理时，使用attr方法。</p>
	        	<p>上面的描述也许有点模糊，举几个例子就知道了。 </p>
	        	<pre>
	        		<code class="language-markup">
	&lt;a href="http://www.baidu.com" target="_self" class="btn"&gt;百度&lt;/a&gt;
	        		</code>
	        	</pre>
	        	<p>这个例子里&lt;a&gt;元素的DOM属性有“href、target和class"，这些属性就是&lt;a&gt;元素本身就带有的属性，也是W3C标准里就包含有这几个属性，或者说在IDE里能够智能提示出的属性，这些就叫做固有属性。处理这些属性时，建议使用prop方法。</p>
	        	<pre>
	        		<code class="language-markup">
	&lt;a href="#" id="link1" action="delete"&gt;删除&lt;/a&gt;
	        		</code>
	        	</pre>
	        	<p>这个例子里&lt;a&gt;元素的DOM属性有“href、id和action”，很明显，前两个是固有属性，而后面一个“action”属性是我们自己自定义上去的，&lt;a&gt;元素本身是没有这个属性的。这种就是自定义的DOM属性。处理这些属性时，建议使用attr方法。使用prop方法取值和设置属性值时，都会返回undefined值。</p>
	        	<p>像checkbox，radio和select这样的元素，选中属性对应“checked”和“selected”，这些也属于固有属性，因此需要使用prop方法去操作才能获得正确的结果。</p>
	        	<pre>
	        		<code class="language-markup">
	&lt;input type='checkbox' id='cb'/&gt;
	&lt;script&gt;
	//获取是否选中 
	var isChecked = $('#cb').prop('checked'); 
	//或 
	var isChecked = $('#cb').is(":checked"); 
	//设置选中 
	$('#cb').prop('checked',true); 
	&lt;/script&gt;
	        		</code>
	        	</pre>
	        	<p>另外说一下JQ1.6之前使用attr获取checked的属性值是没问题的，选中和没选中的值是不一样的，但是1.6版本之后，attr获取的
	        		checked属性值是一直不变的，只能使用prop获取checked的属性值。也可以这么理解，它将“属性”与“特性”做了区别，属性指的是“name，id”等等，特性指的是“selectedIndex, tagName, nodeName”等等。 标记一下，下次别掉坑里去了，哈哈</p>
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
				$sql = "select * from app_wofw.wofw_reply where type = 'attr_and_prop' ";
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
			var pre_data = {'username':username,'reply_content':reply_content,'type':'attr_and_prop'};
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