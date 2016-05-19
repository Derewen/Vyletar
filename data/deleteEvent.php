<?php
session_start();
require "db.php";
require "currentUser.php";

$sel = $db->prepare("DELETE FROM EVENTS WHERE EVENT_NUMBER = ?");
$sel->execute(array($_GET["currentEventNumber"]));

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