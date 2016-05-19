<?php
session_start();
require "db.php";
require "currentUser.php";
require "navigationBar.php";
//URL promene
$creator = $_GET["creator"];
$currentEvent = $_GET["currentEvent"];
$currentEventNumber = $_GET["currentEventNumber"];
$currentUserNumber = $_SESSION["user_id"];

$sel = $db->prepare("SELECT * FROM EVENTS "
        . "left join PLACE using(PLACE_NUMBER) join USERS using(USER_NUMBER)"
        . " WHERE USERS.NAME = ? and EVENTS.EVENT_NUMBER = ?");
$sel->execute(array($creator, $currentEventNumber));
$events = $sel->fetchAll();
$event = $events[0]; //vzdy bude jen jeden event
//event variables
$creatorUserNumber = $event["USER_NUMBER"];
$placeName = $event[6];
$city = $event["CITY"];
$address = $event["ADDRESS"];
$description = $event["DESCRIPTION"];

if ($description == null) {
    $description = "Neurčeno";
}

$time = $event["TIME"];
if ($time == "0000-00-00") {
    $time = "Neurčeno";
}

//check jestli vlastnime udalost
$owner = null;
if ($creatorUserNumber == $currentUserNumber) {
    $owner = true;
} else {
    $owner = false;
    //$sel = $db->prepare("SELECT NAME FROM USERS join ATTEND using(USER_NUMBER) WHERE");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_time = $_POST["time"];
    $_description = $_POST["description"];

    if ($_description == "Neurčeno") {
        $_description = null;
    }

    $sel = $db->prepare("SELECT * FROM EVENTS "
            . "left join PLACE using(PLACE_NUMBER) join USERS using(USER_NUMBER)"
            . " WHERE USERS.NAME = ? and EVENTS.EVENT_NUMBER = ?");
    $sel->execute(array($creator, $currentEventNumber));
    $events = $sel->fetchAll();
    $event = $events[0];

    if ($event != null) {
        $sel = $db->prepare("UPDATE EVENTS SET TIME = ?, DESCRIPTION = ? where EVENT_NUMBER = ?");
        $sel->execute(array($_time, $_description, $currentEventNumber));
    }

    header("Location: eventDetail.php?creator=" . $creator . "&currentEvent=" . $currentEvent . "&currentEventNumber=" . $currentEventNumber);
}
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
        <h1><?php echo $currentEvent;//var_dump($event);?></h1>
      </div>
      <div id="boxContent">
        <form method="POST" style="padding-top: 20px;">
          <span>
            <input id="lb" type="text" disabled placeholder="Název místa konání akce"></input>
          </span>
          <span>
            <input type="text" disabled placeholder="<?php echo $placeName; ?>" name="placeName" required="required"/>
          </span>

          <span>
            <input id="lb" type="text" disabled placeholder="Město konání akce"></input>
          </span>
          <span>
            <input type="text" disabled placeholder="<?php echo $city; ?>" name="city" required="required"/>
          </span>

          <span>
            <input id="lb" type="text" disabled placeholder="Adresa"></input>
          </span>
          <span>
            <input type="text" disabled placeholder="<?php echo $address; ?>" name="address" required="required"/>
          </span>

          <span>
            <input id="lb" type="text" disabled placeholder="Datum"></input>
          </span>
          <span>
            <input type="date" <?php if (!$owner) { echo "disabled"; } else { echo 'style="border: 1px solid greenyellow;"'; }?> value="<?php echo $time; ?>" name="time" required="required"/>
          </span>

          <span>
            <input id="lb" type="text" disabled placeholder="Popis"></input>
          </span>
          <span>
            <input type="text" <?php if (!$owner) { echo "disabled"; } else { echo 'style="border: 1px solid greenyellow;"'; }?> value="<?php echo $description; ?>" name="description" required="required"/>
          </span>

          <span>
            <input id="lb" type="text" disabled placeholder="Vytvořil: "></input>
          </span>
          <span>
            <input type="text" disabled placeholder="<?php echo $creator; ?>" required="required"/>
          </span>
          <?php if ($owner) { ?>
              <div class="event" id="changeDiv">
                <input id="changeBtn" type="submit" value="Změnit">
              </div>
              <div class="event" id="deleteDiv">
                <a class="del" href="<?php echo "deleteEvent.php?creator=" . $creator . "&currentEvent=" . $currentEvent . "&currentEventNumber=" . $currentEventNumber ?>" id="delete" value="Smazat" style="color:black;">Smazat</a>
              </div>
          <?php } else {
              $sel = $db->prepare("SELECT * FROM ATTEND WHERE USER_NUMBER = ? and EVENT_NUMBER = ?");
              $sel->execute(array($currentUserNumber, $currentEventNumber));
              $attends = $sel->fetchAll();
              if ($attends == null) { ?>
              <div class="event" id="eventBox">
                <a class="event" href="<?php echo "joinEvent.php?currentEventNumber=" . $currentEventNumber ?>">Přihlásit se</a>
              </div>
              <?php } else{ ?>
                <div class="event" id="eventBox">
                    <a class="event" href="<?php echo "withdrawFromEvent.php?currentEventNumber=" . $currentEventNumber ?>">Odhlásit se</a>
              </div>
              <?php } ?>
              <div class="event" id="eventBox">
                <a class="event" href="javascript:history.go(-1)" style="color:black;">Zpět</a>
              </div>
          <?php } ?>
        </form>
      </div>
    </div>
  </body>
</html>