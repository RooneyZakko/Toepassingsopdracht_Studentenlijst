<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

//Load Composer's autoloader
require '../vendor/autoload.php';

// $dotenv = Dotenv\Dotenv::createImmutable('./');
$dotenv = Dotenv\Dotenv::createImmutable( __DIR__ . '/');
$dotenv->load();

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['omschrijving'])) {
             $name = $_POST['name'];
             $email = $_POST['email'];
             $omschrijving = $_POST['omschrijving'];
             $key = mt_rand(9999,99999);

        }
    

try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $_ENV['SMTP_HOST'] ;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $_ENV['SMTP_USERNAME'];                     //SMTP username
    $mail->Password   = $_ENV['SMTP_PASSWORD'];                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $_ENV['SMTP_PORT'];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`



    //Recipients
    $mail->setFrom('ney759@gmail.com', 'rooney');
    $mail->addAddress($email, $name);     
    $mail->addAddress($email, $name);     
    $mail->addCC('ney759@gmail.com');

   
    //Attachments



    //   $mail->addAttachment('../image/ney.jpg', 'ney.jog');         //Add attachments

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'uw klacht is in behandeling, uw behandeling nummer is  ' . $key;
    $mail->Body    =  'Dit is uw klacht:  ' . $omschrijving . ' en uw behandeling nummer is  ' . $key;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

}
?>