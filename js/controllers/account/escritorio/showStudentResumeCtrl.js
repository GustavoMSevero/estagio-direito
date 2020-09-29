app.controller("showStudentResumeCtrl", ['$scope', '$http', '$location', '$routeParams', function ($scope, $http, $location, $routeParams) {

	$scope.name = localStorage.getItem('estagio-direito-username');
    $scope.iduser = localStorage.getItem('estagio-direito-iduser');
	$scope.usertype = localStorage.getItem('estagio-direito-usertype');
    $scope.email = localStorage.getItem('estagio-direito-email');
    
    $scope.idstudent = $routeParams.idstudent;
    // console.log('idstudent '+$scope.idstudent)
	
	if(location.hostname == 'localhost'){
		var urlPrefix = 'http://localhost:8888/Projects/Web/estagio-direito/api/studentVacancy.php.php';
		var urlOptionPrefix = 'http://localhost:8888/Projects/Web/estagio-direito/api/studentVacancy.php?option=';
	} else {
		var urlPrefix = 'api/studentVacancy.php.php';
		var urlOptionPrefix = 'api/studentVacancy.php?option=';
		console.log('externo')
	}

	console.log($scope.usertype)
    if($scope.usertype == 'Student'){
        $scope.student = 1;
    } else if($scope.usertype == 'Office'){
        $scope.office = 1;
    } else {
        $scope.college = 1;
	}
    
    var studentResumeData = function() {
        var option = 'student resume data';
        $http.get(urlOptionPrefix + option + '&idstudent=' + $scope.idstudent).success(function(response) {
            // console.log(response)
            $scope.resumeData = response;
        })

    }
    studentResumeData();

    var getStudentCourses = function() {
        var option = 'get student courses';
        $http.get(urlOptionPrefix + option + '&idstudent=' + $scope.idstudent).success(function(coursesResponse) {
            // console.log(coursesResponse)
            $scope.studentCourses = coursesResponse;
        })
    }
    getStudentCourses();

    var getTiKnowledge = function() {
        var option = 'get stundet softwares knowledge';
        $http.get(urlOptionPrefix + option + '&idstudent=' + $scope.idstudent).success(function(softwareResponse) {
            // console.log(softwareResponse)
            $scope.softwares = softwareResponse;
        })

    }
    getTiKnowledge();
	
}]);