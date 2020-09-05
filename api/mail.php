<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);


$data = file_get_contents("php://input");
$data = json_decode($data);
// print_r($data);
$idOffice = $data->iduser;
$officeName = $data->officeName;
$officeEmail = $data->officeEmail;
$studentEmail = $data->studentEmail;

$performanceArea = $data->performanceArea;
$internshipWorth = $data->internshipWorth;
$activities = $data->activities;

// echo 'studentEmail '.$studentEmail.', officeName'.$officeEmail.', studentEmail'.$studentEmail.', idOffice'.$idOffice."\n";

try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    // $mail->isSMTP();                                            // Send using SMTP
    // $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    // $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    // $mail->Username   = 'gustavo.msevero@gmail.com';                     // SMTP username
    // $mail->Password   = 'secret';                               // SMTP password
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    // $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('from@example.com', 'Estagio Direito');
    $mail->addAddress($officeEmail, $officeName);     // Add a recipient
    // $mail->addAddress($officeEmail, $officeName);     // Add a recipient
    // $mail->addAddress('ellen@example.com');               // Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Estudante interessado em sua vaga de';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}