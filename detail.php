<?php
include_once 'connection.php';


$sql = "SELECT * FROM `vw_woningen` WHERE `woningnummer` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $_GET['woning']);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_array()) {
    $html[0] = '<div class="images"><img src="' . $row["afbeelding1"] . '" height="200px" width="200px">';
    $html[1] = '<img src="' . $row["afbeelding2"] . '" height="200px" width="200px">';
    $html[2] = '<img src="' . $row["afbeelding3"] . '" height="200px" width="200px">';
    $html[3] = '<img src="' . $row["afbeelding4"] . '" height="200px" width="200px">';
    $html[4] = '<img src="' . $row["afbeelding5"] . '" height="200px" width="200px"></div> <br>';
    $html[5] = '<div class="info"><div id="adres" class="adres" >' . $row['adres'] . '</div> <br>';
    $html[6] = '<div class="postcode"><span>postcode: </span>' . $row['postcode'] . '</div> <br>';
    $html[7] = '<div class="plaats"><span>plaats: </span>' . $row['plaats'] . '</div> <br>';
    $html[8] = '<div> <span>De prijs is: </span>€' . number_format($row["prijs"], 2, ",", ".") . '</div> <br>';
    $html[9] = '<div> <span>Omschrijving: </span>' . $row['omschrijving'] . '</div> <br>';
    $html[10] = '<div> <span> verkocht: </span> ' . $row['verkocht'] . '</div> <br>';
    $html[11] = '<div> <span>liggingen zijn:</span> </div>     <br>';
}
$counter = 11;

$sql2 = "SELECT liggingen_id FROM `vw_liggingen` WHERE `VW_woningen_woningnummer` = ?";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param('i', $_GET['woning']);
$stmt2->execute();
$result2 = $stmt2->get_result();

while ($row = $result2->fetch_array()) {
    $sql3 = "SELECT ligging_omschrijving FROM `vw_liggingen_omschrijving` WHERE `id` = ?";
    $stmt3 = $conn->prepare($sql3);
    $stmt3->bind_param('i', $row['liggingen_id']);
    $stmt3->execute();
    $result3 = $stmt3->get_result();

    while ($row2 = $result3->fetch_array()) {
        $counter = $counter + 1;
        $html[$counter] = '<div> -' . $row2['ligging_omschrijving'] . '</div> <br>';
    }
}

$counter = $counter + 1;
$html[$counter] = '<div> <span>eigenschappen zijn:</span> </div> <br>';

$sql4 = "SELECT VW_eigenschappen_id FROM `vw_eigenschappen` WHERE `VW_woningen_woningnummer` = ?";
$stmt4 = $conn->prepare($sql4);
$stmt4->bind_param('i', $_GET['woning']);
$stmt4->execute();
$result4 = $stmt4->get_result();

while ($row = $result4->fetch_array()) {
    $sql5 = "SELECT eigenschappen FROM `vw_eigenschappen_lijst` WHERE `id` = ?";
    $stmt5 = $conn->prepare($sql5);
    $stmt5->bind_param('i', $row['VW_eigenschappen_id']);
    $stmt5->execute();
    $result5 = $stmt5->get_result();

    while ($row2 = $result5->fetch_array()) {
        $counter = $counter + 1;
        $html[$counter] = '<div> -' . $row2['eigenschappen'] . '</div> <br>';
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Details</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/detail.css">

</head>

<body>
    <div id="content">
        <div class="detail">
            <?php include_once "includes/header.php" ?>

            <?php foreach ($html as $row) {
                echo $row;
            }
            ?>
            <button type="submit" id="submit" onclick="generatePDF()">Download PDF</button>
        </div>
    </div>
    <br>
    <br>
</body>

<script>
    function generatePDF() {

        let adres = document.getElementById("adres").value;

        const element = document.getElementById('content');
        const opt = {
            margin: [-19, 0, 0, 0],
            filename: 'Vrijwonen.pdf',
            image: {
                type: 'jpeg',
                quality: 1,
            },
            html2canvas: {
                scale: 2,
                y: 50,
                x: 50,
                scrollY: 50,
                scrollX: 50,
                windowWidth: 800,

            },
            jsPDF: {
                unit: 'px',
                format: 'a4',
                orientation: 'p',
                hotfixes: ['px_scaling']
            }
        };
        html2pdf().set(opt).from(element).save();
    }
</script>

</html>