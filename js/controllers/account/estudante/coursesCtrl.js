app.controller("coursesCtrl", ['$scope', '$http', '$location', '$rootScope', function ($scope, $http, $location, $rootScope, viaCep) {

	$scope.name = localStorage.getItem('estagio-direito-username');
    $scope.iduser = localStorage.getItem('estagio-direito-iduser');
	$scope.usertype = localStorage.getItem('estagio-direito-usertype');
	$scope.email = localStorage.getItem('estagio-direito-email');

    if(location.hostname == 'localhost'){
		console.log('localhost')
		var urlPrefix = 'http://localhost:8888/Projects/Web/estagio-direito/api/studentCourse.php';
		var urlPrefixOption = 'http://localhost:8888/Projects/Web/estagio-direito/api/studentCourse.php?option=';
	} else {
		var urlPrefix = 'api/register.php';
		console.log('externo')
    }

	$scope.course = {};
    $scope.addStudentCourse = function(course){
		course.option = 'save course';
		course.iduser = $scope.iduser;
		// console.log(course)
		$http.post(urlPrefix, course).success(function(data) {
			// console.log(data)
			$scope.course = {};
			getAllCourse();
		})
	}

	var getAllCourse = function() {
		var option = 'get all courses';
		$http.get(urlPrefixOption + option + '&iduser=' + $scope.iduser).success(function(response) {
			// console.log(response)
			$scope.listCourses = response;
		})
	}
	getAllCourse();
	
}]);