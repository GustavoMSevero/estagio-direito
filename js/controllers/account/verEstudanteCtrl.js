app.controller("verEstudantesCtrl", ['$scope', '$http', '$location', '$rootScope', '$routeParams', function ($scope, $http, $location, $rootScope, $routeParams) {

	$scope.name = localStorage.getItem('estagio_direito_user_name');
	$scope.iduser = localStorage.getItem('estagio_direito_iduser');
    $scope.type = localStorage.getItem('estagio_direito_user_type');
    
    $scope.idStudent = $routeParams.iduser;
    //console.log(`id estudante ${$scope.idStudent}`)

	if(location.hostname == 'localhost'){
		console.log('localhost')
		var urlPrefix = 'http://localhost:8888/sistemas/Webapps/Projetos/estagio-direito/api/student.php';
		var urlOptionPrefix = 'http://localhost:8888/sistemas/Webapps/Projetos/estagio-direito/api/student.php?option=';
	} else {
		var urlPrefix = 'api/register.php';
		console.log('externo')
    }

    var getInfoStudent = function(){
        var option = 'get info student';
        $http.get(urlOptionPrefix + option + '&idstudent=' + $scope.idStudent).success(function(response){
            //console.log(response)
            $scope.studentInfo = response;
        })
    }
    getInfoStudent();

	
}]);