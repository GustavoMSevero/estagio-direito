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
    case 'get college data':
        
        $iduser = $_GET['iduser'];

        try {
            
            $getCollegeData=$pdo->prepare("SELECT * FROM college WHERE iduser=:iduser");
            $getCollegeData->bindValue(":iduser", $iduser);
            $getCollegeData->execute();

            while ($linha=$getCollegeData->fetch(PDO::FETCH_ASSOC)) {
                $idcollege = $linha['idcollege'];
                $collegeName = $linha['collegeName'];
                $contactPhone = $linha['contactPhone'];
                $coordinatorName = $linha['coordinatorName'];
                $siteCollege = $linha['siteCollege'];

                $return = array(
                    'idcollege' => $idcollege,
                    'collegeName' => $collegeName,
                    'contactPhone' => $contactPhone,
                    'coordinatorName' => $coordinatorName,
                    'siteCollege' => $siteCollege
                );
            }

            echo json_encode($return);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        
        break;

    case 'show banner':

        $iduser = $_GET['iduser'];

        try {

            $getCollegeBanner=$pdo->prepare("SELECT * from collegebanner WHERE iduser=:iduser");
            $getCollegeBanner->bindValue(":iduser", $iduser);
            $getCollegeBanner->execute();

            while ($linha=$getCollegeBanner->fetch(PDO::FETCH_ASSOC)) {
                $idbanner = $linha['idbanner'];
                $bannerName = $linha['bannerName'];
                $extension = $linha['extension'];
                $local = $linha['local'];

                $bannerView = 'api/uploadCollegeBanner/'.$bannerName;

                $return = array(
                    'idbanner' => $idbanner,
                    'bannerName' => $bannerName,
                    'extension' => $extension,
                    'local' => $local,
                    'bannerView' => $bannerView
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