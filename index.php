<?php 
    require 'config/db_mysql.php';
    require 'lib/blog_info.php';
    $blog_list = getBlogList();
    foreach ($blog_list as $key => $value) {
        $blog_list[$key]['blog_content'] = mb_substr($value['blog_content'],0,130,'utf-8')."...";
    }
    //var_dump($blog_list);
?>
<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>前端学习分享</title>
    <link rel="stylesheet" type="text/css" href="css/stylesheet_tm.css">
    <link rel="stylesheet" type="text/css" href="css/mainstyle.css">
    <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link href="//cdn.bootcss.com/font-awesome/3.1.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="js/jquery-2.1.1.min.js" type="text/javascript"></script>
    <script src="js/jscript_jquery.faded.js" type="text/javascript"></script>
    <script src="js/main.js" type="text/javascript"></script>
    <script src="js/bootstrap.js" type="text/javascript"></script>
</head>
<body>
    <div id="faded">
        <ul>
            <li><img height='468px' alt="" src="images/pic2.jpg" width='1024px'></li>
            <li><img height='468px' alt="" src="images/pic3.jpg" width='1024px'></li>
            <li><img height='468px' alt="" src="images/pic4.jpg" width='1024px'></li>
            <li><img height='468px' alt="" src="images/pic5.jpg" width='1024px'></li>
            <li><img height='468px' alt="" src="images/pic6.jpg" width='1024px'></li>
        </ul>
    </div>
    <a class="mscBtn start" id="audioBtn" style="cursor:pointer;">♬</a>
    <audio id="bgMusic" src="music/Westlife - Seasons In The Sun.mp3" autoplay="autoplay" loop="loop"></audio>
    <div id="nav">
        <ul>
            <li>
                <a href="index.php">
                    <i class="icon-home home"></i>
                    <span class="home">HOME</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="icon-reorder project"></i>
                    <span class="project">PROJECT</span>
                </a>
            </li>
            <li>
                <a href="content/Resume.html" target="_blank">
                    <i class=" icon-user-md about"></i>
                    <span class="about">ABOUT ME</span>
                </a> 
            </li>
        </ul>
    </div>
    
    <ul id="myTab" class="nav nav-tabs">
       <li class="active">
          <a href="#htm" data-toggle="tab">html/css</a>
       </li>
       <li><a href="#js" data-toggle="tab">javascript</a></li>
       <li><a href="#mysql" data-toggle="tab">mysql</a></li>
       <li><a href="#php" data-toggle="tab">php</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class='tab-pane fade in active' id='htm'>
    <?php foreach ($blog_list as $key => $value) { ?>
        <?php 
            if($value['blog_type'] == 'html'){
                echo "<div class='title_item'>";
                echo "<b><a class='title' href='admin/content.php?title=".$value['title']."&blog_type=".$value['blog_type']."' target='_blank'>".$value['title']."</a></b>";
                echo "<p class='title_content'>".$value['blog_content']."</p></div>";
            }
        ?>       
    <?php } ?>
        </div>
        <div class='tab-pane fade in' id='js'>
    <?php foreach ($blog_list as $key => $value) { ?>
        <?php 
            if($value['blog_type'] == 'javascript'){
                echo "<div class='title_item'>";
                echo "<b><a class='title' href='admin/content.php?title=".$value['title']."&blog_type=".$value['blog_type']."' target='_blank'>".$value['title']."</a></b>";
                echo "<p class='title_content'>".$value['blog_content']."</p></div>";
            }
        ?>       
    <?php } ?>
        </div>
        <div class='tab-pane fade in' id='mysql'>
    <?php foreach ($blog_list as $key => $value) { ?>
        <?php 
            if($value['blog_type'] == 'mysql'){
                echo "<div class='title_item'>";
                echo "<b><a class='title' href='admin/content.php?title=".$value['title']."&blog_type=".$value['blog_type']."' target='_blank'>".$value['title']."</a></b>";
                echo "<p class='title_content'>".$value['blog_content']."</p></div>";
            }
        ?>       
    <?php } ?>
        </div>
        <div class='tab-pane fade in' id='php'>
    <?php foreach ($blog_list as $key => $value) { ?>
        <?php 
            if($value['blog_type'] == 'php'){
                echo "<div class='title_item'>";
                echo "<b><a class='title' href='admin/content.php?title=".$value['title']."&blog_type=".$value['blog_type']."' target='_blank'>".$value['title']."</a></b>";
                echo "<p class='title_content'>".$value['blog_content']."</p></div>";
            }
        ?>       
    <?php } ?>
        </div>
    </div> 
    <div id="login">
        <div id="login_head"></div>
        <div id="login_body"></div>
        <span>
            <a href="admin/login.php" target="_blank">Login</a>
            </span>
    </div>
    <div id="up">
        <i class=" icon-angle-up"></i>
        <span>
            顶部
        </span>
    </div>
</body>
</html>