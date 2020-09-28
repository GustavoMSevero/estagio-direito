app.controller("changeEmailCtrl", ['$scope', '$http', '$location', '$rootScope', function ($scope, $http, $location, $rootScope) {
    
    $scope.name = localStorage.getItem('estagio-direito-username');
    $scope.iduser = localStorage.getItem('estagio-direito-iduser');
	$scope.usertype = localStorage.getItem('estagio-direito-usertype');
	$scope.email = localStorage.getItem('estagio-direito-email');

	if(location.hostname == 'localhost'){
		console.log('localhost')
		var urlPrefix = 'http://localhost:8888/Projects/Web/estagio-direito/api/register.php';
		var urlOptionPrefix = 'http://localhost:8888/Projects/Web/estagio-direito/api/register.php?option=';
	} else {
		var urlPrefix = 'api/register.php';
		var urlOptionPrefix = 'api/register.php?option=';
		console.log('externo')
    }

    var getUserEmail = function() {
        var option = 'get email';
        $http.get(urlOptionPrefix + option + '&iduser=' + $scope.iduser).success(function(response) {
            // console.log(response);
            $scope.user = response;
        })
    }
    getUserEmail();

    $scope.updateEmail = function(user) {
        user.option = 'update email';
        user.iduser = $scope.iduser;
        // console.log(user)
        $http.put(urlPrefix, user).success(function(response) {
            // console.log(response)
            $scope.msgOK = response.msg;
            localStorage.setItem('estagio-direito-email', user.email);
            $scope.email = localStorage.getItem('estagio-direito-email');
        })
    }

		
}]);