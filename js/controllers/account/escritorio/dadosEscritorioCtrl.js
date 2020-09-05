app.controller("dadosEscritorioCtrl", ['$scope', '$http', '$location', '$rootScope', function ($scope, $http, $location, $rootScope, viaCep) {

	$scope.name = localStorage.getItem('estagio_direito_user_name');
	$scope.iduser = localStorage.getItem('estagio_direito_iduser');
	$scope.type = localStorage.getItem('estagio_direito_user_type');

	if(location.hostname == 'localhost'){
		console.log('localhost')
		var urlPrefix = 'http://localhost:8888/sistemas/Webapps/Projetos/estagio-direito/api/register.php';
		var urlOptionPrefix = 'http://localhost:8888/sistemas/Webapps/Projetos/estagio-direito/api/register.php?option=';
	} else {
		var urlPrefix = 'api/register.php';
		console.log('externo')
    }
    
    var getOfficeData = function(){
        var option = 'get office data';
        $http.get(urlOptionPrefix + option + '&iduser=' + $scope.iduser).success(function(response){
            //console.log(response)
            $scope.userOffice = response;
        })

    }
    getOfficeData();

    $scope.getZipcode = function(userOffice){
        //console.log(userOffice.zipcode)
        let cep = userOffice.zipcode;
        $http.get('http://viacep.com.br/ws/'+cep+'/json/').then(function(response){
            //console.log(response.data)
            $scope.userOffice.logradouro = response.data.logradouro;
            $scope.userOffice.bairro = response.data.bairro;
            $scope.userOffice.localidade = response.data.localidade;
            $scope.userOffice.uf = response.data.uf;
        })
    };

    $scope.UpdateOfficeData = function(userOffice){
        userOffice.option = 'update office data';
        userOffice.iduser = $scope.iduser;
        //console.log(userOffice)
        $http.post(urlPrefix, userOffice).success(function(response){
            //console.log(response)
            localStorage.setItem('estagio_direito_user_name', response.officeName)
            if(response.status == 1){
                $location.path('/conta')
            }
        })
    }

	
}]);