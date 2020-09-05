app.controller("edirAdvertiseVacancyCtrl", ['$scope', '$http', '$location', '$routeParams', function ($scope, $http, $location, $routeParams) {

	$scope.name = localStorage.getItem('estagio-direito-username');
    $scope.iduser = localStorage.getItem('estagio-direito-iduser');
	$scope.usertype = localStorage.getItem('estagio-direito-usertype');
    $scope.email = localStorage.getItem('estagio-direito-email');
    
    $scope.idvacancy = $routeParams.idvacancy;

	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth() + 1; //January is 0!
	var yyyy = today.getFullYear();

	$scope.publishDate = yyyy+'-'+mm+'-'+dd;
	//console.log(publishDate)

	if(location.hostname == 'localhost'){
		console.log('localhost')
		var urlPrefix = 'http://localhost:8888/Dev/Web/estagio-direito-v1-v2/api/vacancy.php';
		var urlOptionPrefix = 'http://localhost:8888/Dev/Web/estagio-direito-v1-v2/api/vacancy.php?option=';
	} else {
		var urlPrefix = 'api/vacancy.php';
		var urlOptionPrefix = 'api/vacancy.php?option=';
		console.log('externo')
    }
    
    $scope.getZipcode = function(openVacancyOffice){
        // console.log(openVacancyOffice.zipcode)
        let cep = openVacancyOffice.zipcode;
        $http.get('http://viacep.com.br/ws/'+cep+'/json/').then(function(response){
            $scope.newOpenVacancyOffice.bairro = response.data.bairro;
            $scope.newOpenVacancyOffice.localidade = response.data.localidade;
            $scope.newOpenVacancyOffice.uf = response.data.uf;
        })
	};

	var getVacancy = function() {
		var option = 'get vacancy office';
		$http.get(urlOptionPrefix + option + '&idvacancy=' + $scope.idvacancy).success(function(response) {
			// console.log(response)
			$scope.newOpenVacancyOffice = response;
		})
	}
    getVacancy();
    
    $scope.updateVacancy = function(newOpenVacancyOffice) {
        newOpenVacancyOffice.option = 'update vacancy';
        newOpenVacancyOffice.idvacancy = $scope.idvacancy;
        // console.log(newOpenVacancyOffice)
        $http.put(urlPrefix, newOpenVacancyOffice).success(function(data) {
            // console.log(data)
            $location.path('/advertiseVacancy');
        })
    }
	
}]);