app.controller("searchInternShipCtrl", ['$scope', '$http', '$location', '$rootScope', function ($scope, $http, $location, $rootScope) {

	$scope.name = localStorage.getItem('estagio-direito-username');
    $scope.iduser = localStorage.getItem('estagio-direito-iduser');
	$scope.usertype = localStorage.getItem('estagio-direito-usertype');
	$scope.email = localStorage.getItem('estagio-direito-email');
	
	if(location.hostname == 'localhost'){
		var urlPrefix = 'http://localhost:8888/Projects/Web/estagio-direito/api/vacancy.php';
		var urlOptionPrefix = 'http://localhost:8888/Projects/Web/estagio-direito/api/vacancy.php?option=';
	} else {
		var urlPrefix = 'api/vacancy.php';
		var urlOptionPrefix = 'api/vacancy.php?option=';
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

	var getAllVacancies = function() {
		var option = 'get all vacancies';
		$http.get(urlOptionPrefix + option).success(function(response) {
			// console.log(response)
			$scope.allVacancies = response;
		})
	}
	getAllVacancies();

	$scope.searchForVacancy = function(vacancy) {
		vacancy.option = 'search for vacancy';
		// console.log(vacancy)
		$http.post(urlPrefix, vacancy).success(function(vacancyResponse) {
			console.log(vacancyResponse)
			if (vacancyResponse.status == 0) {
				$scope.msgNoVacancyFound = vacancyResponse.msg;
			} else {
				$scope.msgNoVacancyFound =  '';
				$scope.allVacancies = vacancyResponse;
			}
			
		})
	}

	
}]);