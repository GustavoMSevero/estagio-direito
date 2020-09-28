app.controller("editCourseCtrl", ['$scope', '$http', '$location', '$routeParams', function ($scope, $http, $location, $routeParams) {

	$scope.name = localStorage.getItem('estagio-direito-username');
    $scope.iduser = localStorage.getItem('estagio-direito-iduser');
	$scope.usertype = localStorage.getItem('estagio-direito-usertype');
    $scope.email = localStorage.getItem('estagio-direito-email');
    
    $scope.idcourse = $routeParams.idcourse;

    if(location.hostname == 'localhost'){
		console.log('localhost')
		var urlPrefix = 'http://localhost:8888/Dev/Web/estagio-direito-v1-v2/api/studentCourse.php';
		var urlPrefixOption = 'http://localhost:8888/Dev/Web/estagio-direito-v1-v2/api/studentCourse.php?option=';
	} else {
		var urlPrefix = 'api/register.php';
		console.log('externo')
    }

	var getStudentCourse = function() {
        var option = 'get student course';
        $http.get(urlPrefixOption + option + '&idcourse=' + $scope.idcourse).success(function(response) {
            // console.log(response)
            $scope.newCourse = response;
        })
    }
    getStudentCourse();

    $scope.updateStudentCourse = function(newCourse) {
        newCourse.option = 'update student course';
        newCourse.idcourse = $scope.idcourse;
        // console.log(newCourse);
        $http.put(urlPrefix, newCourse).success(function(data) {
            console.log(data)
            $scope.msg = data.msg;
        })

    }
	
}]);