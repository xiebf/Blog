/**
 * Created by Administrator on 2016/5/12.
 */
var app = angular.module('login-app', []);

app.controller('login-controller',function($scope,$http,$location,$window){
	$http.get("ajax.php?act=getCode")
	.success(function(response){
		$scope.check = response;
	});
	$scope.click = function(){
		$http.get("../admin/ajax.php?act=getCode")
		.success(function(response){
			$scope.check = response;
		});
	};
	$scope.login = function(){
		var root_path = "/sinaSAE/1/admin"
		$scope.nullName = false;
		$scope.nullWord = false;
		$scope.nullCaptcha = false;
		if($scope.username == undefined || $scope.username == ''){
			console.log($scope.username);
			$scope.nullName = true;
			return false;
		}else if($scope.password == undefined || $scope.password == ''){
			$scope.nullWord = true;
			return false;
		}else{
			if($scope.check == $scope.captcha){
				$http.get("../admin/ajax.php?act=login&username="+$scope.username+"&password="+$scope.password)
				.success(function(response){
					$window.alert(response.message);
					if(response.url != undefined){
						$window.location.href = root_path + response.url;
					}
				});
			}else{
				$scope.nullCaptcha = true;
				return false;
			}
		}
	};
	$scope.cancel = function(){
		$scope.username = "";
		$scope.password = "";
		$scope.captcha = "";
	};
});
