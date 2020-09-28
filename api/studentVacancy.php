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
    case 'get student by vacancy interested':

        $idvacancy = $_GET['idvacancy'];
        // echo $idoffice;
        try {
            $getStudentVacancyInfo=$pdo->prepare("SELECT * FROM studentsVacancies WHERE idvacancy=:idvacancy");
            $getStudentVacancyInfo->bindValue(':idvacancy', $idvacancy);
            $getStudentVacancyInfo->execute();

            while ($linha=$getStudentVacancyInfo->fetch(PDO::FETCH_ASSOC)) {
                $idstudentVacancy = $linha['idstudentVacancy'];
                $idstudent = $linha['idstudent'];
                $idvacancy = $linha['idvacancy'];

                $getStudentInfo=$pdo->prepare("SELECT student.iduser, student.name, student.universityName, student.semester, 
                                                studentAddress.iduser, studentAddress.logradouro, studentAddress.bairro
                                                FROM student JOIN studentAddress WHERE student.iduser=:idstudent");
                $getStudentInfo->bindValue(':idstudent', $idstudent);
                $getStudentInfo->execute();

                $exists = $getStudentInfo->rowCount();

                if ($exists == 1) {

                    while ($linha=$getStudentInfo->fetch(PDO::FETCH_ASSOC)) {
                        $iduser = $linha['iduser'];
                        $name = $linha['name'];
                        $universityName = $linha['universityName'];
                        $semester = $linha['semester'];
                        $logradouro = $linha['logradouro'];
                        $bairro = $linha['bairro'];

                        $nameP = explode(' ', $name);
                        $name = $nameP[0];

                        $return[] = array(
                            'idstudent' => $iduser,
                            'name' => $name,
                            'universityName' => $universityName,
                            'semester' => $semester,
                            'logradouro' => $logradouro,
                            'bairro' => $bairro
                        );
                    }

                    echo json_encode($return);
                    
                } else {
                    
                    $status = 0;

                    $return = array(
                        'status' => $status
                    );

                    echo json_encode($return);
                }

            }

            // echo json_encode($return);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        
        break;

    case 'student resume data':

        $idstudent = $_GET['idstudent'];

        try {
            
            $getStudentResumeData=$pdo->prepare("SELECT * FROM resumeData WHERE iduser=:iduser");
            $getStudentResumeData->bindValue(':iduser', $idstudent);
            $getStudentResumeData->execute();

            while ($linha=$getStudentResumeData->fetch(PDO::FETCH_ASSOC)) {
                $studentName = $linha['studentName'];
                $sex = $linha['sex'];
                $university = $linha['university'];
                $startYear = $linha['startYear'];
                $conclusionYear = $linha['conclusionYear'];
                $age = $linha['age'];
                $OABCard = $linha['OABCard'];
                $dateBirthday = $linha['dateBirthday'];
                $city = $linha['city'];
                $neighborhood = $linha['neighborhood'];
                $state = $linha['state'];
                $street = $linha['street'];
                $phone = $linha['phone'];
                $mobilephone = $linha['mobilephone'];
                $email = $linha['email'];
                $maritalStatus = $linha['maritalStatus'];
                $englishLevel = $linha['englishLevel'];
                $spanishLevel = $linha['spanishLevel'];
                $intendedSalary = $linha['intendedSalary'];
                $goal = $linha['goal'];

                $dateBirthdayP = explode('-', $dateBirthday);
                $dateBirthday = $dateBirthdayP[2].'/'.$dateBirthdayP[1].'/'.$dateBirthdayP[0];
            }

            $return = array(
                'studentName' => $studentName,
                'sex' => $sex,
                'university' => $university,
                'startYear' => $startYear,
                'conclusionYear' => $conclusionYear,
                'age' => $age,
                'OABCard' => $OABCard,
                'dateBirthday' => $dateBirthday,
                'city' => $city,
                'neighborhood' => $neighborhood,
                'state' => $state,
                'street' => $street,
                'phone' => $phone,
                'mobilephone' => $mobilephone,
                'email' => $email,
                'maritalStatus' => $maritalStatus,
                'englishLevel' => $englishLevel,
                'spanishLevel' => $spanishLevel,
                'intendedSalary' => $intendedSalary,
                'goal' => $goal
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