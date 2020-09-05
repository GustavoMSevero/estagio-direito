app.controller("listaInteressadosCtrl", ['$scope', '$http', '$location', '$rootScope', function ($scope, $http, $location, $rootScope, viaCep) {

	$scope.name = localStorage.getItem('estagio_direito_user_name');
	$scope.iduser = localStorage.getItem('estagio_direito_iduser');
	$scope.type = localStorage.getItem('estagio_direito_user_type');

	if(location.hostname == 'localhost'){
		console.log('localhost')
		var urlPrefix = 'http://localhost:8888/sistemas/Webapps/Projetos/estagio-direito/api/vacancy.php';
		var urlOptionPrefix = 'http://localhost:8888/sistemas/Webapps/Projetos/estagio-direito/api/vacancy.php?option=';
	} else {
		var urlPrefix = 'api/register.php';
		console.log('externo')
    }

    var getAllInteresteds = function(){
        var option = 'get all interesteds';
        $http.get(urlOptionPrefix + option + '&iduser=' + $scope.iduser).success(function(response){
            //console.log(response)
            $scope.students = response;
        })
    }
    getAllInteresteds();

	
}]);