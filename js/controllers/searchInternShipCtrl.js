app.controller("searchInternShipCtrl", ['$scope', '$http', '$location', '$rootScope', function ($scope, $http, $location, $rootScope) {

	$scope.name = localStorage.getItem('estagio-direito-username');
    $scope.iduser = localStorage.getItem('estagio-direito-iduser');
	$scope.usertype = localStorage.getItem('estagio-direito-usertype');
	$scope.email = localStorage.getItem('estagio-direito-email');
	
	if(location.hostname == 'localhost'){
		var urlPrefix = 'http://localhost:8888/Dev/Web/estagio-direito-v1-v2/api/vacancy.php.php';
		var urlOptionPrefix = 'http://localhost:8888/Dev/Web/estagio-direito-v1-v2/api/vacancy.php?option=';
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
	
	$scope.logout =function() {
        localStorage.clear();
        $location.path('/');
    }

	var searchAllVacancies = function() {
		// console.log('Search All Vacancies')
		var option = 'get all vacancies';
		$http.get(urlOptionPrefix + option).success(function(response) {
			// console.log(response)
			$scope.allVacancies = response;
		})
	}
	searchAllVacancies();

	$scope.searchForVacancy = function(vacancy) {
		console.log(vacancy)
	}

	
}]);