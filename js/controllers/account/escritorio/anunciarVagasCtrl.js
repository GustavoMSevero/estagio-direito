app.controller("anunciarVagasCtrl", ['$scope', '$http', '$location', '$rootScope', function ($scope, $http, $location, $rootScope, viaCep) {

	$scope.name = localStorage.getItem('estagio_direito_user_name');
	$scope.iduser = localStorage.getItem('estagio_direito_iduser');
	$scope.type = localStorage.getItem('estagio_direito_user_type');

	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth() + 1; //January is 0!
	var yyyy = today.getFullYear();

	$scope.publishDate = yyyy+'-'+mm+'-'+dd;
	//console.log(publishDate)

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
            //console.log(response.data)
            //$scope.openVacancyOffice.logradouro = response.data.logradouro;
            $scope.openVacancyOffice.bairro = response.data.bairro;
            $scope.openVacancyOffice.localidade = response.data.localidade;
            $scope.openVacancyOffice.uf = response.data.uf;
        })
	};

	$scope.registerVacancy = function(openVacancyOffice){
		openVacancyOffice.option = 'register vacancy';
		openVacancyOffice.iduser = $scope.iduser;
		openVacancyOffice.publishDate = $scope.publishDate;
		//console.log(openVacancyOffice)
		$http.post(urlPrefix, openVacancyOffice).success(function(response){
			//console.log(response)
			getAllVacancys();
			openVacancyOffice = {};
		})
	}

	var getAllVacancys = function(){
		option = 'get all vacancys';
		$http.get(urlOptionPrefix + option + '&iduser=' + $scope.iduser).success(function(response){
			//console.log(response)
			$scope.listaOfVacancys = response;
		})
	}
	getAllVacancys();
	
}]);