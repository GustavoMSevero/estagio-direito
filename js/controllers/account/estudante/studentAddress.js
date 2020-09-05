app.controller("studentAddressCtrl", ['$scope', '$http', '$location', '$rootScope', function ($scope, $http, $location, $rootScope, viaCep) {

	$scope.name = localStorage.getItem('estagio-direito-username');
    $scope.iduser = localStorage.getItem('estagio-direito-iduser');
	$scope.usertype = localStorage.getItem('estagio-direito-usertype');
	$scope.email = localStorage.getItem('estagio-direito-email');

    if(location.hostname == 'localhost'){
		console.log('localhost')
		var urlPrefix = 'http://localhost:8888/Dev/Web/estagio-direito-v1-v2/api/student.php';
		var urlPrefixOption = 'http://localhost:8888/Dev/Web/estagio-direito-v1-v2/api/student.php?option=';
	} else {
		var urlPrefix = 'api/register.php';
		console.log('externo')
    }

    $scope.getZipcode = function(studentAddress){
        // console.log(studentAddress.cep)
        let cep = studentAddress.cep;
        $http.get('http://viacep.com.br/ws/'+cep+'/json/').then(function(response){
            // console.log(response.data)
            $scope.studentAddress.logradouro = response.data.logradouro;
            $scope.studentAddress.bairro = response.data.bairro;
            $scope.studentAddress.localidade = response.data.localidade;
            $scope.studentAddress.uf = response.data.uf;
        })
    };
    
    $scope.saveStudentAddress = function(studentAddress) {
        studentAddress.option = 'save student address';
        studentAddress.iduser = $scope.iduser;
        // console.log(studentAddress)
        $http.post(urlPrefix, studentAddress).success(function(data) {
            // console.log(data)
            alert(data.msg);
            getStudentAddress();
        })
    }

    var getStudentAddress = function() {
        var option = 'get student address';
        $http.get(urlPrefixOption + option + '&iduser=' + $scope.iduser).success(function(response) {
            // console.log(response)
            $scope.studentAddress = response;
        })
    }
    getStudentAddress();
	
}]);