<?php
session_start();
require "db.php";
require "currentUser.php";
require "navigationBar.php";

$sel = $db->prepare("SELECT distinct city, COUNT(*) FROM `EVENTS` left join PLACE using(PLACE_NUMBER) GROUP BY CITY ORDER BY CITY DESC");
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
    <div id="wrapper">
      <div id="contentLine">
        <h1>Události ve městech</h1>
      </div>
    </div>
    <div id="boxContent">
        <?php foreach ($cities as $city) {?>
          <div id="cityBox">
            <a class="city" href="cityEventsDetail.php?currentCity=<?php echo $city[0];?>"><?php echo $city[0]; echo "<br>Aktivní události: "
            . $city[1];
            ?></a>
          </div>
<?php } ?>
    </div>

  </body>
</html>
