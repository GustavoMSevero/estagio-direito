<?php
ini_set('display_errors', true);
error_reporting(E_ALL);

header("Access-Control-Allow-Methods", "POST, PUT, OPTIONS");
header("Access-Control-Allow-Origin", "*.*");
header("Access-Control-Allow-Headers", "Content-Type");

include_once("con.php");

$pdo = conectar();

$uploadDir = "uploadCurriculo/";

//print_r($_FILES);
$uploadfile = $uploadDir . $_FILES['file_pdf']['name'];
$iduser= $_GET['iduser'];

move_uploaded_file($_FILES['file_pdf']['tmp_name'], $uploadfile);

  $nome = $_FILES[ 'file_pdf' ][ 'name' ];
  $extension = $_FILES[ 'file_pdf' ][ 'type' ];
  $local = $_FILES[ 'file_pdf' ][ 'tmp_name' ];
  //$tamanho = $_FILES[ 'file_pdf' ][ 'size' ];

try {
    $qryUploadCV=$pdo->prepare('INSERT INTO resume (idresume, iduser, resumeName, extension, local) VALUES (?,?,?,?,?)');
    $qryUploadCV->bindValue(1, NULL);
    $qryUploadCV->bindValue(2, $iduser);
    $qryUploadCV->bindValue(3, $nome);
    $qryUploadCV->bindValue(4, $extension);
    $qryUploadCV->bindValue(5, $local);
    $qryUploadCV->execute();

    $status = 1;
    //$msg = 'OK';

    $return = array(
      //'msg' => 
      'status' => $status
    );

    echo json_encode($return);

} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";

}


?>
