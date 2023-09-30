<?php
require '../vendor/autoload.php';

// $dotenv = Dotenv\Dotenv::createImmutable('./');
$dotenv = Dotenv\Dotenv::createImmutable( __DIR__ . '/');
$dotenv->load();


$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connectie mislukt: " . $conn->connect_error);
}

$query = "SELECT voornaam, achternaam, email, telefoonnummer FROM studenten";
$result = $conn->query($query);


use Dompdf\Dompdf;
use Dompdf\Options;


$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$options->set('isRemoteEnabled', true);


$dompdf = new Dompdf($options);


$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Studentenlijst PDF</title>
    <style>

      
        
        table{
            margin: auto;
            border-collapse: collapse;

        }
        th, td{
            border: 1px solid black;
        }
        h1{
            text-align: center;
            color: green;

        }
        th, td {
            text-align: center;
            padding: 8px;
        }
                
        tr:nth-child(even) {
            background-color: #dddddd;
        }      

    </style>
</head>
<body>
    <h1>Studentenlijst: WEB2A</h1>
    <table>
            <tr>
                <th>Naam</th>
                <th>Email</th>
                <th>Telefoonnummer</th>
            </tr>
';
       

$query = "SELECT * FROM studenten";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>';
        $html .= '<td>' . $row['voornaam'] . ' ' . $row['achternaam'] . '</td>';
        $html .= '<td>' . $row['email'] . '</td>';
        $html .= '<td>' . $row['telefoonnummer'] . '</td>';
        $html .= '</tr>';
    }
}

$html .= '
    </table>
</body>
</html>';

$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream("studentenlijst.pdf");

$conn->close();
?>
