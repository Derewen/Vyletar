<?php
session_start();
require "db.php";
require "currentUser.php";
require "navigationBar.php";

$sel = $db->prepare("SELECT * FROM EVENTS "
        . "left join PLACE using(PLACE_NUMBER) join USERS using(USER_NUMBER)"
        . " WHERE USER_NUMBER = ?");
$sel->execute(array($_SESSION["user_id"]));
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
        <h1><?php echo "Moje události"; ?></h1>
      </div>
    </div>
    <div id="boxContent">
        <?php
        if (count($events) != 0) {
            foreach ($events as $event) {
                ?>
              <div id="eventBox">
                <a class="event" href="eventDetail.php?creator=<?php echo $event[9] . "&currentEvent=" . $event[3]; ?>">
                  <div style="position:relative;">
                    <span style="position:absolute; top:0px; left:25px;"><?php echo $event[3]; ?></span>
                    <span><?php echo $event[6]; ?></span>
                    <span style="position:absolute; top:0px; right:25px;"><?php echo $event[7]; ?></span>
                  </div>
                </a>
              </div>
          <?php
          }
      } else { ?>
           <div id="eventBox">
             <a class="event" href="newEvent.php">Nová akce</a></li>
           </div>
          <?php }
      ?>
    </div>
  </body>
</html>


