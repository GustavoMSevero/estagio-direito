app.controller("dadosFaculdadeCtrl", ['$scope', '$http', '$location', '$rootScope', function ($scope, $http, $location, $rootScope, viaCep) {

	$scope.name = localStorage.getItem('estagio_direito_user_name');
	$scope.iduser = localStorage.getItem('estagio_direito_iduser');
    $scope.type = localStorage.getItem('estagio_direito_user_type');
    //console.log(`iduser $scope.iduser`)

	if(location.hostname == 'localhost'){
		console.log('localhost')
		var urlPrefix = 'http://localhost:8888/sistemas/Webapps/Projetos/estagio-direito/api/college.php';
		var urlOptionPrefix = 'http://localhost:8888/sistemas/Webapps/Projetos/estagio-direito/api/college.php?option=';
	} else {
		var urlPrefix = 'api/college.php';
		var urlOptionPrefix = 'api/college.php?option=';
		console.log('externo')
    }

    var getCollegeData = function(){
        var option = 'get college data';
        $http.get(urlOptionPrefix + option + '&iduser=' + $scope.iduser).success(function(response){
            //console.log(response)
            $scope.newUser = response;
        })

    }
    getCollegeData();

    $scope.updateCollegeData = function(newUser){
        newUser.option = 'update college data';
        newUser.iduser = $scope.iduser;
        //console.log(newUser)
        $http.put(urlPrefix, newUser).success(function(response){
            //console.log(response)
            if(response.status == 1){
                $location.path('/conta');
            }
        })
    }
	

	
}]);