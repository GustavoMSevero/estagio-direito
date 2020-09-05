app.controller("cadastrarBannersCtrl", ['$scope', '$http', '$location', '$rootScope', function ($scope, $http, $location, $rootScope, viaCep) {

	$scope.name = localStorage.getItem('estagio_direito_user_name');
	$scope.iduser = localStorage.getItem('estagio_direito_iduser');
    $scope.type = localStorage.getItem('estagio_direito_user_type');
    //console.log(`iduser $scope.iduser`)

	if(location.hostname == 'localhost'){
		console.log('localhost')
        var urlPrefix = 'http://localhost:8888/sistemas/Webapps/Projetos/estagio-direito/api/uploadCollegeBanner.php';
        var urlOptionPrefix = 'http://localhost:8888/sistemas/Webapps/Projetos/estagio-direito/api/college.php?option=';
		var uploadFileUrlPrefix = 'http://localhost:8888/sistemas/Webapps/Projetos/estagio-direito/api/uploadCollegeBanner.php?iduser=';
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
                // if(response.status == 1){
                //     showBanner();
                // }
				// var res = JSON.parse(response)
				// $scope.msg = res.msg;
				// alert(res.msg)
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