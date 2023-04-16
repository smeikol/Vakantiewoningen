<?php
include_once 'connection.php';
$counter = 0;
$EIGENSCHAPPENLIST = [];
$LIGGINGENLIST = [];
$WONINGLIST = array();
$TMPLIST = array();
$sql = "SELECT `woningnummer`, `adres`, `plaats`, `afbeelding1` FROM `vw_woningen`";

if (isset($_GET['search']) && ($_GET['adres'] || $_GET['postcode'] || $_GET['plaats'] || $_GET['prijs'] || $_GET['verkocht'] || isset($_GET['Eigenschappen']) || isset($_GET['Liggingen']))) {


    $sql = [];
    $parameters = [];
    $SQLIDS = [];
    $IDS = [];

    if ($_GET['adres']) {
        $sql[] = "`adres` LIKE ? ";
        $parameters[] = "%" . $_GET['adres'] . "%";
    }

    if ($_GET['postcode']) {
        $sql[] = "`postcode` LIKE ? ";
        $parameters[] = "%" . $_GET['postcode'] . "%";
    }

    if ($_GET['plaats']) {
        $sql[] = "`plaats` LIKE ? ";
        $parameters[] = "%" . $_GET['plaats'] . "%";
    }

    if ($_GET['prijs']) {
        $sql[] = "`prijs` LIKE ? ";
        $parameters[] = "%" . $_GET['prijs'] . "%";
    }

    if ($_GET['verkocht']) {
        $sql[] = "`verkocht` LIKE ? ";
        $parameters[] = "%" . $_GET['verkocht'] . "%";
    }


    if (isset($_GET['Eigenschappen'])) {
        foreach ($_GET['Eigenschappen'] as $key) {
            $TMPLIST = [];
            $stmt = $conn->prepare("SELECT * FROM `vw_eigenschappen` WHERE `VW_eigenschappen_id` = ?");

            $RESULT = $stmt->bind_param("i", $key);
            if ($RESULT == false) {
                die("Secured");
            }

            $RESULT = $stmt->execute();
            if ($RESULT == false) {
                die("Secured");
            }

            $RESULT = $stmt->get_result();
            if (isset($EIGENSCHAPPENLIST[0])) {
                while ($ROW = $RESULT->fetch_array()) {
                    for ($i = 0; $i < count($EIGENSCHAPPENLIST); $i++) {
                        if ($EIGENSCHAPPENLIST[$i] == $ROW['VW_woningen_woningnummer']) {
                            $TMPLIST[] = $ROW['VW_woningen_woningnummer'];
                        }
                    }
                }
                $EIGENSCHAPPENLIST[] = $TMPLIST;
            } else {
                while ($ROW = $RESULT->fetch_array()) {
                    $EIGENSCHAPPENLIST[] = $ROW['VW_woningen_woningnummer'];
                }
            }
        }
    }

    if (isset($_GET['Liggingen'])) {
        foreach ($_GET['Liggingen'] as $key) {
            $TMPLIST = [];
            $stmt = $conn->prepare("SELECT * FROM `vw_liggingen` WHERE `liggingen_id` = ?");

            $RESULT = $stmt->bind_param("i", $key);
            if ($RESULT == false) {
                die("Secured");
            }

            $RESULT = $stmt->execute();
            if ($RESULT == false) {
                die("Secured");
            }

            $RESULT = $stmt->get_result();
            if (isset($LIGGINGENLIST[0])) {
                while ($ROW = $RESULT->fetch_array()) {
                    for ($i = 0; $i < count($LIGGINGENLIST); $i++) {
                        if ($LIGGINGENLIST[$i] == $ROW['VW_woningen_woningnummer']) {
                            $TMPLIST[] = $ROW['VW_woningen_woningnummer'];
                        }
                    }
                }
                unset($LIGGINGENLIST);
                $LIGGINGENLIST = $TMPLIST;
            } else {
                while ($ROW = $RESULT->fetch_array()) {
                    $LIGGINGENLIST[] = $ROW['VW_woningen_woningnummer'];
                }
            }
        }
    }

    if ($EIGENSCHAPPENLIST && $LIGGINGENLIST) {
        $TMPLIST = [];
        for ($i = 0; $i < count($EIGENSCHAPPENLIST); $i++) {
            for ($j = 0; $j < count($LIGGINGENLIST); $j++) {
                if ($LIGGINGENLIST[$j] == $EIGENSCHAPPENLIST[$i]) {
                    $TMPLIST[] = $LIGGINGENLIST[$j];
                }
            }
        }
        $WONINGLIST = $TMPLIST;
    } else if ($EIGENSCHAPPENLIST) {
        $TMPLIST = [];
        for ($i = 0; $i < count($EIGENSCHAPPENLIST); $i++) {
            $TMPLIST[] = $EIGENSCHAPPENLIST[$i];
        }
        $WONINGLIST = $TMPLIST;
    } else if ($LIGGINGENLIST) {
        $TMPLIST = [];
        for ($i = 0; $i < count($LIGGINGENLIST); $i++) {
            $TMPLIST[] = $LIGGINGENLIST[$i];
        }
        $WONINGLIST = $TMPLIST;
    }

    if ($WONINGLIST) {
        foreach ($WONINGLIST as $key) {
            $IDS[] = $key;
            $SQLIDS[] = "?";
        }
    }
    $query = "SELECT * FROM `vw_woningen`";

    if ($sql) {
        $query .= ' WHERE ' . implode(' AND ', $sql);
    } else if (!$sql) {
        $query .= ' WHERE `woningnummer` in (' . implode(', ', $SQLIDS) . ')';
    }

    if ($IDS && $sql) {
        $query .= ' AND `woningnummer` in (' . implode(', ', $SQLIDS) . ')';
    }

    $stmt = $conn->prepare($query);

    if ($parameters || $IDS) {
        $stmt->bind_param(str_repeat('s', count($sql)) . str_repeat("i", count($IDS)), ...$parameters, ...$IDS);
    }
    $stmt->execute();
    $result = $stmt->get_result();






    // $sql = 'SELECT `woningnummer`, `adres`, `plaats`, `afbeelding1` 
    // FROM `vw_woningen` 
    // WHERE `adres` LIKE ? OR
    // `postcode` LIKE ? OR
    // `plaats` LIKE ? OR
    // `prijs` LIKE ? OR
    // `verkocht` LIKE ?';
    // echo $sql;
    // $stmt = $conn->prepare($sql);
    // $adr = checkempt('adres');
    // $po = checkempt('postcode');
    // $pl = checkempt('plaats');
    // $prijs = checkempt('prijs');
    // $ver = checkempt('verkocht');
    // $stmt->bind_param('sssss', $adr, $po, $pl, $prijs, $ver);
    // $stmt->execute();
    // $result = $stmt->get_result();

    // if ($result->num_rows == 0 && !isset($_GET['Eigenschappen'])) {
    //     header('Location: overzicht.php');
    // }

    // if (isset($_GET['Eigenschappen'])) {
    //     foreach ($_GET['Eigenschappen'] as $key) {
    //         $stmt = $conn->prepare("SELECT * FROM `vw_eigenschappen` WHERE `VW_eigenschappen_id` = ?");

    //         $RESULT = $stmt->bind_param("i", $key);
    //         if ($RESULT == false) {
    //             die("Secured");
    //         }

    //         $RESULT = $stmt->execute();
    //         if ($RESULT == false) {
    //             die("Secured");
    //         }

    //         $RESULT = $stmt->get_result();
    //         if (isset($WONINGLIST[0])) {
    //             while ($ROW = $RESULT->fetch_array()) {
    //                 for ($i = 0; $i < count($WONINGLIST); $i++) {
    //                     if ($WONINGLIST[$i] == $ROW['VW_woningen_woningnummer']) {
    //                         $TMPLIST[] += $ROW['VW_woningen_woningnummer'];
    //                     }
    //                 }
    //             }
    //             $WONINGLIST = $TMPLIST;
    //         } else {
    //             while ($ROW = $RESULT->fetch_array()) {
    //                 $WONINGLIST[] += $ROW['VW_woningen_woningnummer'];
    //             }
    //         }
    //     }
    // }
    $stmt->close();
} else {
    $sql = "SELECT `woningnummer`, `adres`, `plaats`, `afbeelding1` FROM `vw_woningen`";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
}


while ($row = $result->fetch_array()) {
    $html[$counter] = '<div class="card" onclick="gotodetails(' . $row["woningnummer"] . ')"> <img class="image" src="' . $row["afbeelding1"] . '" height="225px" width="225px"> <p class="card-text">' . $row["adres"] . ' </p>  <p class="card-text">' . $row["plaats"] . ' </p></div>';
    $counter = $counter + 1;
}

function checkempt($needcheck)
{
    if ($_GET[$needcheck] == "") {
        $returnvalue = "_";
    } else {
        $returnvalue = '%' . $_GET[$needcheck] . '%';
    }
    return $returnvalue;
}

$stmt = $conn->prepare("SELECT * FROM `vw_eigenschappen_lijst`");
if ($stmt == false) {
    die("Secured");
}

$RESULTEIGENSCHAPPEN = $stmt->execute();
if ($RESULTEIGENSCHAPPEN == false) {
    die("Secured");
}

$RESULTEIGENSCHAPPEN = $stmt->get_result();
$stmt->close();

$stmt = $conn->prepare("SELECT * FROM `vw_liggingen_omschrijving`");
if ($stmt == false) {
    die("Secured");
}

$RESULTLIGGINGEN = $stmt->execute();
if ($RESULTLIGGINGEN == false) {
    die("Secured");
}

$RESULTLIGGINGEN = $stmt->get_result();
$stmt->close();

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



    <?php include_once "includes/header.php" ?>
    <div class="row">

        <?php foreach ($html as $row) {
        ?>


            <?php echo $row; ?>



        <?php
        }
        ?>
    </div>
    <form action="" method="GET">
        <label>plaats</label> <br>
        <input type="text" name="plaats" placeholder="plaats"> <br>
        <label>postcode</label> <br>
        <input type="text" name="postcode" placeholder="postcode.."> <br>
        <label>adres</label> <br>
        <input type="text" name="adres" placeholder="adres.."> <br>
        <label>prijs</label> <br>
        <input type="text" name="prijs" placeholder="prijs.."> <br>
        <label>verkocht</label> <br>
        <input type="text" name="verkocht" placeholder="verkocht.."> <br>
        <input id="submit" type="submit" name="search" value="submit" placeholder="Submit">
        <br>
        <label>Eigenschappen</label>
        <br>
        <div class="formFooter">
            <?php $COUNT = 1;
            while ($ROW = $RESULTEIGENSCHAPPEN->fetch_array()) : ?>
                <label for="Eigenschappen<?php echo $ROW['id'] ?>">
                    <?php echo $ROW['eigenschappen'] ?><input id="Eigenschappen<?php echo $ROW['id'] ?>" type="checkbox" name="Eigenschappen[<?php echo $COUNT ?>]" value="<?php echo $ROW['id'] ?>">
                </label>
                <br>
            <?php $COUNT++;
            endwhile ?>
        </div>
        <br>
        <label>Liggingen</label>
        <br>
        <div class="formFooter">
            <?php $COUNT = 1;
            while ($ROW = $RESULTLIGGINGEN->fetch_array()) : ?>
                <label for="Liggingen<?php echo $ROW['id'] ?>">
                    <?php echo $ROW['ligging_omschrijving'] ?><input id="Liggingen<?php echo $ROW['id'] ?>" type="checkbox" name="Liggingen[<?php echo $COUNT ?>]" value="<?php echo $ROW['id'] ?>">
                </label>
                <br>
            <?php $COUNT++;
            endwhile ?>
        </div>
    </form>

    <script>
        function gotodetails(getheader) {
            window.location.replace("detail.php?woning=" + getheader);
        }
    </script>

</body>
<?php include_once "includes/footer.php" ?>

</html>