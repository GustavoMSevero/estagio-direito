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
    case 'get student data':
        
        $iduser = $_GET['iduser'];

        $fulldate = date('Y-m-d');
        $fulldateP = explode('-', $fulldate);

        $currentYear = $fulldateP[0];
        $currentMonth = $fulldateP[1];
        $currentDay = $fulldateP[2];
        
        $getStudentData=$pdo->prepare("SELECT * from student WHERE iduser=:iduser");
        $getStudentData->bindValue(":iduser", $iduser);
        $getStudentData->execute();

        while ($linha=$getStudentData->fetch(PDO::FETCH_ASSOC)) {
            $universityName = $linha['universityName'];
            $semester = $linha['semester'];
            $startYear = $linha['startYear'];
            $conclusionYear = $linha['conclusionYear'];
            // $OABNumberCard = $linha['OABNumberCard'];

            $return = array(
                'universityName' => $universityName,
                'startYear' => $startYear,
                'semester' => $semester,
                'conclusionYear' => $conclusionYear,
                // 'OABNumberCard' => $OABNumberCard
            );
        }

        echo json_encode($return);

        break;

    case 'update student data':
        //print_r($data);
        $age = $data->age;
        $sex = $data->sex;
        $universityName = $data->universityName;
        $startYear = $data->startYear;
        $conclusionYear = $data->conclusionYear;
        // $OABNumberCard = $data->OABNumberCard;
        $iduser = $data->iduser;

        try {

            $getStudentData=$pdo->prepare("UPDATE student SET age=:age, sex=:sex, universityName=:universityName, startYear=:startYear,
                                        conclusionYear=:conclusionYear 
                                        WHERE iduser=:iduser");
            $getStudentData->bindValue(":age", $age);
            $getStudentData->bindValue(":sex", $sex);
            $getStudentData->bindValue(":universityName", $universityName);
            $getStudentData->bindValue(":startYear", $startYear);
            $getStudentData->bindValue(":conclusionYear", $conclusionYear);
            // $getStudentData->bindValue(":OABNumberCard", $OABNumberCard);
            $getStudentData->bindValue(":iduser", $iduser);
            $getStudentData->execute();

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        break;

    case 'update student college data':
        // print_r($data);
        $universityName=$data->universityName;
        $startYear=$data->startYear;
        $semester=$data->semester;
        $conclusionYear=$data->conclusionYear;
        $OABNumberCard=$data->OABNumberCard;
        $iduser=$data->iduser;


        try {

            $updateStudentCollegeData=$pdo->prepare("UPDATE student SET universityName=:universityName, startYear=:startYear,
                                                    conclusionYear=:conclusionYear, OABNumberCard=:OABNumberCard, semester=:semester
                                                    WHERE iduser=:iduser");
            $updateStudentCollegeData->bindValue(":universityName", $universityName);
            $updateStudentCollegeData->bindValue(":semester", $semester);
            $updateStudentCollegeData->bindValue(":startYear", $startYear);
            $updateStudentCollegeData->bindValue(":conclusionYear", $conclusionYear);
            $updateStudentCollegeData->bindValue(":OABNumberCard", $OABNumberCard);
            $updateStudentCollegeData->bindValue(":iduser", $iduser);
            $updateStudentCollegeData->execute();

            $status = 1;
            $msg = 'Dados atualizados com sucesso.';

            $return = array(
                'status' => $status,
                'msg' => $msg
            );

            echo json_encode($return);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        break;

    case 'show resume':

        $iduser = $_GET['iduser'];

        try {

            $getStudentResume=$pdo->prepare("SELECT * from resume WHERE iduser=:iduser");
            $getStudentResume->bindValue(":iduser", $iduser);
            $getStudentResume->execute();

            while ($linha=$getStudentResume->fetch(PDO::FETCH_ASSOC)) {
                $idresume = $linha['idresume'];
                $resumeName = $linha['resumeName'];
                $extension = $linha['extension'];
                $local = $linha['local'];

                $resumeView = 'api/uploadCurriculo/'.$resumeName;

                $return = array(
                    'idresume' => $idresume,
                    'resumeName' => $resumeName,
                    'extension' => $extension,
                    'local' => $local,
                    'resumeView' => $resumeView
                );
            }

            echo json_encode($return);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        break;

    case 'get info student':

        $idstudent = $_GET['idstudent'];

        try {

            $getInfoStudent=$pdo->prepare("SELECT user.*, student.*, resume.* FROM user, student, resume 
                                        WHERE user.iduser=:idstudent 
                                        AND student.iduser=:idstudent 
                                        AND resume.iduser=:idstudent");
            $getInfoStudent->bindValue(":idstudent", $idstudent);
            $getInfoStudent->execute();

            while ($linha=$getInfoStudent->fetch(PDO::FETCH_ASSOC)) {
                $name = $linha['name'];
                $sex = $linha['sex'];
                $age = $linha['age'];
                $email = $linha['email'];
                $universityName = $linha['universityName'];
                $startYear = $linha['startYear'];
                $conclusionYear = $linha['conclusionYear'];
                $OABNumberCard = $linha['OABNumberCard'];
                $resumeName = $linha['resumeName'];

                if($sex == "M"){
                    $sex = "Masculino";
                } else {
                    $sex = "Feminino";
                }

                $resumeView = 'api/uploadCurriculo/'.$resumeName;

                $return = array(
                    'name' => $name,
                    'age' => $age,
                    'sex' => $sex,
                    'email' => $email,
                    'universityName' => $universityName,
                    'startYear' => $startYear,
                    'conclusionYear' => $conclusionYear,
                    'OABNumberCard' => $OABNumberCard,
                    'resumeName' => $resumeName,
                    'resumeView' => $resumeView
                );
            }

            echo json_encode($return);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        break;

    case 'get student resume data':

        $idstudent = $_GET['idstudent'];

        try {

            $getStudentResumeData=$pdo->prepare("SELECT user.*, student.*, studentAddress.*, resume.* , resumeData.* 
                                        FROM user, student, resume, studentAddress, resumeData
                                        WHERE user.iduser=:idstudent 
                                        AND student.iduser=:idstudent 
                                        AND resume.iduser=:idstudent");
            $getStudentResumeData->bindValue(":idstudent", $idstudent);
            $getStudentResumeData->execute();

            while ($linha=$getStudentResumeData->fetch(PDO::FETCH_ASSOC)) {
                $name = $linha['name'];
                $sex = $linha['sex'];
                $age = $linha['age'];
                $dateBirthday = $linha['dateBirthday'];
                $universityName = $linha['universityName'];
                $startYear = $linha['startYear'];
                $conclusionYear = $linha['conclusionYear'];
                $OABCard = $linha['OABCard'];
                $resumeName = $linha['resumeName'];
                $logradouro = $linha['logradouro'];
                $englishLevel = $linha['englishLevel'];
                $spanishLevel = $linha['spanishLevel'];
                $maritalStatus = $linha['maritalStatus'];
                $intendedSalary = $linha['intendedSalary'];
                $goal = $linha['goal'];
                $bairro = $linha['bairro'];
                $localidade = $linha['localidade'];
                $uf = $linha['uf'];
                $phone = $linha['phone'];
                $mobilephone = $linha['mobilephone'];

                if($sex == "M"){
                    $sex = "Masculino";
                } else {
                    $sex = "Feminino";
                }

                $dateBirthdayP = explode('-', $dateBirthday);
                $dateBirthday = $dateBirthdayP[2].'/'.$dateBirthdayP[1].'/'.$dateBirthdayP[0];

                $return = array(
                    'name' => $name,
                    'age' => $age,
                    'dateBirthday' => $dateBirthday,
                    'sex' => $sex,
                    'universityName' => $universityName,
                    'startYear' => $startYear,
                    'conclusionYear' => $conclusionYear,
                    'OABCard' => $OABCard,
                    'logradouro' => $logradouro,
                    'englishLevel' => $englishLevel,
                    'spanishLevel' => $spanishLevel,
                    'maritalStatus' => $maritalStatus,
                    'intendedSalary' => $intendedSalary,
                    'goal' => $goal,
                    'bairro' => $bairro,
                    'localidade' => $localidade,
                    'uf' => $uf,
                    'phone' => $phone,
                    'mobilephone' => $mobilephone
                );
            }
            
            echo json_encode($return);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        break;

    case 'get other data student':

        $iduser = $_GET['iduser'];

        try {

            $getInfoStudent=$pdo->prepare("SELECT age, sex FROM student WHERE iduser=:iduser");
            $getInfoStudent->bindValue(":iduser", $iduser);
            $getInfoStudent->execute();

            while ($linha=$getInfoStudent->fetch(PDO::FETCH_ASSOC)) {

                $sex = $linha['sex'];
                $age = $linha['age'];

                // if ($sex == "M") {
                //     $sex = "Masculino";
                // } else {
                //     $sex = "Feminino";
                // }

                $ageP = explode('-', $age);
                $age = $ageP[2].'/'.$ageP[1].'/'.$ageP[0];

                $return = array(
                    'age' => $age,
                    'sex' => $sex
                );
            }

            echo json_encode($return);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        break;

    case 'update age and sex':
        //print_r($data);
        $age = $data->age;
        $sex = $data->sex;
        $iduser = $data->iduser;

        $ageP = explode('/', $age);
        $age = $ageP[2].'-'.$ageP[1].'-'.$ageP[0];

        try {

            $getInfoStudent=$pdo->prepare("UPDATE student SET age=:age, sex=:sex WHERE iduser=:iduser");
            $getInfoStudent->bindValue(":age", $age);
            $getInfoStudent->bindValue(":sex", $sex);
            $getInfoStudent->bindValue(":iduser", $iduser);
            $getInfoStudent->execute();

            $status = 1;

            $return = array(
                'status' => $status
            );

            echo json_encode($return);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        break;

    case 'save student address':
        // print_r($data);
        $cep = $data->cep;
        $logradouro = $data->logradouro;
        $bairro = $data->bairro;
        $localidade = $data->localidade;
        $uf = $data->uf;
        $iduser = $data->iduser;

        try {

            $saveStudentAddress=$pdo->prepare("INSERT INTO studentAddress (idstudentAddress, iduser, cep, logradouro, bairro, localidade, uf) VALUES (?,?,?,?,?,?,?)");
            $saveStudentAddress->bindValue(1, NULL);
            $saveStudentAddress->bindValue(2, $iduser);
            $saveStudentAddress->bindValue(3, $cep);
            $saveStudentAddress->bindValue(4, $logradouro);
            $saveStudentAddress->bindValue(5, $bairro);
            $saveStudentAddress->bindValue(6, $localidade);
            $saveStudentAddress->bindValue(7, $uf);
            $saveStudentAddress->execute();

            $status = 1;
            $msg = 'Cadastro/atualização feita com sucesso.';

            $return = array(
                'status' => $status,
                'msg' => $msg
            );

            echo json_encode($return);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        break;

    case 'get student address':

        $iduser = $_GET['iduser'];
        // echo 'iduser '.$iduser;

        try {

            $getStudentAddress=$pdo->prepare("SELECT * FROM studentAddress WHERE iduser=:iduser");
            $getStudentAddress->bindValue(':iduser', $iduser);
            $getStudentAddress->execute();

            while ($linha=$getStudentAddress->fetch(PDO::FETCH_ASSOC)) {

                $cep = $linha['cep'];
                $logradouro = $linha['logradouro'];
                $bairro = $linha['bairro'];
                $localidade = $linha['localidade'];
                $uf = $linha['uf'];

                $return = array(
                    'cep' => $cep,
                    'logradouro' => $logradouro,
                    'bairro' => $bairro,
                    'localidade' => $localidade,
                    'uf' => $uf
                );
            }

            echo json_encode($return);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        break;

    case 'save resume student data':

        // print_r($data);
        $name = $data->name;
        $age = $data->age;
        $dateBirthday = $data->dateBirthday;
        $sex = $data->sex;
        $email = $data->email;
        $universityName = $data->universityName;
        $startYear = $data->startYear;
        $conclusionYear = $data->conclusionYear;
        $logradouro = $data->logradouro;
        $phone = $data->phone;
        $mobilephone = $data->mobilephone;
        $OABCard = $data->OABCard;
        $bairro = $data->bairro;
        $localidade = $data->localidade;
        $uf = $data->uf;
        $englishLevel = $data->englishLevel;
        $spanishLevel = $data->spanishLevel;
        $goal = $data->goal;
        $maritalStatus = $data->maritalStatus;
        $iduser = $data->iduser;
        $intendedSalary = $data->intendedSalary;

        $dateBirthdayP = explode('/', $dateBirthday);
        $dateBirthday = $dateBirthdayP[2].'-'.$dateBirthdayP[1].'-'.$dateBirthdayP[0];

        try {

            //Pegar idresume da tabela resumeData para verificar se já existe
            $getIdResumeData=$pdo->prepare("SELECT idresume FROM resumeData WHERE iduser=:iduser");
            $getIdResumeData->bindValue(":iduser", $iduser);
            $getIdResumeData->execute();

            $exist = $getIdResumeData->rowCount();

            while ($linhaIdResume=$getIdResumeData->fetch(PDO::FETCH_ASSOC)) {
                $idresume = $linhaIdResume['idresume'];
            }
            
            
            if ($exist == 1) {
                //echo 'Atualizar';
                $updateStudentDataResume=$pdo->prepare("UPDATE resumeData SET OABCard=:OABCard, city=:localidade, maritalStatus=:maritalStatus, 
                                                        englishLevel=:englishLevel, spanishLevel=:spanishLevel,
                                                        goal=:goal, studentName=:name, sex=:sex, university=:university, startYear=:startYear,
                                                        conclusionYear=:conclusionYear, age=:age, dateBirthday=:dateBirthday, neighborhood=:bairro,
                                                        state=:uf, street=:logradouro, phone=:phone, mobilephone=:mobilephone, email=:email
                                                        WHERE idresume=:idresume 
                                                        AND iduser=:iduser");
                $updateStudentDataResume->bindValue(':name', $name);
                $updateStudentDataResume->bindValue(':sex', $sex);
                $updateStudentDataResume->bindValue(':university', $universityName);
                $updateStudentDataResume->bindValue(':startYear', $startYear);
                $updateStudentDataResume->bindValue(':conclusionYear', $conclusionYear);
                $updateStudentDataResume->bindValue(':age', $age);
                $updateStudentDataResume->bindValue(':dateBirthday', $dateBirthday);
                $updateStudentDataResume->bindValue(':bairro', $bairro);
                $updateStudentDataResume->bindValue(':uf', $uf);
                $updateStudentDataResume->bindValue(':logradouro', $logradouro);
                $updateStudentDataResume->bindValue(':phone', $phone);
                $updateStudentDataResume->bindValue(':mobilephone', $mobilephone);
                $updateStudentDataResume->bindValue(':email', $email);
                $updateStudentDataResume->bindValue(':OABCard', $OABCard);
                $updateStudentDataResume->bindValue(':localidade', $localidade);
                $updateStudentDataResume->bindValue(':maritalStatus', $maritalStatus);
                $updateStudentDataResume->bindValue(':englishLevel', $englishLevel);
                $updateStudentDataResume->bindValue(':spanishLevel', $spanishLevel);
                $updateStudentDataResume->bindValue(':goal', $goal);
                $updateStudentDataResume->bindValue(':iduser', $iduser);
                $updateStudentDataResume->bindValue(':idresume', $idresume);
                $updateStudentDataResume->execute();
        

                $status = 'Atulizado';
                $msg = 'Dados atualizados com sucesso.';

                $return = array(
                    'status' => $status,
                    'msg' => $msg
                );

                echo json_encode($return);

            } else {
        //         // echo 'Salvar';
                $saveStudentDataResume=$pdo->prepare("INSERT INTO resumeData (idresume, iduser, studentName, sex, university, startYear,
                                                conclusionYear, age, dateBirthday, OABCard, city, neighborhood, state, street, phone, 
                                                mobilephone, email, maritalStatus, englishLevel, spanishLevel, goal) 
                                                VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $saveStudentDataResume->bindValue(1, NULL);
                $saveStudentDataResume->bindValue(2, $iduser);
                $saveStudentDataResume->bindValue(3, $name);
                $saveStudentDataResume->bindValue(4, $sex);
                $saveStudentDataResume->bindValue(5, $universityName);
                $saveStudentDataResume->bindValue(6, $startYear);
                $saveStudentDataResume->bindValue(7, $conclusionYear);
                $saveStudentDataResume->bindValue(8, $age);
                $saveStudentDataResume->bindValue(9, $dateBirthday);
                $saveStudentDataResume->bindValue(10, $OABCard);
                $saveStudentDataResume->bindValue(11, $localidade);
                $saveStudentDataResume->bindValue(12, $bairro);
                $saveStudentDataResume->bindValue(13, $uf);
                $saveStudentDataResume->bindValue(14, $logradouro);
                $saveStudentDataResume->bindValue(15, $phone);
                $saveStudentDataResume->bindValue(16, $mobilephone);
                $saveStudentDataResume->bindValue(17, $email);
                $saveStudentDataResume->bindValue(18, $maritalStatus);
                $saveStudentDataResume->bindValue(19, $englishLevel);
                $saveStudentDataResume->bindValue(20, $spanishLevel);
                $saveStudentDataResume->bindValue(22, $goal);
                $saveStudentDataResume->execute();

                $status = 'Salvo';
                $msg = 'Dados salvos com sucesso.';

                $return = array(
                    'status' => $status,
                    'msg' => $msg
                );

                echo json_encode($return);
            }

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        break;
    
    default:
        # code...
        break;
}




?>