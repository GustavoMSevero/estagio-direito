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
	case "register user":
        // print_r($data);
        $type = $data->type;
		
		try {

            if($type == "Escritório"){

                //Escritório
                $type = $data->type;
                $email = $data->email;
                $password = md5($data->password);

                $nameOffice = $data->nameOffice;
                $address = $data->logradouro;
                $addressNumber = $data->addressNumber;
                $complement = $data->complement;
                $neighborhood = $data->bairro;
                $city = $data->localidade;
                $state = $data->uf;
                $openVacancy = $data->openVacancy;

                $registerUser=$pdo->prepare("INSERT INTO user (iduser, usertype, email, userpassword) VALUES (?,?,?,?)");
                $registerUser->bindValue(1, NULL);
                $registerUser->bindValue(2, $type);
                $registerUser->bindValue(3, $email);
                $registerUser->bindValue(4, $password);
                $registerUser->execute();

                $iduser = $pdo->lastInsertId();

                //$return = array();

                $registerOffice=$pdo->prepare("INSERT INTO office (idoffice, iduser, officeName, address, addressNumber, complement, neighborhood, city, state, openVacancy) 
                                                VALUES (?,?,?,?,?,?,?,?,?,?)");
                $registerOffice->bindValue(1, NULL);
                $registerOffice->bindValue(2, $iduser);
                $registerOffice->bindValue(3, $nameOffice);
                $registerOffice->bindValue(4, $address);
                $registerOffice->bindValue(5, $addressNumber);
                $registerOffice->bindValue(6, $complement);
                $registerOffice->bindValue(7, $neighborhood);
                $registerOffice->bindValue(8, $city);
                $registerOffice->bindValue(9, $state);
                $registerOffice->bindValue(10, $openVacancy);
                $registerOffice->execute();

                $return = array(
                    'iduser' => $iduser,
                    'name' => $nameOffice,
                    'email' => $email,
                    'type' => $type
                );

                echo json_encode($return);

            } elseif($type == "Estudante"){

                // Estudante
                $type = $data->type;
                $email = $data->email;
                $password = md5($data->password);

                $name = $data->fullname;
                $dateBirthday = $data->studantDateBirthday;
                $sex = $data->sex;
                $universityName = $data->universityName;
                $semester = $data->semester;
                @$startYear = $data->startYear;
                $conclusionYear = $data->conclusionYear;
                @$OABNumberCard = $data->OABNumberCard;

                $dateBirthdayP = explode('T', $dateBirthday);
                $dateBirthday = $dateBirthdayP[0];

                $registerUser=$pdo->prepare("INSERT INTO user (iduser, usertype, email, userpassword) VALUES (?,?,?,?)");
                $registerUser->bindValue(1, NULL);
                $registerUser->bindValue(2, $type);
                $registerUser->bindValue(3, $email);
                $registerUser->bindValue(4, $password);
                $registerUser->execute();

                $iduser = $pdo->lastInsertId();

                $registerStudant=$pdo->prepare("INSERT INTO student (idstudent, iduser, name, dateBirthday, sex, universityName, semester, startYear, conclusionYear, OABNumberCard) 
                                                VALUES (?,?,?,?,?,?,?,?,?,?)");
                $registerStudant->bindValue(1, NULL);
                $registerStudant->bindValue(2, $iduser);
                $registerStudant->bindValue(3, $name);
                $registerStudant->bindValue(4, $dateBirthday);
                $registerStudant->bindValue(5, $sex);
                $registerStudant->bindValue(6, $universityName);
                $registerStudant->bindValue(7, $semester);
                $registerStudant->bindValue(8, $startYear);
                $registerStudant->bindValue(9, $conclusionYear);
                $registerStudant->bindValue(10, $OABNumberCard);
                $registerStudant->execute();

                $return = array(
                    'iduser' => $iduser,
                    'name' => $name,
                    'email' => $email,
                    'type' => $type
                );

                echo json_encode($return);

            } else {
                
                // Faculdade
                $type = $data->type;
                $email = $data->email;
                $password = md5($data->password);

                @$collegeName = $data->collegeName;
                @$contactPhone = $data->contactPhone;
                @$siteCollege = $data->siteCollege;
                @$coordinatorName = $data->coordinatorName;
                
                $registerUser=$pdo->prepare("INSERT INTO user (iduser, usertype, email, userpassword) VALUES (?,?,?,?)");
                $registerUser->bindValue(1, NULL);
                $registerUser->bindValue(2, $type);
                $registerUser->bindValue(3, $email);
                $registerUser->bindValue(4, $password);
                $registerUser->execute();

                $iduser = $pdo->lastInsertId();

                $registerCollege=$pdo->prepare("INSERT INTO college (idcollege, iduser, collegeName, contactPhone, coordinatorName, siteCollege) 
                                                VALUES (?,?,?,?,?,?)");
                $registerCollege->bindValue(1, NULL);
                $registerCollege->bindValue(2, $iduser);
                $registerCollege->bindValue(3, $collegeName);
                $registerCollege->bindValue(4, $contactPhone);
                $registerCollege->bindValue(5, $coordinatorName);
                $registerCollege->bindValue(6, $siteCollege);
                $registerCollege->execute();
                
                $return = array(
                    'iduser' => $iduser,
                    'name' => $collegeName,
                    'email' => $email,
                    'type' => $type
                );

                echo json_encode($return);
            }

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

		break;

    case "login user":
		$email = $data->email;
        $password = md5($data->password);

		try {

            $getUserType=$pdo->prepare("SELECT * FROM user WHERE email=:email AND userpassword=:password");
            $getUserType->bindValue(":email", $email);
            $getUserType->bindValue(":password", $password);
            $getUserType->execute();

            $exists = $getUserType->rowCount();

            $return = array();

            if($exists == 0){

                $status = 0;
                $msg = 'E-mail ou senha inválido. Tente novamente.';

                $return = array(
                    'status' => $status,
                    'msg' => $msg
                );

                echo json_encode($return);

            } else {

                while ($linha=$getUserType->fetch(PDO::FETCH_ASSOC)) {
                    $iduser = $linha['iduser'];
                    $userType = $linha['usertype'];
                }
    
                $return = array(
                    'iduser' => $iduser,
                    'usertype' => $userType,
                    'email' => $email
                );
    
                if($userType == "Escritório"){
                    $getUser=$pdo->prepare("SELECT officeName FROM office WHERE iduser=:iduser");
                    $getUser->bindValue(":iduser", $iduser);
                    $getUser->execute();
    
                    while ($linha=$getUser->fetch(PDO::FETCH_ASSOC)) {
                        $username = $linha['officeName'];
                    }
    
                } elseif($userType == "Estudante"){
                    $getUser=$pdo->prepare("SELECT name FROM student WHERE iduser=:iduser");
                    $getUser->bindValue(":iduser", $iduser);
                    $getUser->execute();
    
                    while ($linha=$getUser->fetch(PDO::FETCH_ASSOC)) {
                        $username = $linha['name'];
                    }
    
                } else {
                    $getUser=$pdo->prepare("SELECT collegeName FROM college WHERE iduser=:iduser");
                    $getUser->bindValue(":iduser", $iduser);
                    $getUser->execute();
    
                    while ($linha=$getUser->fetch(PDO::FETCH_ASSOC)) {
                        $username = $linha['collegeName'];
                    }
    
    
                }
    
                $return["username"] = $username;

                echo json_encode($return);

            }

		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}

		break;

	case "get types":

		$getUserTypes=$pdo->prepare("SELECT * FROM usertype");
		$getUserTypes->execute();

		$return = array();

		try {

			while ($linha=$getUserTypes->fetch(PDO::FETCH_ASSOC)) {

				$cod = $linha['cod'];
				$type = $linha['type'];
	
				$return[] = array(
                    'cod'	=> $cod,
                    'type'	=> $type
				);
	
			}
	
			echo json_encode($return);


		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}

        break;
        
    case "get email":
    
        $iduser = $_GET['iduser'];

        $getLoginDataUser=$pdo->prepare("SELECT * FROM user WHERE iduser=:iduser");
        $getLoginDataUser->bindValue(":iduser", $iduser);
        $getLoginDataUser->execute();

        $return = array();

        try {

            while ($linha=$getLoginDataUser->fetch(PDO::FETCH_ASSOC)) {

                $email = $linha['email'];
    
                $return = array(
                    'email'	=> $email
                );
    
            }
    
            echo json_encode($return);


        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        break;

    case "update email":

        $email = $data->email;
        $iduser = $data->iduser;
        //echo $email.' - '.$iduser;

        try {

            $updateEmailUser=$pdo->prepare("UPDATE user SET email=:email WHERE iduser=:iduser");
            $updateEmailUser->bindValue(":email", $email);
            $updateEmailUser->bindValue(":iduser", $iduser);
            $updateEmailUser->execute();

            $return = array();

            $status = 1;

            $return = array(
                'status'	=> $status
            );
    
            echo json_encode($return);


        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        break;

    case "update password":
        //print_r($data);
        $currentPassword = md5($data->currentPassword);
        $newPassword = md5($data->newPassword);
        $iduser = $data->iduser;

        try {
            
            $getPassword=$pdo->prepare("SELECT userpassword FROM user WHERE iduser=:iduser");
            $getPassword->bindValue(":iduser", $iduser);
            $getPassword->execute();

            while ($linha=$getPassword->fetch(PDO::FETCH_ASSOC)) {
                $userPassword = $linha['userpassword'];
            }
            //echo $currentPassword.'-'.$userPassword;

            if($currentPassword == $userPassword){
                //echo "Sim, é o mesmo";
                $updatePassword=$pdo->prepare("UPDATE user SET userpassword=:userpassword WHERE iduser=:iduser");
                $updatePassword->bindValue(":userpassword", $newPassword);
                $updatePassword->bindValue(":iduser", $iduser);
                $updatePassword->execute();

            } else {
                //echo "Não, é diferente";
                $status = 0;
                $msg = 'Senha atual não confere';

                $return = array(
                    'status'	=> $status,
                    'msg'	=> $msg
                );

                echo json_encode($return);
            }

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }


        break;

    case "get office data":
        //print_r($data);
        $iduser = $_GET['iduser'];
 
        try {
            
            $getOfficeData=$pdo->prepare("SELECT * FROM office WHERE iduser=:iduser");
            $getOfficeData->bindValue(":iduser", $iduser);
            $getOfficeData->execute();

            while ($linha=$getOfficeData->fetch(PDO::FETCH_ASSOC)) {

                $idoffice = $linha['idoffice'];
                $officeName = $linha['officeName'];
                $address = $linha['address'];
                $addressNumber = $linha['addressNumber'];
                $complement = $linha['complement'];
                $neighborhood = $linha['neighborhood'];
                $city = $linha['city'];
                $state = $linha['state'];
                $openVacancy = $linha['openVacancy'];
    
                $return = array(
                    'idoffice'	=> $idoffice,
                    'officeName'	=> $officeName,
                    'logradouro'	=> $address,
                    'addressNumber'	=> $addressNumber,
                    'complement'	=> $complement,
                    'bairro'	=> $neighborhood,
                    'localidade'	=> $city,
                    'uf'	=> $state,
                    'openVacancy'	=> $openVacancy
                );
    
            }
    
            echo json_encode($return);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }


        break;

    case "update office data":
        //print_r($data);
        $idoffice = $data->idoffice;
        $officeName = $data->officeName;
        $address = $data->logradouro;
        $addressNumber = $data->addressNumber;
        $complement = $data->complement;
        $neighborhood = $data->bairro;
        $city = $data->localidade;
        $state = $data->uf;
        $openVacancy = $data->openVacancy;
        $iduser = $data->iduser;
    
        try {
            
            $updateOfficeData=$pdo->prepare("UPDATE office SET officeName=:officeName, address=:address, addressNumber=:addressNumber, complement=:complement, 
                                            neighborhood=:neighborhood, city=:city, state=:state, openVacancy=:openVacancy WHERE iduser=:iduser AND idoffice=:idoffice");
            $updateOfficeData->bindValue(":officeName", $officeName);
            $updateOfficeData->bindValue(":address", $address);
            $updateOfficeData->bindValue(":addressNumber", $addressNumber);
            $updateOfficeData->bindValue(":complement", $complement);
            $updateOfficeData->bindValue(":neighborhood", $neighborhood);
            $updateOfficeData->bindValue(":city", $city);
            $updateOfficeData->bindValue(":state", $state);
            $updateOfficeData->bindValue(":openVacancy", $openVacancy);
            $updateOfficeData->bindValue(":iduser", $iduser);
            $updateOfficeData->bindValue(":idoffice", $idoffice);
            $updateOfficeData->execute();
    
            $status = 1;
            $msg = 'Dados atualizados com sucesso.';

            $return = array(
                'status'	=> $status,
                'officeName' => $officeName,
                'msg' => $msg
            );
    
            echo json_encode($return);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }


        break;

    case "get other data student to change":

        $iduser = $_GET['iduser'];
    
        try {
            
            $getOtherDataStudent=$pdo->prepare("SELECT * FROM student WHERE iduser=:iduser");
            $getOtherDataStudent->bindValue(":iduser", $iduser);
            $getOtherDataStudent->execute();

            while ($linha=$getOtherDataStudent->fetch(PDO::FETCH_ASSOC)) {

                $name = $linha['name'];
                $dateBirthday = $linha['dateBirthday'];
                $sex = $linha['sex'];
                $phone = $linha['phone'];
                $mobilephone = $linha['mobilephone'];

                $dateBirthdayP = explode('-', $dateBirthday);
                $dateBirthday = $dateBirthdayP[2].'/'.$dateBirthdayP[1].'/'.$dateBirthdayP[0];

                if($sex == 'M'){
                    $sex = 'Masculino';
                } else {
                    $sex = 'Feminino';
                }
    
                $return = array(
                    'name'	=> $name,
                    'dateBirthday'	=> $dateBirthday,
                    'sex'	=> $sex,
                    'phone'	=> $phone,
                    'mobilephone' => $mobilephone
                );
    
            }
    
            echo json_encode($return);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        break;

    case "update other data student to change":
        // print_r($data);
        $dateBirthday = $data->dateBirthday;
        $iduser = $data->iduser;
        $phone = $data->phone;
        $mobilephone = $data->mobilephone;

        $dateBirthdayP = explode('/', $dateBirthday);
        $dateBirthday = $dateBirthdayP[2].'-'.$dateBirthdayP[1].'-'.$dateBirthdayP[0];

        // echo $dateBirthday;
    
        try {
            
            $updateOtherDataStudent=$pdo->prepare("UPDATE student 
                                                    SET dateBirthday=:dateBirthday, phone=:phone, mobilephone=:mobilephone
                                                    WHERE iduser=:iduser");
            $updateOtherDataStudent->bindValue(":dateBirthday", $dateBirthday);
            $updateOtherDataStudent->bindValue(":phone", $phone);
            $updateOtherDataStudent->bindValue(":mobilephone", $mobilephone);
            $updateOtherDataStudent->bindValue(":iduser", $iduser);
            $updateOtherDataStudent->execute();
    
            $status = 1;
            $msg = 'Dados atualizados com sucesso';

            $return = array(
                'status'	=> $status,
                'msg' => $msg
            );
    
            echo json_encode($return);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }


        break;

	case 'mostrar foto':

		// $idempresa = $_GET['idempresa'];
		// $idfoto = 0;
		// $imagem = '';
		// $nome = '';

		// $qryMostrarFoto=$pdo->prepare('SELECT * FROM foto WHERE idempresa=:idempresa');
		// $qryMostrarFoto->bindValue('idempresa', $idempresa);
		// $qryMostrarFoto->execute();

		// $return = array();

		// while ($linha=$qryMostrarFoto->fetch(PDO::FETCH_ASSOC)) {

		// 	$id = $linha['id'];
		// 	$nome = $linha['nome'];
		// 	$imagem = "api/uploadFoto/".$nome;

		// }
			
		// 	if($imagem == ""){
		// 		$imagem = "api/uploadFoto/empresa.png";

		// 		$return = array(
		// 			'imagem' => $imagem
		// 		);

		// 	} else {

		// 		$return = array(
		// 			'id' => $id,
		// 			'imagem' => $imagem,
		// 		);

		// 	}

		// 	echo json_encode($return);


		break;

	case "atualizar empresa":

		// $owner = $data->dono;
		// $nome = $data->nome;
		// $email = $data->email;
		// $idempresa = $data->idempresa;

        // try {
        //     $updateCia=$pdo->prepare("UPDATE empresa SET dono=:dono, nome=:nome, email=:email WHERE idempresa=:idempresa");
        //     $updateCia->bindValue(':dono', $owner);
        //     $updateCia->bindValue(':nome', $nome);
        //     $updateCia->bindValue(':email', $email);
        //     $updateCia->bindValue(':idempresa', $idempresa);
		// 	$updateCia->execute();

		// 	$status = 1;
		// 	$msg = "Dados atualizados com Sucesso.";

        //     $return = array(
        //         'status' => $status,
        //         'msg' => $msg
        //     );

        //     echo json_encode($return);

        // } catch (Exception $e) {
        //     echo 'Caught exception: ',  $e->getMessage(), "\n";
        // }

		break;
	
	default:
		# code...
		break;
}




?>