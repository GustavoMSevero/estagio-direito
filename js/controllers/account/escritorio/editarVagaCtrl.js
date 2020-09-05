app.controller("editarVagaCtrl", ['$scope', '$http', '$location', '$rootScope', '$routeParams', function ($scope, $http, $location, $rootScope, $routeParams) {

	$scope.name = localStorage.getItem('estagio_direito_user_name');
	$scope.iduser = localStorage.getItem('estagio_direito_iduser');
	$scope.type = localStorage.getItem('estagio_direito_user_type');

	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth() + 1; //January is 0!
	var yyyy = today.getFullYear();
	$scope.publishDate = yyyy+'-'+mm+'-'+dd;

    $scope.idvacancy = $routeParams.idvacancy;

	if(location.hostname == 'localhost'){
		console.log('localhost')
		var urlPrefix = 'http://localhost:8888/sistemas/Webapps/Projetos/estagio-direito/api/vacancy.php';
		var urlOptionPrefix = 'http://localhost:8888/sistemas/Webapps/Projetos/estagio-direito/api/vacancy.php?option=';
	} else {
		var urlPrefix = 'api/register.php';
		console.log('externo')
    }
    
    $scope.getZipcode = function(office){
        //console.log(office.zipcode)
        let cep = office.zipcode;
        $http.get('http://viacep.com.br/ws/'+cep+'/json/').then(function(response){
            $scope.openVacancyOffice.bairro = response.data.bairro;
            $scope.openVacancyOffice.localidade = response.data.localidade;
            $scope.openVacancyOffice.uf = response.data.uf;
        })
	};

    var getVacancy = function(){
        var option = 'get vacancy';
        $http.get(urlOptionPrefix + option + '&idvacancy=' + $scope.idvacancy).success(function(response){
            //console.log(response)
            $scope.newVacancyOffice = response;
        })
    }
    getVacancy();

    $scope.updateVacancy = function(newVacancyOffice){
        newVacancyOffice.option = 'update vacancy';
        newVacancyOffice.idvacancy = $scope.idvacancy;
        //console.log(newVacancyOffice)
        $http.post(urlPrefix, newVacancyOffice).success(function(response){
            //console.log(response)
            if(response.status == 1){
                $location.path('/anunciarVagas')
            }
        })
    }
	
}]);