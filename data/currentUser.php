<?php
if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
    die();
}

$ses = $db->prepare("SELECT * FROM USERS WHERE USER_NUMBER = ? LIMIT 1");
$ses->execute(array($_SESSION["user_id"]));

$currentUser = $ses->fetchAll()[0];

if(!$currentUser) {
    session_destroy();
    header("Location: ../index.php");
    die();
}

?>