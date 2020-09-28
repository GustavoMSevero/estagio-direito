app.controller("vacancyListCtrl", ['$scope', '$http', '$location', '$routeParams', function ($scope, $http, $location, $routeParams) {

	$scope.name = localStorage.getItem('estagio-direito-username');
    $scope.iduser = localStorage.getItem('estagio-direito-iduser');
	$scope.usertype = localStorage.getItem('estagio-direito-usertype');
    $scope.email = localStorage.getItem('estagio-direito-email');
    
    $scope.idvacancy = $routeParams.idvacancy;
	
	if(location.hostname == 'localhost'){
		var urlPrefix = 'http://localhost:8888/Projects/Web/estagio-direito/api/vacancy.php.php';
		var urlOptionPrefix = 'http://localhost:8888/Projects/Web/estagio-direito/api/vacancy.php?option=';
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
    
    var getOfficeVacanciesList = function() {
        var option = 'get office vacancies list';
        $http.get(urlOptionPrefix + option + '&iduser=' + $scope.iduser).success(function(response) {
            // console.log(response)
            $scope.listVacancies = response;
        })
    }
    getOfficeVacanciesList();
	
}]);