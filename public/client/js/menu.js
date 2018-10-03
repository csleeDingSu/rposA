var app = angular.module('arcade-app', ['ngAnimate', 'ngSanitize', 'ui.bootstrap']);

//Place Bet App
app.controller('PlaceBetCtrl', function ($scope, $log) {
    let lastChecked = null
	
	$scope.first_big = "冠军【大】";
	$scope.first_small = "冠军【小】";
	$scope.first_odd = "冠军【单】";
	$scope.first_even = "冠军【双】";
	
	$scope.second_big = "亚军【大】";
	$scope.second_small = "亚军【小】";
	$scope.second_odd = "亚军【单】";
	$scope.second_even = "亚军【双】";
	
	$scope.third_big = "第三【大】";
	$scope.third_small = "第三【小】";
	$scope.third_odd = "第三【单】";
	$scope.third_even = "第三【双】";
	
  $scope.radioCheckUncheck = function (event) {
    if (event.target.value === lastChecked) {
      delete $scope.forms.selected
      lastChecked = null
    } else {
      lastChecked = event.target.value
    }
  }
});

