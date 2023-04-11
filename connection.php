<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "vrij_wonen";

if(!$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{

	die("failed to connect!");
}
