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
            $startYear = $linha['startYear'];
            $conclusionYear = $linha['conclusionYear'];
            $OABNumberCard = $linha['OABNumberCard'];

            $return = array(
                'universityName' => $universityName,
                'startYear' => $startYear,
                'conclusionYear' => $conclusionYear,
                'OABNumberCard' => $OABNumberCard
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
        $OABNumberCard = $data->OABNumberCard;
        $iduser = $data->iduser;

        try {

            $getStudentData=$pdo->prepare("UPDATE student SET age=:age, sex=:sex, universityName=:universityName, startYear=:startYear,
                                        conclusionYear=:conclusionYear, OABNumberCard=:OABNumberCard 
                                        WHERE iduser=:iduser");
            $getStudentData->bindValue(":age", $age);
            $getStudentData->bindValue(":sex", $sex);
            $getStudentData->bindValue(":universityName", $universityName);
            $getStudentData->bindValue(":startYear", $startYear);
            $getStudentData->bindValue(":conclusionYear", $conclusionYear);
            $getStudentData->bindValue(":OABNumberCard", $OABNumberCard);
            $getStudentData->bindValue(":iduser", $iduser);
            $getStudentData->execute();

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

    case 'get other data student':

        $iduser = $_GET['iduser'];

        try {

            $getInfoStudent=$pdo->prepare("SELECT age, sex FROM student WHERE iduser=:iduser");
            $getInfoStudent->bindValue(":iduser", $iduser);
            $getInfoStudent->execute();

            while ($linha=$getInfoStudent->fetch(PDO::FETCH_ASSOC)) {

                $sex = $linha['sex'];
                $age = $linha['age'];

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
    
    default:
        # code...
        break;
}




?>