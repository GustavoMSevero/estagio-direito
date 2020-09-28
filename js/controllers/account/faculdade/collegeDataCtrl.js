app.controller("collegeDataCtrl", ['$scope', '$http', '$location', '$rootScope', function ($scope, $http, $location, $rootScope, viaCep) {

	$scope.name = localStorage.getItem('estagio-direito-username');
    $scope.iduser = localStorage.getItem('estagio-direito-iduser');
	$scope.usertype = localStorage.getItem('estagio-direito-usertype');
	$scope.email = localStorage.getItem('estagio-direito-email');
    //console.log(`iduser $scope.iduser`)

	if(location.hostname == 'localhost'){
		console.log('localhost')
		var urlPrefix = 'http://localhost:8888/Projects/Web/estagio-direito/api/college.php';
		var urlOptionPrefix = 'http://localhost:8888/Projects/Web/estagio-direito/api/college.php?option=';
	} else {
		var urlPrefix = 'api/college.php';
		var urlOptionPrefix = 'api/college.php?option=';
		console.log('externo')
    }

    var getCollegeData = function(){
        var option = 'get college data';
        $http.get(urlOptionPrefix + option + '&iduser=' + $scope.iduser).success(function(response){
            // console.log(response)
            $scope.newCollegeData = response;
        })

    }
    getCollegeData();

    $scope.updateCollegeData = function(newCollegeData){
        newCollegeData.option = 'update college data';
        newCollegeData.iduser = $scope.iduser;

        $http.put(urlPrefix, newCollegeData).success(function(response){

            if (response.status == 1) {
                $scope.msg = response.msg;
            }
        })
    }
	

	
}]);