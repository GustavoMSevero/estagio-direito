app.controller("knowledgeTiCtrl", ['$scope', '$http', '$location', '$rootScope', function ($scope, $http, $location, $rootScope, viaCep) {

	$scope.name = localStorage.getItem('estagio-direito-username');
    $scope.iduser = localStorage.getItem('estagio-direito-iduser');
	$scope.usertype = localStorage.getItem('estagio-direito-usertype');
	$scope.email = localStorage.getItem('estagio-direito-email');

    if(location.hostname == 'localhost'){
		console.log('localhost')
		var urlPrefix = 'http://localhost:8888/Projects/Web/estagio-direito/api/studentSoftwares.php';
		var urlPrefixOption = 'http://localhost:8888/Projects/Web/estagio-direito/api/studentSoftwares.php?option=';
	} else {
		var urlPrefix = 'api/register.php';
		console.log('externo')
    }

    $scope.addSoftware = function(software) {
        software.option = 'save softwares';
        software.iduser = $scope.iduser;

        $http.post(urlPrefix, software).success(function(data) {
            $scope.msg = data.msg;
            getSoftwares();
        })
    }
    
    var getSoftwares = function() {
        var option = 'get softwares';
        $http.get(urlPrefixOption + option + '&iduser=' + $scope.iduser).success(function(response) {
            // console.log(response)
            $scope.listOfSoftwares = response;
        })
    }
    getSoftwares();
}]);