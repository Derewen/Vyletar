<?php
session_start();
require "data/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $pwd = $_POST["password"];

    $stmt = $db->prepare("SELECT * FROM USERS WHERE EMAIL = ? LIMIT 1");
    $stmt->execute(array($email));
    $existingUser = @$stmt->fetchAll()[0];
            if(password_verify($pwd, $existingUser["PASSWORD"])) {
                $_SESSION["user_id"] = $existingUser["USER_NUMBER"];
                header("Location: index.php");
            } else {
                echo "<div style='text-align: center; margin-top:170px;'>
                        <label id='warningLb'>
                            Username or Password incorrect.
                        </label>
                      </<div>";
            }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Výletář</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
  </head>
  <body>
    <div class="logo">
        <img src="resources/TripOut.png" alt="Logo" height="129" width="489">
    </div>
    <div class="login">
      <form method="POST">
        <input
            type="text"
            name="email" id="email"
            placeholder="Email"
            required="required"
            />
        <input
            type="password"
            name="password" id="password"
            placeholder="Password"
            required="required"
            />
        <input
            type="submit" id="submit" onclick="" value="Login"
            />
      </form>
    </div>

    <div class="signUp">
      <h1>Ještě nemáš účet? Zaregistruj se!</h1>
      <input type="button"
             name="registrationButton"
             value="Registrace"
             onclick="location.href='data/signUp.php'"
             id="regBtn"
             />
    </div>
  </body>
</html>
