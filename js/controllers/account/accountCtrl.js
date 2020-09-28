app.controller("accountCtrl", ['$scope', '$http', '$location', '$rootScope', function ($scope, $http, $location, $rootScope, viaCep) {

	$scope.name = localStorage.getItem('estagio-direito-username');
    $scope.iduser = localStorage.getItem('estagio-direito-iduser');
	$scope.usertype = localStorage.getItem('estagio-direito-usertype');
    $scope.email = localStorage.getItem('estagio-direito-email');
    // console.log($scope.name +' '+ $scope.usertype)

	if(location.hostname == 'localhost'){
		console.log('localhost')
		var urlPrefix = 'http://localhost:8888/Projects/Web/estagio-direito/api/register.php';
	} else {
		var urlPrefix = 'api/register.php';
		console.log('externo')
    }
    
    console.log($scope.usertype)
    if($scope.usertype == 'Estudante'){
        $scope.student = 1;
    } else if($scope.usertype == 'Escritório'){
        $scope.office = 1;
    } else {
        $scope.college = 1;
    }

    $scope.logout =function() {
        localStorage.clear();
        $location.path('/');
    }

	
}]);