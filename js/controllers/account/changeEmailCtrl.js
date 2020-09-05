app.controller("changeEmailCtrl", ['$scope', '$http', '$location', '$rootScope', function ($scope, $http, $location, $rootScope) {
    
    $scope.name = localStorage.getItem('estagio-direito-username');
    $scope.iduser = localStorage.getItem('estagio-direito-iduser');
	$scope.usertype = localStorage.getItem('estagio-direito-usertype');
	$scope.email = localStorage.getItem('estagio-direito-email');

	if(location.hostname == 'localhost'){
		console.log('localhost')
		var urlPrefix = 'http://localhost:8888/Dev/Web/estagio-direito-v2/api/student.php';
		// var urlOptionPrefix = 'http://localhost:8888/Dev/Web/estagio-direito-v2/api/student.php?option=';
		// var uploadFileUrlPrefix = 'http://localhost:8888/sistemas/Webapps/Projetos/estagio-direito/api/uploadCurriculo.php?iduser=';
	} else {
		var urlPrefix = 'api/register.php';
		console.log('externo')
    }

    $scope.updateEmail = function(student) {
        student.option = 'update email';
        student.iduser = $scope.iduser;

        $http.put(urlPrefix, student).success(function(response) {
            $scope.msgOK = response.msg;
            localStorage.setItem('estagio-direito-email', student.email);
            $scope.email = localStorage.getItem('estagio-direito-email');
        })
    }

		
}]);