app.controller("otherDataCtrl", ['$scope', '$http', '$location', '$rootScope', function ($scope, $http, $location, $rootScope, viaCep) {

	$scope.name = localStorage.getItem('estagio-direito-username');
    $scope.iduser = localStorage.getItem('estagio-direito-iduser');
	$scope.usertype = localStorage.getItem('estagio-direito-usertype');
	$scope.email = localStorage.getItem('estagio-direito-email');

    if(location.hostname == 'localhost'){
		console.log('localhost')
		var urlPrefix = 'http://localhost:8888/Projects/Web/estagio-direito/api/register.php';
		var urlPrefixOption = 'http://localhost:8888/Projects/Web/estagio-direito/api/register.php?option=';
	} else {
		var urlPrefix = 'api/register.php';
		console.log('externo')
    }

    var getOtherData = function(){
        var option = 'get other data student to change'
        $http.get(urlPrefixOption + option + '&iduser=' + $scope.iduser).success(function(data){
            // console.log(data)
            $scope.user = data;
        })
    }
    getOtherData();

    $scope.updateData = function(user){
        user.option = 'update other data student to change';
        user.iduser = $scope.iduser
        // console.log(user)
        $http.put(urlPrefix, user).success(function(response){
            console.log(response)
            $scope.msg = response.msg;
        })
    }
	
}]);