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
    case 'register vacancy':
        //print_r($data);
        $performanceArea = $data->performanceArea;
        $neighborhood = $data->bairro;
        $city = $data->localidade;
        $state = $data->uf;
        $minimumSchooling = $data->minimumSchooling;
        $tiKnowledge = $data->tiKnowledge;
        $secLan = $data->secLan;
        @$secondLanguage = $data->secondLanguage;
        $alreadyInterned = $data->alreadyInterned;
        $internshipWorth = $data->internshipWorth;
        $transportationWorth = $data->transportationWorth;
        $mealWorth = $data->mealWorth;
        $activities = $data->activities;
        $numberOfVacancy = $data->numberOfVacancy;
        $whenStart = $data->whenStart;
        $effectuation = $data->effectuation;
        $observation = $data->observation;
        $iduser = $data->iduser;
        $publishDate = $data->publishDate;

        $whenStartP = explode('/', $whenStart);
        $whenStart = $whenStartP[2].'-'.$whenStartP[1].'-'.$whenStartP[0];

        try {
            
            $registerVacancy=$pdo->prepare("INSERT INTO officeVacancy (idvacancy, iduser, performanceArea, neighborhood, city, state, minimumSchooling,
                                            tiKnowledge, secLan, secondLanguage, alreadyInterned, internshipWorth, transportationWorth, mealWorth, activities,
                                            numberOfVacancy, whenStart, effectuation, observation, publishDate) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $registerVacancy->bindValue(1, NULL);
            $registerVacancy->bindValue(2, $iduser);
            $registerVacancy->bindValue(3, $performanceArea);
            $registerVacancy->bindValue(4, $neighborhood);
            $registerVacancy->bindValue(5, $city);
            $registerVacancy->bindValue(6, $state);
            $registerVacancy->bindValue(7, $minimumSchooling);
            $registerVacancy->bindValue(8, $tiKnowledge);
            $registerVacancy->bindValue(9, $secLan);
            $registerVacancy->bindValue(10, $secondLanguage);
            $registerVacancy->bindValue(11, $alreadyInterned);
            $registerVacancy->bindValue(12, $internshipWorth);
            $registerVacancy->bindValue(13, $transportationWorth);
            $registerVacancy->bindValue(14, $mealWorth);
            $registerVacancy->bindValue(15, $activities);
            $registerVacancy->bindValue(16, $numberOfVacancy);
            $registerVacancy->bindValue(17, $whenStart);
            $registerVacancy->bindValue(18, $effectuation);
            $registerVacancy->bindValue(19, $observation);
            $registerVacancy->bindValue(20, $publishDate);
            $registerVacancy->execute();

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        break;

    case 'update student data':  // O que esse cara faz aqui? Te que ir pra API de estudante
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

    case 'get all vacancys this office':
        
        $iduser = $_GET['iduser'];
        //echo 'iduser '.$iduser;
        try {

            $getAllVacancys=$pdo->prepare("SELECT idvacancy, publishDate, internshipWorth, performanceArea FROM officeVacancy WHERE iduser=:iduser");
            $getAllVacancys->bindValue(":iduser", $iduser);
            $getAllVacancys->execute();

            while ($linha=$getAllVacancys->fetch(PDO::FETCH_ASSOC)) {
                $idvacancy = $linha['idvacancy'];
                $performanceArea = $linha['performanceArea'];
                $publishDate = $linha['publishDate'];
                $internshipWorth = $linha['internshipWorth'];

                $publishDateP = explode('-', $publishDate);
                $publishDate = $publishDateP[2].'/'.$publishDateP[1].'/'.$publishDateP[0];

                $return[] = array(
                    'idvacancy' => $idvacancy,
                    'performanceArea' => $performanceArea,
                    'publishDate' => $publishDate,
                    'internshipWorth' => $internshipWorth,
                );
            }

            echo json_encode($return);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        break;

    case 'get vacancy office':
    
        $idvacancy = $_GET['idvacancy'];
        //echo 'idvacancy '.$idvacancy;
        try {

            $getVacancy=$pdo->prepare("SELECT * FROM officeVacancy WHERE idvacancy=:idvacancy");
            $getVacancy->bindValue(":idvacancy", $idvacancy);
            $getVacancy->execute();

            while ($linha=$getVacancy->fetch(PDO::FETCH_ASSOC)) {

                $performanceArea = $linha['performanceArea'];
                $neighborhood = $linha['neighborhood'];
                $city = $linha['city'];
                $state = $linha['state'];
                $minimumSchooling = $linha['minimumSchooling'];
                $tiKnowledge = $linha['tiKnowledge'];
                $secLan = $linha['secLan'];
                $secondLanguage = $linha['secondLanguage'];
                $alreadyInterned = $linha['alreadyInterned'];
                $internshipWorth = $linha['internshipWorth'];
                $transportationWorth = $linha['transportationWorth'];
                $mealWorth = $linha['mealWorth'];
                $activities = $linha['activities'];
                $numberOfVacancy = $linha['numberOfVacancy'];
                $whenStart = $linha['whenStart'];
                $effectuation = $linha['effectuation'];
                $observation = $linha['observation'];

                $numberOfVacancy = (int)$numberOfVacancy;

                $whenStartP = explode('-', $whenStart);
                $whenStart = $whenStartP[2].'/'.$whenStartP[1].'/'.$whenStartP[0];

                $return = array(
                    'performanceArea' => $performanceArea,
                    'bairro' => $neighborhood,
                    'localidade' => $city,
                    'uf' => $state,
                    'minimumSchooling' => $minimumSchooling,
                    'tiKnowledge' => $tiKnowledge,
                    'secLan' => $secLan,
                    'secondLanguage' => $secondLanguage,
                    'alreadyInterned' => $alreadyInterned,
                    'internshipWorth' => $internshipWorth,
                    'transportationWorth' => $transportationWorth,
                    'mealWorth' => $mealWorth,
                    'activities' => $activities,
                    'numberOfVacancy' => $numberOfVacancy,
                    'whenStart' => $whenStart,
                    'effectuation' => $effectuation,
                    'observation' => $observation
                );
            }

            echo json_encode($return);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        break;

    case 'update vacancy':
        // print_r($data);
        $performanceArea = $data->performanceArea;
        $neighborhood = $data->bairro;
        $city = $data->localidade;
        $state = $data->uf;
        $minimumSchooling = $data->minimumSchooling;
        $tiKnowledge = $data->tiKnowledge;
        $secLan = $data->secLan;
        $secondLanguage = $data->secondLanguage;
        $alreadyInterned = $data->alreadyInterned;
        $internshipWorth = $data->internshipWorth;
        $transportationWorth = $data->transportationWorth;
        $mealWorth = $data->mealWorth;
        $activities = $data->activities;
        $numberOfVacancy = $data->numberOfVacancy;
        $whenStart = $data->whenStart;
        $effectuation = $data->effectuation;
        $observation = $data->observation;
        $idvacancy = $data->idvacancy;

        $whenStartP = explode('/', $whenStart);
        $whenStart = $whenStartP[2].'-'.$whenStartP[1].'-'.$whenStartP[0];

        try {

            $updateVacancy=$pdo->prepare("UPDATE officeVacancy SET performanceArea=:performanceArea, neighborhood=:neighborhood, city=:city,
                                    state=:state, minimumSchooling=:minimumSchooling, tiKnowledge=:tiKnowledge, secLan=:secLan,
                                    secondLanguage=:secondLanguage, alreadyInterned=:alreadyInterned, internshipWorth=:internshipWorth,
                                    transportationWorth=:transportationWorth, mealWorth=:mealWorth, activities=:activities, numberOfVacancy=:numberOfVacancy,
                                    whenStart=:whenStart, effectuation=:effectuation, observation=:observation WHERE idvacancy=:idvacancy");
            $updateVacancy->bindValue(":performanceArea", $performanceArea);
            $updateVacancy->bindValue(":neighborhood", $neighborhood);
            $updateVacancy->bindValue(":city", $city);
            $updateVacancy->bindValue(":state", $state);
            $updateVacancy->bindValue(":minimumSchooling", $minimumSchooling);
            $updateVacancy->bindValue(":tiKnowledge", $tiKnowledge);
            $updateVacancy->bindValue(":secLan", $secLan);
            $updateVacancy->bindValue(":secondLanguage", $secondLanguage);
            $updateVacancy->bindValue(":alreadyInterned", $alreadyInterned);
            $updateVacancy->bindValue(":internshipWorth", $internshipWorth);
            $updateVacancy->bindValue(":transportationWorth", $transportationWorth);
            $updateVacancy->bindValue(":mealWorth", $mealWorth);
            $updateVacancy->bindValue(":activities", $activities);
            $updateVacancy->bindValue(":numberOfVacancy", $numberOfVacancy);
            $updateVacancy->bindValue(":whenStart", $whenStart);
            $updateVacancy->bindValue(":effectuation", $effectuation);
            $updateVacancy->bindValue(":observation", $observation);
            $updateVacancy->bindValue(":idvacancy", $idvacancy);
            $updateVacancy->execute();

            $status = 1;

            $return = array(
                'status' => $status
            );

            echo json_encode($return);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        break;

    case 'search vacancy':

        if($data){
            @$half = $data->half;
            @$state = $data->state;
            @$city = $data->city;
        }else{
            $half = $_GET['half'];
            $state = $_GET['state'];
            $city = $_GET['city'];
        }
        //echo 'half '.$half. ' state '.$state. ' city '.$city;

        try {

            $searchVacancy=$pdo->prepare("SELECT * FROM officeVacancy WHERE minimumSchooling=:half 
                                        OR state=:state 
                                        OR city=:city
                                        OR state=:state AND city=:city");
            $searchVacancy->bindValue(":half", $half);
            $searchVacancy->bindValue(":state", $state);
            $searchVacancy->bindValue(":city", $city);
            $searchVacancy->execute();

            $quantity = $searchVacancy->rowCount();

            if($quantity != 0){

                while ($linha=$searchVacancy->fetch(PDO::FETCH_ASSOC)) {

                    $idvacancy = $linha['idvacancy'];
                    $iduser = $linha['iduser'];
                    $performanceArea = $linha['performanceArea'];
                    $neighborhood = $linha['neighborhood'];
                    $city = $linha['city'];
                    $state = $linha['state'];
                    $publishDate = $linha['publishDate'];

                    $publishDateP = explode('-', $publishDate);
                    $publishDate = $publishDateP[2].'/'.$publishDateP[1];
    
                    $return[] = array(
                        'idvacancy' => $idvacancy,
                        'performanceArea' => $performanceArea,
                        'neighborhood' => $neighborhood,
                        'city' => $city,
                        'state' => $state,
                        'publishDate' => $publishDate
                    );
                }
    
                echo json_encode($return);
                
            } else {

                $status = 0;
                $msg = 'Nenhuma vaga encontrada';

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

    // case 'get all data vacancy':
    case 'get info vacancy':

        $idvacancy = $_GET['idvacancy'];

        try {

            $getAllDataVacancy=$pdo->prepare("SELECT * FROM officeVacancy WHERE idvacancy=:idvacancy");
            $getAllDataVacancy->bindValue(":idvacancy", $idvacancy);
            $getAllDataVacancy->execute();


            while ($linha=$getAllDataVacancy->fetch(PDO::FETCH_ASSOC)) {

                $idvacancy = $linha['idvacancy'];
                $iduser = $linha['iduser'];
                $performanceArea = $linha['performanceArea'];
                $neighborhood = $linha['neighborhood'];
                $city = $linha['city'];
                $state = $linha['state'];

                $minimumSchooling = $linha['minimumSchooling'];
                $tiKnowledge = $linha['tiKnowledge'];
                $secLan = $linha['secLan'];
                $secondLanguage = $linha['secondLanguage'];
                $alreadyInterned = $linha['alreadyInterned'];
                $internshipWorth = $linha['internshipWorth'];
                $transportationWorth = $linha['transportationWorth'];
                $mealWorth = $linha['mealWorth'];
                $activities = $linha['activities'];
                $numberOfVacancy = $linha['numberOfVacancy'];
                $whenStart = $linha['whenStart'];
                $effectuation = $linha['effectuation'];
                $observation = $linha['observation'];

                $publishDate = $linha['publishDate'];

                $whenStartP = explode('-', $whenStart);
                $whenStart = $whenStartP[2].'/'.$whenStartP[1];

                $publishDateP = explode('-', $publishDate);
                $publishDate = $publishDateP[2].'/'.$publishDateP[1];

                //$getEmailVacancy=$pdo->prepare("SELECT email FROM user WHERE iduser=:iduser");
                $getEmailVacancy=$pdo->prepare("SELECT user.email, office.officeName FROM user INNER JOIN office
                ON user.iduser = office.iduser");
                $getEmailVacancy->bindValue(":iduser", $iduser);
                $getEmailVacancy->execute();

                while ($linha=$getEmailVacancy->fetch(PDO::FETCH_ASSOC)) {
                    $email = $linha['email'];
                    $officeName = $linha['officeName'];
                }

                if($secLan == "Não"){
                    $sl = false;
                } else {
                    $sl = true;
                }

                $return = array(
                    'idvacancy' => $idvacancy,
                    'iduser' => $iduser,
                    'performanceArea' => $performanceArea,
                    'neighborhood' => $neighborhood,
                    'city' => $city,
                    'state' => $state,
                    'publishDate' => $publishDate,
                    'whenStart' => $whenStart,
                    'minimumSchooling' => $minimumSchooling,
                    'tiKnowledge' => $tiKnowledge,
                    'secLan' => $secLan,
                    'sl' => $sl,
                    'secondLanguage' => $secondLanguage,
                    'alreadyInterned' => $alreadyInterned,
                    'internshipWorth' => $internshipWorth,
                    'transportationWorth' => $transportationWorth,
                    'mealWorth' => $mealWorth,
                    'activities' => $activities,
                    'numberOfVacancy' => $numberOfVacancy,
                    'effectuation' => $effectuation,
                    'observation' => $observation,
                    'officeEmail' => $email,
                    'officeName' => $officeName
                );
            }
    
            echo json_encode($return);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        break;

    case 'get all vacancies':
        try {

            $getAllVacancies=$pdo->prepare("SELECT * FROM officeVacancy");
            $getAllVacancies->execute();


            while ($linha=$getAllVacancies->fetch(PDO::FETCH_ASSOC)) {

                $idvacancy = $linha['idvacancy'];
                $iduser = $linha['iduser'];
                $performanceArea = $linha['performanceArea'];
                $whenStart = $linha['whenStart'];
                $neighborhood = $linha['neighborhood'];
                $city = $linha['city'];
                $state = $linha['state'];

                $whenStartP = explode('-', $whenStart);
                $whenStart = $whenStartP[2].'/'.$whenStartP[1].'/'.$whenStartP[0];

                $return[] = array(
                    'idvacancy' => $idvacancy,
                    'iduser' => $iduser,
                    'performanceArea' => $performanceArea,
                    'whenStart' => $whenStart,
                    'neighborhood' => $neighborhood,
                    'city' => $city,
                    'state' => $state
                );
            }
    
            echo json_encode($return);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        break;

    case 'get all interesteds':

        $iduser = $_GET['iduser'];
        //echo 'iduser '.$iduser;
        try {

            $getAllInteresteds=$pdo->prepare("SELECT * FROM interestMail WHERE idoffice=:iduser");
            $getAllInteresteds->bindValue(":iduser", $iduser);
            $getAllInteresteds->execute();


            while ($linha=$getAllInteresteds->fetch(PDO::FETCH_ASSOC)) {

                $iduser = $linha['iduser'];
                $studentName = $linha['studentName'];
                $message = $linha['message'];

                $return[] = array(
                    'iduser' => $iduser,
                    'studentName' => $studentName,
                    'message' => $message
                );
            }
    
            echo json_encode($return);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        break;

    case 'get office vacancies list':

        $iduser = $_GET['iduser'];

        try {

            $getOfficeVacancies=$pdo->prepare("SELECT * FROM officeVacancy WHERE iduser=:iduser");
            $getOfficeVacancies->bindValue(":iduser", $iduser);
            $getOfficeVacancies->execute();


            while ($linha=$getOfficeVacancies->fetch(PDO::FETCH_ASSOC)) {
                $idvacancy = $linha['idvacancy'];
                $performanceArea = $linha['performanceArea'];
                $activities = $linha['activities'];
                $internshipWorth = $linha['internshipWorth'];
                $publishDate = $linha['publishDate'];

                $return[] = array(
                    'idvacancy' => $idvacancy,
                    'performanceArea' => $performanceArea,
                    'activities' => $activities,
                    'internshipWorth' => $internshipWorth,
                    'publishDate' => $publishDate
                );
            }
    
            echo json_encode($return);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        break;

    case 'show interest by vacancy':
        // print_r($data);
        $iduser = $data->iduser;
        $studentEmail = $data->studentEmail;
        $officeEmail = $data->officeEmail;
        $idvacancy = $data->idvacancy;
        $idstudent = $data->iduserInterested;

        // DEMAIS DADOS VÃO POR E-MAIL PARA O ESCRITÓRIO
        $performanceArea = $data->performanceArea;
        $internshipWorth = $data->internshipWorth;
        $activities = $data->activities;

        try {

            // $checkIfInterestedSent=$pdo->prepare("SELECT * FROM studentsVacancies 
            //                                     WHERE idstudent=:idstudent AND idvacancy=:idvacancy");
            // $checkIfInterestedSent->bindValue(':idstudent', $idstudent);
            // $checkIfInterestedSent->bindValue(':idvacancy', $idvacancy);
            // $checkIfInterestedSent->execute();

            // $exists = $checkIfInterestedSent->rowCount();

            // if ($exists == 1) {

            //     $msg = 'Candidatura já enviada.';

            //     $return = array(
            //         'msg' => $msg
            //     );
        
            //     echo json_encode($return);

            // } else {

                $saveInterestedInVacancy=$pdo->prepare("INSERT INTO studentsVacancies (idstudentVacancy, idoffice, idstudent, idvacancy) 
                                                    VALUES(?,?,?,?)");
                $saveInterestedInVacancy->bindValue(1, NULL);
                $saveInterestedInVacancy->bindValue(2, $iduser);
                $saveInterestedInVacancy->bindValue(3, $idstudent);
                $saveInterestedInVacancy->bindValue(4, $idvacancy);
                $saveInterestedInVacancy->execute();

                $idvacancy = $data->idvacancy;
                $idstudent = $data->iduserInterested;

                // DEMAIS DADOS VÃO POR E-MAIL PARA O ESCRITÓRIO
                $performanceArea = $data->performanceArea;
                $internshipWorth = $data->internshipWorth;
                $activities = $data->activities;

                $return = array(
                    'idOffice' => $iduser,
                    'officeEmail' => $officeEmail,
                    'studentEmail' => $studentEmail,
                    'performanceArea' => $performanceArea,
                    'internshipWorth' => $internshipWorth,
                    'activities' => $activities
                );
        
                echo json_encode($return);

            // }

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        break;
    
    default:
        # code...
        break;
}




?>