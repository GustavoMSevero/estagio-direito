<?php
header("Access-Control-Allow-Origin: *");
ini_set('display_errors', true);
error_reporting(E_ALL);

include_once("con.php");

$pdo = conectar();

$data = file_get_contents("php://input");
$data = json_decode($data);

if($data){
	$option = $data->option;
}else{
	$option = $_GET['option'];
}


switch ($option) {
    case 'save course':

        $courseName=$data->courseName;
        $schoolInstitution=$data->schoolInstitution;
        $city=$data->city;
        $state=$data->state;
        $workload=$data->workload;
        $typeOfCourse=$data->typeOfCourse;
        $mouthYearConclusion=$data->mouthYearConclusion;
        $iduser=$data->iduser;

        try {
            $saveCourse=$pdo->prepare("INSERT INTO studentCourse (idcourse, iduser, courseName, school_Institution, city, state, workload, 
                                        typeOfCourse, monthYearConclusion) VALUES(?,?,?,?,?,?,?,?,?)");
            $saveCourse->bindValue(1, NULL);
            $saveCourse->bindValue(2, $iduser);
            $saveCourse->bindValue(3, $courseName);
            $saveCourse->bindValue(4, $schoolInstitution);
            $saveCourse->bindValue(5, $city);
            $saveCourse->bindValue(6, $state);
            $saveCourse->bindValue(7, $workload);
            $saveCourse->bindValue(8, $typeOfCourse);
            $saveCourse->bindValue(9, $mouthYearConclusion);
            $saveCourse->execute();

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        break;

    case 'get all courses':
        
        $iduser = $_GET['iduser'];

        try {

            $getAllCourses=$pdo->prepare("SELECT * FROM studentCourse WHERE iduser=:iduser");
            $getAllCourses->bindValue(":iduser", $iduser);
            $getAllCourses->execute();

            while ($linha=$getAllCourses->fetch(PDO::FETCH_ASSOC)) {
                $idcourse = $linha['idcourse'];
                $courseName = $linha['courseName'];
                $school_Institution = $linha['school_Institution'];
                $city = $linha['city'];
                $state = $linha['state'];
                $workload = $linha['workload'];
                $typeOfCourse = $linha['typeOfCourse'];
                $monthYearConclusion = $linha['monthYearConclusion'];
            }

            $return[] = array(
                'idcourse' => $idcourse,
                'courseName' => $courseName,
                'school_Institution' => $school_Institution,
                'city' => $city,
                'state' => $state,
                'workload' => $workload,
                'typeOfCourse' => $typeOfCourse,
                'monthYearConclusion' => $monthYearConclusion
            );

            echo json_encode($return);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        break;

    case 'get student course':
    
        $idcourse = $_GET['idcourse'];

        try {

            $getStudentCourse=$pdo->prepare("SELECT * FROM studentCourse WHERE idcourse=:idcourse");
            $getStudentCourse->bindValue(":idcourse", $idcourse);
            $getStudentCourse->execute();

            while ($linha=$getStudentCourse->fetch(PDO::FETCH_ASSOC)) {
                $courseName = $linha['courseName'];
                $school_Institution = $linha['school_Institution'];
                $city = $linha['city'];
                $state = $linha['state'];
                $workload = $linha['workload'];
                $typeOfCourse = $linha['typeOfCourse'];
                $monthYearConclusion = $linha['monthYearConclusion'];
            }

            $return = array(
                'courseName' => $courseName,
                'school_Institution' => $school_Institution,
                'city' => $city,
                'state' => $state,
                'workload' => $workload,
                'typeOfCourse' => $typeOfCourse,
                'monthYearConclusion' => $monthYearConclusion
            );

            echo json_encode($return);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        break;

    case 'update student course':
        // print_r($data);
        $courseName=$data->courseName;
        $school_Institution=$data->school_Institution;
        $city=$data->city;
        $state=$data->state;
        $workload=$data->workload;
        $typeOfCourse=$data->typeOfCourse;
        $monthYearConclusion=$data->monthYearConclusion;
        $idcourse=$data->idcourse;

        try {

            $updateStudentCourse=$pdo->prepare("UPDATE studentCourse SET courseName=:courseName, school_Institution=:school_Institution, city=:city, state=:state,
                                                workload=:workload, typeOfCourse=:typeOfCourse, monthYearConclusion=:monthYearConclusion
                                                WHERE idcourse=:idcourse");
            $updateStudentCourse->bindValue(":courseName", $courseName);
            $updateStudentCourse->bindValue(":school_Institution", $school_Institution);
            $updateStudentCourse->bindValue(":city", $city);
            $updateStudentCourse->bindValue(":state", $state);
            $updateStudentCourse->bindValue(":workload", $workload);
            $updateStudentCourse->bindValue(":typeOfCourse", $typeOfCourse);
            $updateStudentCourse->bindValue(":monthYearConclusion", $monthYearConclusion);
            $updateStudentCourse->bindValue(":idcourse", $idcourse);
            $updateStudentCourse->execute();

            $status = 1;
            $msg = 'Courso atualizado com sucesso!';

            $return = array(
                'status' => $status,
                'msg' => $msg
            );

            echo json_encode($return);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        break;
    
    default:
        # code...
        break;
}




?>