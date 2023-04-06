<?php

$dbhost = "localhost";
$dbuser = "mr.woning";
$dbpass = "topgs";
$dbname = "vrij_wonen";

if(!$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{

	die("failed to connect!");
}
