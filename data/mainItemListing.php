<?php
session_start();
require "db.php";
require "currentUser.php";
require "navigationBar.php";

$sel = $db->prepare("SELECT * FROM PLACE ORDER BY CITY DESC");
$sel->execute();
$places = $sel->fetchAll();

$sel = $db->prepare("SELECT DISTINCT CITY FROM PLACE ORDER BY CITY DESC");
$sel->execute();
$cities = $sel->fetchAll();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Výletář</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/loggedInStyle.css" media="screen" />
  </head>
  <body>
    <div id="boxContent">
        <?php foreach ($cities as $city) { ?>
          <div id="box">
            <p><?php echo $city[0]; ?></p>
          </div>
      <?php } ?>
    </div>

  </body>
</html>
