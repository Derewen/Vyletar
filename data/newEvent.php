<?php
session_start();
require "db.php";
require "currentUser.php";
require "navigationBar.php";
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
      <div id="content">
        <form method="POST">
          <input type="text" class="req" placeholder="Název akce" name="eventName" required="required"/><br>
          <input type="text" class="req" placeholder="Název místa konání akce" name="placeName" required="required"/><br>
          <input type="text" class="req" placeholder="Město konání akce" name="city" required="required"/><br>
          <input type="text" class="req" placeholder="Adresa konání akce" name="address" required="required"/><br>
          <input type="date" name="time"/><br>
          <textarea rows="2" cols="47" name="description" placeholder="Popis události a dodatečné informace."></textarea><br>
          <input type="submit" value="Vytvořit událost"/>
        </form>
      </div>
    </div>
  </body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventName = $_POST["eventName"];
    $placeName = $_POST["placeName"];
    $city = $_POST["city"];
    $address = $_POST["address"];
    $time = $_POST["time"];
    $description = $_POST["description"];
    $userNumber = $_SESSION["user_id"];

    function selectPlace($name, $address, $city) {
        include "db.php";
        $sel = $db->prepare("SELECT * FROM PLACE WHERE NAME = ? and ADDRESS = ? and CITY = ?");
        $sel->execute(array($name, $address, $city));
        return @$sel->fetchAll()[0];
    }

    //check jestli akce s danymi parametry existuje, propojeni tabulek
    function checkForEvent($userNumber, $eventName, $time, $description, $placeNumber) {
        include "db.php";
        $sel = $db->prepare("SELECT * FROM EVENTS JOIN ATTEND using(EVENT_NUMBER) WHERE EVENTS.USER_NUMBER = ? "
                . "and NAME = ? and TIME = ? and DESCRIPTION = ? and PLACE_NUMBER = ?");
        $sel->execute(array($userNumber, $eventName, $time, $description, $placeNumber));
        return @$sel->fetchAll()[0];
    }

    $place = selectPlace($placeName, $address, $city);
    //zalozeni noveho mista
    if ($place == null) {
        $sel = $db->prepare("INSERT INTO PLACE(NAME, ADDRESS, CITY) VALUES (?, ?, ?)");
        $sel->execute(array($placeName, $address, $city));
        //nove nacteni prave vlozeneho mista vcetne id
        $place = selectPlace($placeName, $address, $city);
    }

    $event = checkForEvent($userNumber, $eventName, $time, $description, $place["PLACE_NUMBER"]);
    //zalozeni nove akce, pokud takovou akci jeste nemame vytvorenou (akci se stejnymi parametry muze mit jen jiny vlastnik)
    if ($event == null) {
        $sel = $db->prepare("INSERT INTO EVENTS(USER_NUMBER, PLACE_NUMBER, NAME, TIME, DESCRIPTION) VALUES (?, ?, ?, ?, ?)");
        $sel->execute(array($userNumber, $place["PLACE_NUMBER"], $eventName, $time, $description));
        $eventNumber = $db->lastInsertId("EVENT_NUMBER");
        //propojeni M:N
        $sel = $db->prepare("INSERT INTO ATTEND(EVENT_NUMBER, USER_NUMBER, PRIVILEGES) VALUES (?, ?, ?)");
        $sel->execute(array($eventNumber, $userNumber, 1));
    } else {
        echo "<script language='javascript'>";
        echo "alert('Tuto akci již máte vytvořenou.')";
        echo "</script>";
    }
}
?>