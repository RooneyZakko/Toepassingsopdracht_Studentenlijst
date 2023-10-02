<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klacht Indienen</title>
    <link rel="stylesheet" href="a.css">
    
</head>
<body>
    <h1>Klacht Indienen</h1>
    
    <form method="POST" action="op.php">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        
        <label for="omschrijving">Omschrijving klacht:</label><br>
        <textarea id="omschrijving" name="omschrijving"  required></textarea><br>
        
        <input type="submit" value="Versturen">
    </form>
</body>
</html>