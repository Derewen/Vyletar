<?php
session_start();
require "db.php";
require "currentUser.php";
require "navigationBar.php";

$currentCity = $_GET["currentCity"];
if (!isset($currentCity)) {
    header("Location: mainItemListing.php");
}
$sel = $db->prepare("SELECT * FROM EVENTS "
        . "left join PLACE using(PLACE_NUMBER) join USERS using(USER_NUMBER)"
        . " WHERE CITY = ?");
$sel->execute(array($currentCity));
$events = $sel->fetchAll();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Výletář</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/loggedInStyle.css" media="screen" />
  </head>
  <body>
    <div id="wrapper">
      <div id="contentLine">
        <h1><?php echo $currentCity; ?></h1>
      </div>
    </div>
    <div id="boxContent">
        <?php foreach ($events as $event) { ?>
          <div id="eventBox">
            <a class="event" href="eventDetail.php?creator=<?php echo $event[9] . "&currentEvent=" . $event[3]; ?>">
              <div style="position:relative;">
                <span style="position:absolute; top:0px; left:25px;"><?php echo $event[3]; ?></span>
                <span><?php echo $event[6]; ?></span>
                <span style="position:absolute; top:0px; right:25px;"><?php
                    if($event[9] != "admin" ) {
                        echo "Vytvořil: " . $event[9];
                    } else {
                        echo $event[7];
                    }
                ?></span>
              </div>
            </a>
          </div>
      <?php } ?>
      <div class="event" id="eventBox">
        <a class="event" href="mainItemListing.php" style="color:black;">Zpět</a>
      </div>
    </div>
  </body>
</html>

