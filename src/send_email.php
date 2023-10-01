<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();

// Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['email']) && isset($_GET['name'])) {
    $name = urldecode($_GET['name']);
    $email = urldecode($_GET['email']);

    try {
        // Server settings
        $mail->isSMTP();  // Send using SMTP
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;  // Enable SMTP authentication
        $mail->Username = $_ENV['SMTP_USERNAME'];
        $mail->Password = $_ENV['SMTP_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  // Enable implicit TLS encryption
        $mail->Port = $_ENV['SMTP_PORT'];

        // Recipients
        $mail->setFrom('ney759@gmail.com', 'rooney');
        $mail->addAddress($email, $name);
       // $mail->addCC('mohamad-h8@hotmail.com');
        // $mail->addBCC('mohamad-h8@hotmail.com');
        $mail->addCC('ney759@gmail.com');

        // Content
        $mail->isHTML(true);  // Set email format to HTML
        $mail->Subject = 'Welkom in onze klas. '  . $name ;
        $mail->Body =  'Hallo, we zijn erg blij dat je er bent, ' . $name . '!'  ;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo 'Missing required data';
}
?>
