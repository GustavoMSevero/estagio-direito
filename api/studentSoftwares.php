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
    case 'save softwares':
        // print_r($data);
        $iduser=$data->iduser;
        @$msWord=$data->msWord;
        @$msExcel=$data->msExcel;
        @$openOfficeWrite=$data->openOfficeWrite;
        @$openOfficeCalc=$data->openOfficeCalc;
        @$libreOfficeWrite=$data->libreOfficeWrite;
        @$libreOfficeCalc=$data->libreOfficeCalc;

        if ($msWord == '') {
            $msWord = 0;
        }

        if ($msExcel == '') {
            $msExcel = 0;
        }

        if ($openOfficeWrite == '') {
            $openOfficeWrite = 0;
        }

        if ($openOfficeCalc == '') {
            $openOfficeCalc = 0;
        }

        if ($libreOfficeWrite == '') {
            $libreOfficeWrite = 0;
        }

        if ($libreOfficeCalc == '') {
            $libreOfficeCalc = 0;
        }


        try {
            $getTiSoftwares=$pdo->prepare("SELECT idstudentTi FROM studentTi WHERE iduser=:iduser");
            $getTiSoftwares->bindValue(":iduser", $iduser);
            $getTiSoftwares->execute();

            $exists = $getTiSoftwares->rowCount();

            while ($linha=$getTiSoftwares->fetch(PDO::FETCH_ASSOC)) {
                $idstudentTi = $linha['idstudentTi'];
            }
            
            if ($exists == 1) {
                $updateTiSoftwares=$pdo->prepare("UPDATE studentTi SET msword=:msword, msexcel=:msexcel, openOfficeWrite=:openOfficeWrite, 
                                                openOfficeCalc=:openOfficeCalc, libreOfficeWrite=:libreOfficeWrite, libreOfficeCalc=:libreOfficeCalc
                                                WHERE idstudentTi=:idstudentTi AND iduser=:iduser");
                $updateTiSoftwares->bindValue(":msword", $msWord);
                $updateTiSoftwares->bindValue(":msexcel", $msExcel);
                $updateTiSoftwares->bindValue(":openOfficeWrite", $openOfficeWrite);
                $updateTiSoftwares->bindValue(":openOfficeCalc", $openOfficeCalc);
                $updateTiSoftwares->bindValue(":libreOfficeWrite", $libreOfficeWrite);
                $updateTiSoftwares->bindValue(":libreOfficeCalc", $libreOfficeCalc);
                $updateTiSoftwares->bindValue(":iduser", $iduser);
                $updateTiSoftwares->bindValue(":idstudentTi", $idstudentTi);
                $updateTiSoftwares->execute();

                $msg = 'Dados atualizados com sucesso!';

                $return = array(
                    'msg' => $msg
                );

                echo json_encode($return);

            } else {

                $saveTiSoftwares=$pdo->prepare("INSERT INTO studentTi (idstudentTi, iduser, msword, msexcel, openOfficeWrite, openOfficeCalc, libreOfficeWrite, libreOfficeCalc) 
                                        VALUES(?,?,?,?,?,?,?,?)");
                $saveTiSoftwares->bindValue(1, NULL);
                $saveTiSoftwares->bindValue(2, $iduser);
                $saveTiSoftwares->bindValue(3, $msWord);
                $saveTiSoftwares->bindValue(4, $msExcel);
                $saveTiSoftwares->bindValue(5, $openOfficeWrite);
                $saveTiSoftwares->bindValue(6, $openOfficeCalc);
                $saveTiSoftwares->bindValue(7, $libreOfficeWrite);
                $saveTiSoftwares->bindValue(8, $libreOfficeCalc);
                $saveTiSoftwares->execute();

                $msg = 'Dados salvos com sucesso!';
                
                $return = array(
                    'msg' => $msg
                );

                echo json_encode($return);

            }

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        break;

    case 'get softwares':
        
        $iduser = $_GET['iduser'];

        try {

            $getSoftwares=$pdo->prepare("SELECT * FROM studentTi WHERE iduser=:iduser");
            $getSoftwares->bindValue(":iduser", $iduser);
            $getSoftwares->execute();

            while ($linha=$getSoftwares->fetch(PDO::FETCH_ASSOC)) {
                $msWord = $linha['msword'];
                $msExcel = $linha['msexcel'];
                $openOfficeWrite = $linha['openOfficeWrite'];
                $openOfficeCalc = $linha['openOfficeCalc'];
                $libreOfficeWrite = $linha['libreOfficeWrite'];
                $libreOfficeCalc = $linha['libreOfficeCalc'];
            }

            $msWordChecked = false;
            $msExcelChecked = false;
            $openOfficeWriteChecked = false;
            $openOfficeCalcChecked = false;
            $libreOfficeWriteChecked = false;
            $libreOfficeCalcChecked = false;

            // $useMSWord = '';
            // $useMSExcel = '';
            // $useOfficeWrite = '';
            // $useOpenOfficeCalc = '';
            // $useLibreOfficeWrite = '';
            // $useLibreOfficeCalc = '';

            if ($msWord == 1) {
                $msWord = 'Sim';
                $msWordChecked = true;
            } else {
                $msWord = 'Não';
            }

            if ($msExcel == 1) {
                $msExcel = 'Sim';
                $msExcelChecked = true;
            } else {
                $msExcel = 'Não';
            }

            if ($openOfficeWrite == 1) {
                $openOfficeWrite = 'Sim';
                $openOfficeWriteChecked = true;
            } else {
                $openOfficeWrite = 'Não';
            }

            if ($openOfficeCalc == 1) {
                $openOfficeCalc = 'Sim';
                $openOfficeCalcChecked = true;
            } else {
                $openOfficeCalc = 'Não';
            }

            if ($libreOfficeWrite == 1) {
                $libreOfficeWrite = 'Sim';
                $libreOfficeWriteChecked = true;
            } else {
                $libreOfficeWrite = 'Não';
            }

            if ($libreOfficeCalc == 1) {
                $libreOfficeCalc = 'Sim';
                $libreOfficeCalcChecked = true;
            } else {
                $libreOfficeCalc = 'Não';
            }

            $return = array(
                'msWord' => $msWord,
                'msWordChecked' => $msWordChecked,

                'msExcel' => $msExcel,
                'msExcelChecked' => $msExcelChecked,

                'openOfficeWrite' => $openOfficeWrite,
                'openOfficeWriteChecked' => $openOfficeWriteChecked,

                'openOfficeCalc' => $openOfficeCalc,
                'openOfficeCalcChecked' => $openOfficeCalcChecked,

                'libreOfficeWrite' => $libreOfficeWrite,
                'libreOfficeWriteChecked' => $libreOfficeWriteChecked,

                'libreOfficeCalc' => $libreOfficeCalc,
                'libreOfficeCalcChecked' => $libreOfficeCalcChecked
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