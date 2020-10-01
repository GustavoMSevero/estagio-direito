app.controller("initialCtrl", ['$scope', '$http', '$location', '$rootScope', function ($scope, $http, $location, $rootScope, viaCep) {

	if(location.hostname == 'localhost'){
		console.log('localhost')
		var urlPrefix = 'http://localhost:8888/Projects/Web/estagio-direito/api/register.php';
	} else {
		var urlPrefix = 'api/register.php';
		console.log('externo')
    }
    
    $scope.escritorio = false;
    $scope.estudante = false;
    $scope.faculdade = false;

    $scope.changeType = function(){
        if($scope.type == "Office"){
            $scope.escritorio == true;
        } else if($scope.type == "Student"){
            $scope.estudante == true;
        } else {
            $scope.faculdade == true;
        }

        $rootScope.type = $scope.type;
    }

    $scope.getZipcode = function(user){
        //console.log(user.zipcode)
        let cep = user.zipcode;
        $http.get('http://viacep.com.br/ws/'+cep+'/json/').then(function(response){
            //console.log(response.data)
            $scope.user.logradouro = response.data.logradouro;
            $scope.user.bairro = response.data.bairro;
            $scope.user.localidade = response.data.localidade;
            $scope.user.uf = response.data.uf;
        })
    };

    $scope.register = function(user){
        user.option = 'register user';
        user.type = $rootScope.type;
        // console.log(user)
        $http.post(urlPrefix, user).success(function(response){
            // console.log(response);
            localStorage.setItem('estagio-direito-iduser', response.iduser);
            localStorage.setItem('estagio-direito-username', response.name);
            localStorage.setItem('estagio-direito-usertype', response.type);
            localStorage.setItem('estagio-direito-email', response.email);
            $location.path('/searchInternship')
        })
    }

	
}]);