app.controller("interestedListCtrl", ['$scope', '$http', '$location', '$rootScope', function ($scope, $http, $location, $rootScope, viaCep) {

	$scope.name = localStorage.getItem('estagio-direito-username');
    $scope.iduser = localStorage.getItem('estagio-direito-iduser');
	$scope.usertype = localStorage.getItem('estagio-direito-usertype');
	$scope.email = localStorage.getItem('estagio-direito-email');

	if(location.hostname == 'localhost'){
		console.log('localhost')
		var urlPrefix = 'http://localhost:8888/Dev/Web/estagio-direito-v1-v2/api/vacancy.php';
		var urlOptionPrefix = 'http://localhost:8888/Dev/Web/estagio-direito-v1-v2/api/vacancy.php?option=';
	} else {
		var urlPrefix = 'api/register.php';
		console.log('externo')
    }
    
    
    
	
}]);