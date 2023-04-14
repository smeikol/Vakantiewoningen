<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<?php include_once "includes/header.php"?>


<main>
        <div class="content">
            <section class="hero">
                <h1>Welkom bij onze Vakantie Woningen</h1>
                <p>Wij zijn een makelaars bedrijf dat huizen verkoopt van alle soorten en maaten</p>
                <button></button>
            </section>
            <section class="services">
                <p></p>
                <h3>De website voor uw vakantie woningen!</h3>

            </section>
        </div>
    </main>
<?php  include_once "includes/footer.php"?>



</body>
<script>
    window.onscroll = function() {
        myFunction()
    };

    let navbar = document.getElementById("navbar");
    let sticky = navbar.offsetTop;

    function myFunction() {
        if (window.pageYOffset >= sticky) {
            navbar.classList.add("sticky")
        } else {
            navbar.classList.remove("sticky");
        }
    }

</script>

</html>