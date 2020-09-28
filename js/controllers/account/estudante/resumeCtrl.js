app.controller("resumeCtrl", ['$scope', '$http', '$location', '$rootScope', function ($scope, $http, $location, $rootScope) {

	$scope.name = localStorage.getItem('estagio-direito-username');
    $scope.iduser = localStorage.getItem('estagio-direito-iduser');
	$scope.usertype = localStorage.getItem('estagio-direito-usertype');
	$scope.email = localStorage.getItem('estagio-direito-email');

	if(location.hostname == 'localhost'){
		console.log('localhost')
		var urlPrefix = 'http://localhost:8888/Projects/Web/estagio-direito/api/student.php';
		var urlOptionPrefix = 'http://localhost:8888/Projects/Web/estagio-direito/api/student.php?option=';
		var uploadFileUrlPrefix = 'http://localhost:8888/Projects/Web/estagio-direito/api/uploadCurriculo.php?iduser=';
	} else {
		var urlPrefix = 'api/register.php';
		console.log('externo')
	}
	
	// Firsts data os resume
	var getStudentResumeData = function() {
		var option = 'get student resume data';
		$http.get(urlOptionPrefix + option + '&idstudent=' +$scope.iduser).success(function(data) {
			// console.log(data)
			data.email = $scope.email;
			$scope.studentResumeData = data;
		})
	}
	getStudentResumeData();

	$scope.saveResume = function(resumeStudent) {
		resumeStudent.option = 'save resume student data';
		resumeStudent.iduser = $scope.iduser;
		// console.log(resumeStudent)
		$http.post(urlPrefix, resumeStudent).success(function(data) {
			getStudentResumeData();
			$scope.msg = data.msg;
			
		})
	}


	var formData = new FormData();
	var iduser = $scope.iduser;
	// Attach file

	$scope.uploadPDF = function(){
		$scope.input.click();
	}

	$scope.input = document.createElement("INPUT");
	$scope.input.setAttribute("type", "file");
	$scope.input.addEventListener('change', function(){
		formData.append('file_pdf', $scope.input.files[0]);

		$.ajax({
			url: uploadFileUrlPrefix + iduser,
			data: formData,
			type: 'POST',
			contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
			processData: false
			})
			.then(function(response) {
				console.log(response);
				showResume();
		}, function errorCallback(response) {
			console.log("Error "+response);
		});
	});

	var showResume = function(){
		var option = 'show resume';
		$http.get(urlOptionPrefix + option + '&iduser=' + $scope.iduser).success(function(response){
			// console.log(response)
			$scope.resumeName = response.resumeName;
			$scope.resumeView = response.resumeView;
			$scope.idresume = response.idresume;
		})
	}
	showResume();
	


	
}]);