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
    case 'show banner':

        $iduser = $_GET['iduser'];

        try {

            $getCollegeBanner=$pdo->prepare("SELECT * from officebanner WHERE iduser=:iduser");
            $getCollegeBanner->bindValue(":iduser", $iduser);
            $getCollegeBanner->execute();

            while ($linha=$getCollegeBanner->fetch(PDO::FETCH_ASSOC)) {
                $idbanner = $linha['idbanner'];
                $bannerName = $linha['bannerName'];
                $extension = $linha['extension'];
                $local = $linha['local'];

                $bannerView = 'api/uploadOfficeBanner/'.$bannerName;

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