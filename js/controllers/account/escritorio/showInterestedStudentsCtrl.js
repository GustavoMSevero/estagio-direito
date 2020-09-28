app.controller("showInterestedStudentsCtrl", ['$scope', '$http', '$location', '$routeParams', function ($scope, $http, $location, $routeParams) {

	$scope.name = localStorage.getItem('estagio-direito-username');
    $scope.iduser = localStorage.getItem('estagio-direito-iduser');
	$scope.usertype = localStorage.getItem('estagio-direito-usertype');
    $scope.email = localStorage.getItem('estagio-direito-email');
    
    $scope.idvacancy = $routeParams.idvacancy;
	
	if(location.hostname == 'localhost'){
		var urlPrefix = 'http://localhost:8888/Projects/Web/estagio-direito/api/studentVacancy.php.php';
		var urlOptionPrefix = 'http://localhost:8888/Projects/Web/estagio-direito/api/studentVacancy.php?option=';
	} else {
		var urlPrefix = 'api/vacancy.php';
		console.log('externo')
	}

	console.log($scope.usertype)
    if($scope.usertype == 'Student'){
        $scope.student = 1;
    } else if($scope.usertype == 'Office'){
        $scope.office = 1;
    } else {
        $scope.college = 1;
	}

    var getStudentByVacancyInterested = function() {
        var option = 'get student by vacancy interested';
        $http.get(urlOptionPrefix + option + '&idvacancy=' + $scope.idvacancy).success(function(response) {
            // console.log(response)
            $scope.listOfInteretedStudents = response;
        })

    }
    getStudentByVacancyInterested();
    
	
}]);