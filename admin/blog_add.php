<?php 
    
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>BlogControlModel</title>
    <link href="http://cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/content.css"/>
    <script type="text/javascript" src="../includes/kindeditor/kindeditor-all.js"></script>
    <script src="http://cdn.bootcss.com/jquery/2.2.2/jquery.min.js"></script>
    <script type="text/javascript">
        KindEditor.ready(function(K) {
            var editor1 = K.create('textarea[name="content1"]', {
                cssPath : '../includes/kindeditor/plugins/code/prettify.css',
                filterMode: true,
                afterCreate : function() {
                    $('#publish').click(function(){
                        var title = $('#title').val();
                        var blog_type = $('#blog_type').val();
                        var blog_cont = editor1.html();
                        var username = $('#username').val();
                        $.ajax({
                            url: 'ajax.php?act=add_blog',
                            type: 'post',
                            dataType: 'json',
                            data: {title:title, blog_type:blog_type, blog_cont:blog_cont, username:username},
                            success: function(data){
                                console.log(data);
                                alert(data.message);
                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown){
                                console.log(XMLHttpRequest.status);
                                console.log(XMLHttpRequest.responseText);
                                console.log(textStatus);
                            }
                        });
                    });
                }
            });
        });
    </script>
</head>
<body>
    <?php $username = $_REQUEST['username']; ?>
    <div id="header">
        <div class="clear">
            <span id="hello">您好，<?php echo $username; ?></span>
        </div>
        <h3>后台编辑管理</h3>
    </div>
    <form method="post" action="">
        <div id="content">
            <div class="form-group clear">
                <label for="title" class="col-xs-1">博客文章标题</label>
                <input type="text" id="title" class="col-xs-11" name="title"/>
            </div>
            <div class="form-group clear">
                <label for="title" class="col-xs-1">博客文章分类</label>
                <select id="blog_type">
                    <option value="html">html/css</option>
                    <option value="javascript">javascript</option>
                    <option value="mysql">mysql</option>
                    <option value="php">php</option>
                </select>
            </div>
            <div class="form-group">
                <label>博客文章内容(kindeditor编辑器)</label>
                <textarea name="content1" class="control-group"></textarea>
            </div>
        </div>
        <div id="foot">
            <input type="button" class="btn btn-sm" id="publish" value="发布" />
            <input type="hidden" id="username" value="<?php echo $username; ?>"/>
        </div>
    </form>
</body>
</html>