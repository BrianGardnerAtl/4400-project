<?php

//establish link to the database
define ("DB_HOST", "localhost");//Host name
define ("DB_USER", "cs4400_group2");//mysql username
define ("DB_PASS", "WwqP0LFf");//mysql password
define ("DB_NAME", "cs4400_group2");//database name

//Connect to the server and select the database
$conn = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Could not connect!");
$db = mysql_select_db(DB_NAME, $conn) or die("Could not connect to database");

?>
