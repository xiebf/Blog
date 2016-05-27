<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>SQL优化</title>
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
	            	<a href="optimization_of_sql.php" target="_blank">MYSQL的SQL优化</a> 
	        	</b>
	        	<p>
	        		&nbsp;之前在学校有学过数据库管理，能回忆起来的顶多只有建表和对表增删改操作，触发器什么的早就忘记了。突然让我一个前端去优化
        SQL，忍不住又要吐槽下了，主管作为数据库大师，我的入职师傅，就说句让我去优化下那些sql，也不给我指下方向。只好去询问度娘和请教同
        事了。优化了各种各样的sql，综合起来优化的都是查询sql，主要优化的也就那几个地方 :
				</p>
				<p>
				&nbsp;1、首先要看下sql的执行计划，查看sql的执行计划就是在你的sql前加上explain，explain select ...。
				</p>
				<p>
				&nbsp;从上到下是一个查询执行的顺序，select_type字段是说明select语句的类型，simple是最常见的类型，表明SQL只包含1个select语句，
				derived表明该行代表的数据表（derived table）其实是from子句中包含的子查询的输出结果，其余类型都可以直接去百度或者看官方文档。
				</p>
				<p>
				&nbsp;table字段表明explain输出的每行所代表的数据集来自哪张表，其值通常是具体的表名，当数据集是union的结果时，其值可能
				是&lt;unionM,N&gt;，当数据集来自derived table时，其值可能是&lt;derivedN&gt;。
				</p>
				<p>
				&nbsp;type字段表明各表是如何被join的，其取值比较复杂，详细可参考官网文档。
				</p>
				<p>
				&nbsp;possible_keys字段的值是可能被MySQL用作索引的字段，若值为NULL，则没有字段会被用作索引，因此查询效率不会高，这种情况
				下，需要优化数据表的索引结构。
				</p>
				<p>
				&nbsp;key字段的值是MySQL真正用到的索引。
				</p>
				<p>
				&nbsp;key_len字段的值表明上述key字段的length，当MySQL将某联合索引字段作为SQL执行时用到的索引时，key_len字段可以暗示MySQL
				真正在什么程度上（多长的最左前缀匹配字段）使用了该联合索引。
				</p>
				<p>
				&nbsp;ref字段的值表明数据表中的哪列或哪个constants会被用于与key字段指定的索引做比较。
				</p>
				<p>
				&nbsp;rows字段的值表明MySQL执行该步计划对应的query时必须扫描的行数。
				</p>
				<p>
				&nbsp;extra字段的值包含了MySQL执行query时的其它额外信息。该字段可能的取值情况较多，详细情况可参考官网文档的说明。
				</p>
				<p>
				&nbsp;查看下explain的每个字段的内容就能理解每个字段大概的意思了，当我们优化sql时，主要看的是rows字段，rows字段的数字越小，
				表示执行的效率越高，所以要抓住rows值比较大的那些行。
				</p>
				<p>
				&nbsp;首先看执行计划表的顺序和自己写sql拼接表的顺序是否一样，如果不一样，可以看下rows的值是不是减少了，如果增加了的话，
				就需要use&nbsp;index或者force&nbsp;index来让一些表强制使用索引，也可以用straight_join强制按照sql拼接表的顺序执行。
				</p>
				<pre>
	        		<code class="language-markup">
from wofw.reply use index(created_stamp,type)
from wofw.style force index(style_id)
	        		</code>
	        	</pre>
				<p>
					&nbsp;如果发现多个表的rows的值都很大，可以检查下拼接表时，关联字段的类型是否一致，比如Int类型和String类型关联是会对关联表
					进行全表扫描的。所以这时候需要用到convert(字段using utf8)或者cast(字段 as char(30))让int类型转换成string类型，这样关联表的
					rows的值就是1了。
				</p>
				<pre>
	        		<code class="language-markup">
INNER JOIN romeo.party p ON CONVERT( eoi.party_id using utf8) = p.party_id
LEFT JOIN ecshop.order_attribute oa1 on CAST(o.order_id AS UNSIGNED) = oa1.order_id
	        		</code>
	        	</pre>
	        	<p>
	        		&nbsp;如果查询的表row值很大，表有几十万条记录的话，查询的时候没有使用到索引，想优化查询效率就需要给该表加一个散列值高的索引，
	        		且在where条件中有限制该字段，这样会大大加快查询速度。散列值高的索引，就是每条记录都不相同的字段，比如说一个字段在表中不是Y就
	        		是N，那这个字段的散列值就很低了，就算把它设置为索引，使用这个索引时也不能加快多少查询速度，比如一些ID字段和时间字段设置为索引，
	        		使用这些字段时便会大大加快查询速度。
	        	</p>
	        	<p>
	        		&nbsp;以上都是自己对sql优化的一些见解，权当抛砖引玉，说的不全面，可能还有一些错误在里面，欢迎大家拍砖纠正！
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
				$sql = "select * from app_wofw.wofw_reply where type = 'optimization_of_sql' ";
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
			var pre_data = {'username':username,'reply_content':reply_content,'type':'optimization_of_sql'};
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