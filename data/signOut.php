<?php
session_start();
session_destroy();
$currentUser = null;

header("Location: ../index.php");

?>


