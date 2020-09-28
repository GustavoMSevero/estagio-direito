app.controller("advertiseVacancyCtrl", ['$scope', '$http', '$location', '$rootScope', function ($scope, $http, $location, $rootScope, viaCep) {

	$scope.name = localStorage.getItem('estagio-direito-username');
    $scope.iduser = localStorage.getItem('estagio-direito-iduser');
	$scope.usertype = localStorage.getItem('estagio-direito-usertype');
	$scope.email = localStorage.getItem('estagio-direito-email');

	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth() + 1; //January is 0!
	var yyyy = today.getFullYear();

	$scope.publishDate = yyyy+'-'+mm+'-'+dd;
	//console.log(publishDate)

	if(location.hostname == 'localhost'){
		console.log('localhost')
		var urlPrefix = 'http://localhost:8888/Projects/Web/estagio-direito/api/vacancy.php';
		var urlOptionPrefix = 'http://localhost:8888/Projects/Web/estagio-direito/api/vacancy.php?option=';
	} else {
		var urlPrefix = 'api/vacancy.php';
		var urlOptionPrefix = 'api/vacancy.php?option=';
		console.log('externo')
    }
    
    $scope.getZipcode = function(openVacancyOffice){
        // console.log(openVacancyOffice.zipcode)
        let cep = openVacancyOffice.zipcode;
        $http.get('http://viacep.com.br/ws/'+cep+'/json/').then(function(response){
            $scope.openVacancyOffice.bairro = response.data.bairro;
            $scope.openVacancyOffice.localidade = response.data.localidade;
            $scope.openVacancyOffice.uf = response.data.uf;
        })
	};

	// $scope.registerVacancy = function(openVacancyOffice){
	// 	openVacancyOffice.option = 'register vacancy';
	// 	openVacancyOffice.iduser = $scope.iduser;
	// 	openVacancyOffice.publishDate = $scope.publishDate;
	// 	//console.log(openVacancyOffice)
	// 	$http.post(urlPrefix, openVacancyOffice).success(function(response){
	// 		//console.log(response)
	// 		getAllVacancys();
	// 		openVacancyOffice = {};
	// 	})
	// }

	// var getAllVacancys = function(){
	// 	option = 'get all vacancys';
	// 	$http.get(urlOptionPrefix + option + '&iduser=' + $scope.iduser).success(function(response){
	// 		//console.log(response)
	// 		$scope.listaOfVacancys = response;
	// 	})
	// }
	// getAllVacancys();

	$scope.registerVacancy = function(openVacancyOffice) {
		openVacancyOffice.option = 'register vacancy';
		openVacancyOffice.iduser = $scope.iduser;
		openVacancyOffice.publishDate = $scope.publishDate;
		// console.log(openVacancyOffice)
		$http.post(urlPrefix, openVacancyOffice).success(function(data) {
			// console.log(data)
			getAllVacancys();
		})
	}

	var getAllVacancys = function() {
		var option = 'get all vacancys this office';
		$http.get(urlOptionPrefix + option + '&iduser=' + $scope.iduser).success(function(response) {
			// console.log(response)
			$scope.listOfVacancys = response;
		})
	}
	getAllVacancys();
	
}]);