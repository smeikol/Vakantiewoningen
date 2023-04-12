<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/contact.css">
    <title>Contact | Vakantiewoningen</title>
</head>

<body>
<?php include_once "includes/header.php" ?>

<main>

</main>
<br>
<div class="form">
    <h1>Contact</h1>
    <br>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div id="first">
            <input type="text" placeholder="Naam">
        </div>
        <div id="second">
            <input type="text" id="input_links" placeholder="Email">
        </div>

        <div id="derde">
            <input id="onderwerp" type="text" id="input_derde" placeholder="Onderwerp">
        </div>
        <div id="vierde">
            <textarea rows="4" cols="50" id="textarea" placeholder="Bericht"></textarea>
        </div>
        <div id="submitdiv">
            <input id="submit" type="submit">
        </div>
    </form>
</div>
<?php include_once "includes/footer.php" ?>
</body>

</html>