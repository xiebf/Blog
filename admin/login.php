<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/login.css"/>
    <link href="http://cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://apps.bdimg.com/libs/angular.js/1.4.6/angular.min.js"></script>
    <title></title>
</head>
<body ng-app="login-app">
    <div id="mainBox" ng-controller="login-controller">
        <div class="login-title">
            <h3>MyBlog后台管理</h3>
        </div>
        <div class="form-inline">
            <div class="form-group clear">
                <label for="username" class="col-xs-4">用户名</label>
                <input type="text" id="username" ng-model="username" class="form-control col-xs-8" placeholder="username"/>
                <span class="error" ng-show="nullName">请填写账号</span>
            </div>
        </div>
       <div class="form-inline clear">
           <div class="form-group">
               <label for="password" class="col-xs-4">密码</label>
               <input type="text" id="password" ng-model="password" class="form-control col-xs-8" placeholder="password"/>
               <span class="error" ng-show="nullWord">请填写密码</span>
           </div>
       </div>
       <div class="form-inline">
           <div class="form-group clear">
                <div class="col-xs-6">
                    <img  title="点击刷新" id="check-img" src="captcha/captcha.php" ng-click="click();" onclick="this.src='captcha/captcha.php?'+Math.random();" />
                </div>
                <div class="col-xs-6 clear">
                    <input type="text" ng-model="captcha" id="captcha" class="form-control"  placeholder="验证码" required/>
                    <span ng-show="check == captcha" class="captcha_tip correct">验证码正确</span>
                    <span ng-show="(captcha.length >= 4 && check != captcha)" class="captcha_tip error">验证码错误</span>
                    <span class="captcha_tip error" ng-show="nullCaptcha && captcha == undefined">请填写验证码</span>
                </div>
           </div>
        </div>
        <div class="form-group">
            <div class="col-xs-6">
                <button class="btn btn-sm primary" id="login" ng-click="login();">登录</button>
            </div>
            <div class="col-xs-6">
                <button class="btn btn-sm default" id="cancel" ng-click="cancel();">取消</button>
            </div>
        </div>
    </div>
    <script src="../js/login.js"></script>
</body>
</html>