<?php
session_start();
require "db.php";
require "currentUser.php";

$sel = $db->prepare("select * from EVENTS where EVENT_NUMBER = ?");
$sel->execute(array($_GET["currentEventNumber"]));
$event = $sel->fetchAll();
if ($event != null) {
    $sel = $db->prepare("DELETE FROM ATTEND where EVENT_NUMBER = ? and USER_NUMBER = ? and PRIVILEGES = ?");
    $sel->execute(array($_GET["currentEventNumber"], $_SESSION["user_id"], 2));
}

header("Location: mainItemListing.php");
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Výletář</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/loggedInStyle.css" media="screen" />
  </head>
  <body>
  </body>
</html>
