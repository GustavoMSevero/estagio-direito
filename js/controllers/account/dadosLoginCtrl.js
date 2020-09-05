app.controller("dadosLoginCtrl", ['$scope', '$http', '$location', '$rootScope', function ($scope, $http, $location, $rootScope, viaCep) {

	$scope.name = localStorage.getItem('estagio_direito_user_name');
	$scope.iduser = localStorage.getItem('estagio_direito_iduser');
	$scope.type = localStorage.getItem('estagio_direito_user_type');

	if(location.hostname == 'localhost'){
		console.log('localhost')
		var urlPrefix = 'http://localhost:8888/sistemas/Webapps/Projetos/estagio-direito/api/register.php';
		var urlOptionPrefix = 'http://localhost:8888/sistemas/Webapps/Projetos/estagio-direito/api/register.php?option=';
	} else {
		var urlPrefix = 'api/register.php';
		var urlOptionPrefix = 'api/register.php?option=';
		console.log('externo')
    }

    var getLogin = function(){
        var option = 'get email';
        $http.get(urlOptionPrefix + option + '&iduser=' + $scope.iduser).success(function(response){
            //console.log(response)
            $scope.newUser = response;
        })
    }
	getLogin();
	
	$scope.updateEmail = function(newUser){
		newUser.option = 'update email';
		newUser.iduser = $scope.iduser;
		//console.log(newUser);
		$http.post(urlPrefix, newUser).success(function(response){
			//console.log(response)
			if(response.status == 1){
				$location.path('/conta');
			}
		})
	}

	
}]);