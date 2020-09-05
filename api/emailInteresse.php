<?php
header("Access-Control-Allow-Origin: *");
ini_set('display_errors', true);
error_reporting(E_ALL);

include_once("con.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

require 'vendor/autoload.php';

$pdo = conectar();

$data = file_get_contents("php://input");
$data = json_decode($data);

if($data){
	$option = $data->option;
}else{
	$option = $_GET['option'];
}

switch ($option) {
    case 'Send interest message':
        //var_dump($data);
        $iduser = $data->iduser;
        $userType = $data->userType;
        $name = $data->name;

        $idvacancy = $data->idvacancy;
        $emailOffice = $data->emailOffice;
        $officeName = $data->officeName;
        $idOffice = $data->idOffice;

        //echo 'iduser '.$iduser.' userType '.$userType. ' name '.$name.' emailOffice '.$emailOffice.' idvacancy '.$idvacancy.' officeName '.$officeName.' idOffice '.$idOffice;

        $message = 'Olá '.$officeName.'! O estudante '.$name.' mostrou interesse na vaga '.$idvacancy.'. Para ver seu currículo acesse o portal.';
        //echo $message;

        try {

            //Instantiation and passing `true` enables exceptions
            // $mail = new PHPMailer(true);

            //Server settings
            // $mail->SMTPDebug = 'smtp.startwe.com.br';                 // Enable verbose debug output
            // $mail->isSMTP();                                            // Send using SMTP
            // $mail->Host       = 'smtp.uni5.net';                        // Set the SMTP server to send through
            // $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            // $mail->Username   = 'participar@startwe.com.br';            // SMTP username
            // $mail->Password   = 'Participar@2019';                      // SMTP password
            // $mail->Port       = 587;                                    // TCP port to connect to

            // //Recipients
            // $mail->setFrom('participar@startwe.com.br', 'StartWe');
            // $mail->addAddress($emailDonoStartup, $nomeResponsavel);     // Add a recipient

            // // Content
            // $mail->isHTML(true);                                  // Set email format to HTML
            // $mail->Subject = 'Interesse na vaga '.$idvacancy;
            // $mail->Body    = $mensagem;
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            //$mail->send();
            //echo 'Message has been sent';

            $saveMessage=$pdo->prepare('INSERT INTO interestMail (idinterestMail, iduser, idOffice, studentName, message) VALUES (?,?,?,?,?)');
            $saveMessage->bindValue(1, NULL);
            $saveMessage->bindValue(2, $iduser);
            $saveMessage->bindValue(3, $idOffice);
            $saveMessage->bindValue(4, $name);
            $saveMessage->bindValue(5, $message);
            $saveMessage->execute();

            $msg = 'Mensagem  de interesse enviada com sucesso!';

            $return = array(
                'msg' => $msg
            );

            echo json_encode($return);

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        break;
    
    default:
        # code...
        break;
}


// //Instantiation and passing `true` enables exceptions
// $mail = new PHPMailer(true);

// try {
//     //Server settings
//     //$mail->SMTPDebug = 'smtp.startwe.com.br';                 // Enable verbose debug output
//     $mail->isSMTP();                                            // Send using SMTP
//     $mail->Host       = 'smtp.uni5.net';                        // Set the SMTP server to send through
//     $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
//     $mail->Username   = 'participar@startwe.com.br';            // SMTP username
//     $mail->Password   = 'Participar@2019';                      // SMTP password
//     //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
//     $mail->Port       = 587;                                    // TCP port to connect to

//     //Recipients
//     $mail->setFrom('participar@startwe.com.br', 'StartWe');
//     $mail->addAddress($emailDonoStartup, $nomeResponsavel);     // Add a recipient

//     // Content
//     $mail->isHTML(true);                                  // Set email format to HTML
//     $mail->Subject = 'Interesse na vaga '.$idvacancy;
//     $mail->Body    = $mensagem;
//     $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

//     //$mail->send();
//     //echo 'Message has been sent';

//     $msg = 'Sua mensagem foi enviada com sucesso!';

//     $return = array(
//         'msg' => $msg
//     );

//     echo json_encode($return);

// } catch (Exception $e) {
//     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
// }





?>