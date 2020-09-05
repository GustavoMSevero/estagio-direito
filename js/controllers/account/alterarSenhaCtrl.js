app.controller("alterarSenhaCtrl", ['$scope', '$http', '$location', '$rootScope', function ($scope, $http, $location, $rootScope, viaCep) {

	$scope.name = localStorage.getItem('estagio_direito_user_name');
	$scope.iduser = localStorage.getItem('estagio_direito_iduser');
	$scope.type = localStorage.getItem('estagio_direito_user_type');

	if(location.hostname == 'localhost'){
		console.log('localhost')
		var urlPrefix = 'http://localhost:8888/Dev/Web/estagio-direito-v1-v2/api/register.php';
		var urlOptionPrefix = 'http://localhost:8888/Dev/Web/estagio-direito-v1-v2/api/register.php?option=';
	} else {
		var urlPrefix = 'api/register.php';
		console.log('externo')
    }

    $scope.updatePassword = function(user){
        user.option = 'update password';
        user.iduser = $scope.iduser;
        $http.post(urlPrefix, user).success(function(response){
            //console.log(response)
            $scope.user = {};
            if(response.status == 0){
                $scope.msg = response.msg;
            } else {
                $location.path('/conta');
            }
        })
    }

	
}]);