<?php
include_once 'connection.php';
$counter = 0;
$sql = "SELECT `woningnummer`, `adres`, `plaats`, `afbeelding1` FROM `vw_woningen`";

if(isset($_GET['search'])) {
    $sql = 'SELECT `woningnummer`, `adres`, `plaats`, `afbeelding1` 
    FROM `vw_woningen` 
    WHERE `adres` LIKE ? OR 
    `postcode` LIKE ? OR 
    `plaats` LIKE ? OR 
    `prijs` LIKE ? OR 
    `verkocht` LIKE ?';
}

$stmt = $conn->prepare($sql);

if(isset($_GET['search'])) {
    $s = '%' . $_GET['search'] . '%';
    $stmt->bind_param('sssss', $s, $s, $s, $s, $s);
}

$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) { 
    header('Location: overzicht.php');
}

while ($row = $result->fetch_array()) {
    $html[$counter] = '<div class="card" onclick="gotodetails(' . $row["woningnummer"] . ')"> <img class="image" src="' . $row["afbeelding1"] . '" height="225px" width="225px"> <p class="card-text">' . $row["adres"] . ' </p>  <p class="card-text">' . $row["plaats"] . ' </p>     </div>';
    $counter = $counter + 1;
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/overzicht.css">
    <title>Overzicht | Vakantiewoningen</title>
</head>

<body>

<?php include_once "includes/header.php"?>


<?php foreach ($html as $row) {
?>
    

        <?php echo $row; ?>



<?php
    }
    ?>

    <script>
    function gotodetails(getheader) {
        window.location.replace("detail.php?woning=" + getheader);
    } 
    </script>

</body>
<?php  include_once "includes/footer.php"?>

</html>