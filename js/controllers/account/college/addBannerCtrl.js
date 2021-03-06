app.controller("addBannerCtrl", ['$scope', '$http', '$location', '$rootScope', function ($scope, $http, $location, $rootScope, viaCep) {

	$scope.name = localStorage.getItem('estagio-direito-username');
    $scope.iduser = localStorage.getItem('estagio-direito-iduser');
	$scope.usertype = localStorage.getItem('estagio-direito-usertype');
	$scope.email = localStorage.getItem('estagio-direito-email');
    //console.log(`iduser $scope.iduser`)

	if(location.hostname == 'localhost'){
		console.log('localhost')
        var urlPrefix = 'http://localhost:8888/Projects/Web/estagio-direito/api/uploadCollegeBanner.php';
        var urlOptionPrefix = 'http://localhost:8888/Projects/Web/estagio-direito/api/college.php?option=';
		var uploadFileUrlPrefix = 'http://localhost:8888/Projects/Web/estagio-direito/api/uploadCollegeBanner.php?iduser=';
	} else {
        var urlPrefix = 'api/uploadCollegeBanner.php';
        var urlOptionPrefix = 'api/college.php?option=';
		var uploadFileUrlPrefix = 'api/uploadCollegeBanner.php?iduser=';
		console.log('externo')
    }

	var formData = new FormData();
	var iduser = $scope.iduser;
	// Attach file

	$scope.uploadBanner = function(){
		$scope.input.click();
	}

    $scope.input = document.createElement("INPUT");
	$scope.input.setAttribute("type", "file");
	$scope.input.addEventListener('change', function(){
		formData.append('file_jpg', $scope.input.files[0]);

		$.ajax({
			url: uploadFileUrlPrefix + iduser + '&idbanner=' + $scope.idbanner,
			data: formData,
			type: 'POST',
			contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
			processData: false
			})
			.then(function(response) {
                console.log(response);
                showBanner();
  
		}, function errorCallback(response) {
			console.log("Error "+response);
		});
    });
    
    var showBanner = function(){
		var option = 'show banner';
		$http.get(urlOptionPrefix + option + '&iduser=' + $scope.iduser).success(function(response){
			//console.log(response)
			$scope.bannerName = response.bannerName;
			$scope.bannerView = response.bannerView;
			$scope.idbanner = response.idbanner;
		})
	}
	showBanner();
	
}]);