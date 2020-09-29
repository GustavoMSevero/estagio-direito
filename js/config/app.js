var app = angular.module("estagio_direito", ["ngRoute", "ui.utils.masks"]);

app.config(['$routeProvider', function($routeProvider){

	$routeProvider

	.when("/", {
        templateUrl: "views/initial.html",
    })

    .when("/login", {
        //templateUrl: "views/inicial.html",
        templateUrl: "views/login.html",
    })

    .when("/searchInternship", {
        //templateUrl: "views/inicial.html",
        templateUrl: "views/searchInternship.html",
    })

    .when("/checkVacancy/:idvacancy", {
        templateUrl: "views/checkVacancy.html",
    })

    .when("/account", {
        templateUrl: "views/account/account.html",
    })

    .when("/changePassword", {
        templateUrl: "views/account/changePassword.html",
    })

    .when("/changeEmail", {
        templateUrl: "views/account/changeEmail.html",
    })

    .when("/otherData", {
        templateUrl: "views/account/student/otherData.html",
    })

    .when("/studentCollegeData", {
        templateUrl: "views/account/student/studentCollegeData.html",
    })

    .when("/studentAddress", {
        templateUrl: "views/account/student/studentAddress.html",
    })

    .when("/courses", {
        templateUrl: "views/account/student/courses.html",
    })

    .when("/editCourse/:idcourse", {
        templateUrl: "views/account/student/editCourse.html",
    })

    .when("/knowledgeTi", {
        templateUrl: "views/account/student/knowledgeTi.html",
    })

    .when("/resume", {
        templateUrl: "views/account/student/resume.html",
    })

    .when("/officeData", {
        templateUrl: "views/account/office/officeData.html",
    })

    .when("/advertiseVacancy", {
        templateUrl: "views/account/office/advertiseVacancy.html",
    })

    .when("/editAdvertiseVacancy/:idvacancy", {
        templateUrl: "views/account/office/editAdvertiseVacancy.html",
    })

    .when("/vacancyList", {
        templateUrl: "views/account/office/vacancyList.html",
    })

    .when("/showInterestedStudents/:idvacancy", {
        templateUrl: "views/account/office/showInterestedStudents.html",
    })

    .when("/showStudentResume/:idstudent", {
        templateUrl: "views/account/office/showStudentResume.html",
    })

    .when("/registerBanners", {
        templateUrl: "views/account/office/registerBanners.html",
    })

    .when("/collegeData", {
        templateUrl: "views/account/college/collegeData.html",
    })

    .when("/addBanner", {
        templateUrl: "views/account/college/addBanner.html",
    })



    // .when("/telaLogin", {
    //     templateUrl: "views/telaLogin.html",
    // })

    // .when("/buscarVagas", {
    //     templateUrl: "views/buscarVagas.html",
    // })

    // .when("/verVaga/:idvacancy", {
    //     templateUrl: "views/verVaga.html",
    // })

    // .when("/listaInteressados", {
    //     templateUrl: "views/conta/listaInteressados.html",
    // })

    // .when("/verEstudante/:iduser", {
    //     templateUrl: "views/conta/verEstudante.html",
    // })

    // .when("/demaisDados", {
    //     templateUrl: "views/conta/demaisDados.html",
    // })

    // .when("/dadosFaculdade", {
    //     templateUrl: "views/conta/faculdade/dadosFaculdade.html",
    // })

    // .when("/cadastrarBanners", {
    //     templateUrl: "views/conta/office/cadastrarBanners.html",
    // })


}]);
