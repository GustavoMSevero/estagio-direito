app.controller("officeDataCtrl", ['$scope', '$http', '$location', '$rootScope', function ($scope, $http, $location, $rootScope, viaCep) {

	$scope.name = localStorage.getItem('estagio-direito-username');
    $scope.iduser = localStorage.getItem('estagio-direito-iduser');
	$scope.usertype = localStorage.getItem('estagio-direito-usertype');
	$scope.email = localStorage.getItem('estagio-direito-email');

	if(location.hostname == 'localhost'){
		console.log('localhost')
		var urlPrefix = 'http://localhost:8888/Dev/Web/estagio-direito-v1-v2/api/register.php';
		var urlOptionPrefix = 'http://localhost:8888/Dev/Web/estagio-direito-v1-v2/api/register.php?option=';
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
        console.log(userOffice.zipcode)
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
            // console.log(response)
            localStorage.setItem('estagio-direito-username', response.officeName)
            if(response.status == 1){
                $scope.msg = response.msg;
                alert($scope.msg)
            }
        })
    }

	
}]);