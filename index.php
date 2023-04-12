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
                <h1>Welcome to Our Website</h1>
                <p>We are a company that specializes in providing high-quality products and services to our customers.</p>
                <button>Learn More</button>
            </section>
            <section class="services">
                <h2>Our Services</h2>
                <p>Here are some of the services that we offer:</p>
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