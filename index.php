<?php
session_start();
if(isset($_SESSION['zalogowany'])){
    if(file_exists('header.php')) include ('header.php');
    if(file_exists('middleIndex.php')) include ('middleIndex.php');
    if(file_exists('footer.php')) include ('footer.php');
}
else
header('Location: rejestracja.php');
?>