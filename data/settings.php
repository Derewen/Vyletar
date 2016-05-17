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
          <input type="password" placeholder="Staré Heslo" name="oldPwd" required="required"/><br>
          <input type="password" placeholder="Nové Heslo" name="newPwd" required="required"/><br>
          <input type="submit" value="Změnit heslo"/>
        </form>
      </div>
    </div>
  </body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $oldPwd = $_POST["oldPwd"];
    $newPwd = $_POST["newPwd"];
    $strEqual = strcmp($oldPwd, $newPwd);
    if (!password_verify($oldPwd, $currentUser["PASSWORD"])) {
        echo "<script language='javascript'>";
        echo "alert('Špatné heslo.')";
        echo "</script>";
    }
    else if ($strEqual == 0) {
        echo "<script language='javascript'>";
        echo "alert('Prosím zadejte jiné, než původní heslo.')";
        echo "</script>";
    } else {
        $hashedNew = password_hash($newPwd, PASSWORD_DEFAULT);
        $upd = $db->prepare("UPDATE USERS SET PASSWORD = ? WHERE  EMAIL = ?");
        $upd->execute(array($hashedNew, $currentUser["EMAIL"]));

        echo "<script language='javascript'>";
        echo "alert('Heslo změněno.')";
        echo "</script>";
    }
}
?>
