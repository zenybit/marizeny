<?php
// Include at the top of every protected page
session_start();
if (!isset($_SESSION["Studentid"])) {
    header("Location: login.php");
    exit();
}
include "database.php";