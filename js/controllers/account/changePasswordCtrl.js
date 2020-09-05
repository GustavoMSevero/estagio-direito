app.controller("changePasswordCtrl", ['$scope', '$http', '$location', '$rootScope', function ($scope, $http, $location, $rootScope) {
    
    $scope.name = localStorage.getItem('estagio-direito-username');
    $scope.iduser = localStorage.getItem('estagio-direito-iduser');
	$scope.usertype = localStorage.getItem('estagio-direito-usertype');
	$scope.email = localStorage.getItem('estagio-direito-email');

	if(location.hostname == 'localhost'){
		console.log('localhost')
		var urlPrefix = 'http://localhost:8888/Dev/Web/estagio-direito-v2/api/register.php';
	} else {
		var urlPrefix = 'api/register.php';
		console.log('externo')
    }

    $scope.updatePassword = function(user) {
        user.option = 'update password';
        user.iduser = $scope.iduser;
        // console.log(user)
        $http.put(urlPrefix, user).success(function(response) {
            console.log(response)
            if (response.status == 1){
                $scope.msg = response.msg;
            }
        })
    }

		
}]);