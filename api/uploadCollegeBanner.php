<?php
ini_set('display_errors', true);
error_reporting(E_ALL);

header("Access-Control-Allow-Methods", "POST, PUT, OPTIONS");
header("Access-Control-Allow-Origin", "*.*");
header("Access-Control-Allow-Headers", "Content-Type");

include_once("con.php");

$pdo = conectar();

$uploadDir = "uploadCollegeBanner/";

//print_r($_FILES);
$uploadfile = $uploadDir . $_FILES['file_jpg']['name'];
$iduser= $_GET['iduser'];
$idbanner= $_GET['idbanner'];

$qrySearchBanner=$pdo->prepare("SELECT * FROM collegebanner WHERE idbanner=:idbanner AND iduser=:iduser");
$qrySearchBanner->bindValue(':idbanner', $idbanner);
$qrySearchBanner->bindValue(':iduser', $iduser);
$qrySearchBanner->execute();

$qtd = $qrySearchBanner->rowCount();

if($qtd == 0){

  if(move_uploaded_file($_FILES['file_jpg']['tmp_name'], $uploadfile)) {

    $name = $_FILES[ 'file_jpg' ][ 'name' ];
    $extension = $_FILES[ 'file_jpg' ][ 'type' ];
    $local = $_FILES[ 'file_jpg' ][ 'tmp_name' ];
    //$tamanho = $_FILES[ 'file_jpg' ][ 'size' ];

    $qryUploadCollegeBanner=$pdo->prepare('INSERT INTO collegebanner (idbanner, iduser, bannerName, extension, local) VALUES (?,?,?,?,?)');
    $qryUploadCollegeBanner->bindValue(1, NULL);
    $qryUploadCollegeBanner->bindValue(2, $iduser);
    $qryUploadCollegeBanner->bindValue(3, $name);
    $qryUploadCollegeBanner->bindValue(4, $local);
    $qryUploadCollegeBanner->bindValue(5, $extension);
    $qryUploadCollegeBanner->execute();

  }

} else {

  while ($linha=$qrySearchBanner->fetch(PDO::FETCH_ASSOC)) {

    $iduser = $linha['iduser'];
    $idbanner = $linha['idbanner'];
    $nome = $linha['bannerName'];

    $imagem = 'uploadCollegeBanner/'.$nome;
    //echo $imagem;
    if($imagem != 'undefined'){
      unlink($imagem);
    }

    if(move_uploaded_file($_FILES['file_jpg']['tmp_name'], $uploadfile)) {

      $name = $_FILES[ 'file_jpg' ][ 'name' ];
      $extension = $_FILES[ 'file_jpg' ][ 'type' ];
      $local = $_FILES[ 'file_jpg' ][ 'tmp_name' ];
      //$tamanho = $_FILES[ 'file_jpg' ][ 'size' ];


      $qryUpdateBanner=$pdo->prepare('UPDATE collegebanner SET bannerName=:bannerName, extension=:extension, local=:local
                                     WHERE idbanner=:idbanner');
      $qryUpdateBanner->bindValue(':idbanner', $idbanner);
      $qryUpdateBanner->bindValue(':bannerName', $name);
      $qryUpdateBanner->bindValue(':extension', $extension);
      $qryUpdateBanner->bindValue(':local', $local);
      $qryUpdateBanner->execute();

    }

  }

}


?>
