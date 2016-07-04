<?php
/*
 * Simple script for logging user out
 * Austin - [2015-04-27]
 */

session_start();
unset($_SESSION['username']);
unset($_SESSION['usertype']);
header("refresh:0; url=/UconnJobSearch/index.php");

?>