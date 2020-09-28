app.controller("studentCollegeDataCtrl", ['$scope', '$http', '$location', '$rootScope', function ($scope, $http, $location, $rootScope, viaCep) {

	$scope.name = localStorage.getItem('estagio-direito-username');
    $scope.iduser = localStorage.getItem('estagio-direito-iduser');
	$scope.usertype = localStorage.getItem('estagio-direito-usertype');
	$scope.email = localStorage.getItem('estagio-direito-email');

	if(location.hostname == 'localhost'){
		console.log('localhost')
		var urlPrefix = 'http://localhost:8888/Dev/Web/estagio-direito-v1-v2/api/student.php';
		var urlOptionPrefix = 'http://localhost:8888/Dev/Web/estagio-direito-v1-v2/api/student.php?option=';
	} else {
		var urlPrefix = 'api/register.php';
		console.log('externo')
    }


    var getCollegeData = function() {
        var option = 'get student data';
        $http.get(urlOptionPrefix + option + '&iduser=' + $scope.iduser).success(function(response) {
            // console.log(response)
            $scope.userStudent = response;
        })
    }
	getCollegeData();
	
	$scope.updateStudentData = function(userStudent) {
		userStudent.option = 'update student college data';
		userStudent.iduser = $scope.iduser;
		// console.log(userStudent)
		$http.put(urlOptionPrefix, userStudent).success(function(data) {
			// console.log(data.msg)
			$scope.msg = data.msg
		})
	}
	
}]);