app.controller("checkVacancyCtrl", ['$scope', '$http', '$location', '$routeParams', function ($scope, $http, $location, $routeParams) {

	$scope.name = localStorage.getItem('estagio-direito-username');
    $scope.iduser = localStorage.getItem('estagio-direito-iduser');
	$scope.usertype = localStorage.getItem('estagio-direito-usertype');
    $scope.email = localStorage.getItem('estagio-direito-email');
    
    $scope.idvacancy = $routeParams.idvacancy;
    // console.log(`idvacancy ${$scope.idvacancy}`)
	
	if(location.hostname == 'localhost'){
		var urlPrefix = 'http://localhost:8888/Projects/Web/estagio-direito/api/vacancy.php';
		var urlOptionPrefix = 'http://localhost:8888/Projects/Web/estagio-direito/api/vacancy.php?option=';
		var urlEmailPrefix = 'http://localhost:8888/Projects/Web/estagio-direito/api/mail.php';
	} else {
		var urlPrefix = 'api/vacancy.php';
		var urlOptionPrefix = 'api/vacancy.php?option=';
		var urlEmailPrefix = 'api/mail.php';
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
	
    var getInfoVacancy = function() {
        var option = 'get info vacancy';
        $http.get(urlOptionPrefix + option + '&idvacancy=' + $scope.idvacancy).success(function(response) {
            // console.log(response)
            $scope.vacancyData = response;
        })
    }
    getInfoVacancy();

    $scope.showInterestByVacancy = function(vacancyData) {
        vacancyData.iduserInterested = $scope.iduser;
        vacancyData.studentEmail = $scope.email;
        vacancyData.option = 'show interest by vacancy';
        // console.log(vacancyData)
        $http.post(urlPrefix, vacancyData).success(function(data) {
            // console.log(data)
            $http.post(urlEmailPrefix, data).success(function(response) {
                console.log(response)
            })
        })
    }
	
}]);