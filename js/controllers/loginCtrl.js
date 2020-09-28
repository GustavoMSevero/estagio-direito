app.controller("loginCtrl", ['$scope', '$http', '$location', '$rootScope', function ($scope, $http, $location, $rootScope) {

	if(location.hostname == 'localhost'){
		var urlOptionRegister = 'http://localhost:8888/Projects/Web/estagio-direito/api/register.php';
	} else {
		var urlPrefix = 'api/vacancy.php';
		console.log('externo')
	}

    $scope.loginUser = function(user){
        user.option = 'login user';
        //console.log(user)
        $http.post(urlOptionRegister, user).success(function(response) {
            // console.log(response)
            if(response.status == 0){
                $scope.msgLoginErro = response.msg;
                alert($scope.msgLoginErro)
            } 
            else {
                localStorage.setItem('estagio-direito-iduser', response.iduser);
                localStorage.setItem('estagio-direito-username', response.username);
                localStorage.setItem('estagio-direito-usertype', response.usertype);
                localStorage.setItem('estagio-direito-email', response.email);
                $location.path('/searchInternship');
            //     $location.path('/buscaPorSemestre').search({'option': $scope.option, 'half': $scope.half});
            }
        })
    }

	
}]);