<?php
include_once 'connection.php';
$counter = 0;
$sql = "SELECT `adres`, `plaats`, `afbeelding1` FROM `vw_woningen`";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();


while ($row = $result->fetch_array()) {
    $html[$counter] = '<img src="' . $row["afbeelding1"] . '" height="200px" width="200px">';
    $counter = $counter + 1;
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Overzicht | Vakantiewoningen</title>
</head>

<body>
    <header id="navbar">
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="overzicht.php">Overzicht</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>
    
    <?php foreach ($html as $row) { 
        echo $row;
    }
    ?>

</body>

</html>